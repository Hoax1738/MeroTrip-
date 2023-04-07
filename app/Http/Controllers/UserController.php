<?php

namespace App\Http\Controllers;
use App\User;
use App\Khalti;
use App\Packages;
use App\Payments;
use App\Mail\SendMail;
use App\UserBalanceSheet;
use App\ImePay;
use App\Image;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('customer');
    }
    public function payments(){
        $breadcrumb = 'Payments';

        $request=Request();
        $payments = User::myPayments($request,Auth::user()->id);

        $title=User::myPackageField('packages.title',Auth::user()->id);
        $type=User::myPackageField('invoice.type',Auth::user()->id);
        $method=User::myPackageField('method',Auth::user()->id);

        $setValue=[
            'title'=>$request->title?$request->title:'',
            'type'=>$request->type?$request->type:'',
            'method'=>$request->method?$request->method:'',
        ];

        return view('contents.payments',['payments'=>$payments,'title'=>$title,'method'=>$method,'type'=>$type,'setValue'=>$setValue,'breadcrumb'=>$breadcrumb]);
    }

    public function paymentsPdf(){
        $request=Request();
        $payments = User::myPayments($request,Auth::user()->id);
        $title=User::myPackageField('packages.title',Auth::user()->id);
        $type=User::myPackageField('invoice.type',Auth::user()->id);
        $method=User::myPackageField('method',Auth::user()->id);
        return view('contents.payments_pdf',compact('payments','title','method','type'));
    }

    public function singlePayment($package_id){
        $request=Request();
        $payments = User::myPayments($request,Auth::user()->id,$package_id);
        $title=User::myPackageField('packages.title',Auth::user()->id);
        $type=User::myPackageField('invoice.type',Auth::user()->id);
        $method=User::myPackageField('method',Auth::user()->id);
        return view('contents.payments_pdf',compact('payments','title','method','type'));
    }
    public function account(){
        $breadcrumb = 'Account';
        $user = User::where('id',Auth::user()->id)->first();
        $commited_package = DB::table('commits')->where('user_id',Auth::user()->id)->count();

        return view('contents.account',compact('breadcrumb','user','commited_package'));
    }
    public function pay(Request $request){
        $path = "default";
        if($request->input('clickref') != ""){
            $commitment_id = $request->input('clickref');
            $path = key($request->input('post'));
            $commitInfo = User::singleCommitInfo($commitment_id);
            $payments_made = User::paymentsForSingleCommit($commitment_id,array('general','down_payment','installment'));
            $remaining = $commitInfo->travellers * $commitInfo->price_per_traveller - $payments_made;
            $generalAmount=$request->input('amount');

            $referer= Auth::user()->referrer;

            // dd($referer);

            $bonus=($commitInfo->travellers*$commitInfo->price_per_traveller)*0.05;

        }
        switch($path){
            case "advance":
                $breadcrumb='Advanced Payment';
                $last_paid = User::lastPaid($commitment_id);
                $futureemi = Packages::futureEMI($remaining, $last_paid->due, $commitInfo->commence_date);
                $last_payment = end($futureemi);

                // ime pay

                if($remaining<$futureemi[0][1]){
                    $amount=$remaining;
                }else {
                    $amount=$futureemi[0][1];
                }
                $rand=random_int(1000, 9999);

                $user_id=auth()->user()->id;

                $refId="Ref-$commitInfo->id-$user_id-$rand";

                $response=ImePay::verifyPayment('LIGHTSLAB',$amount,$refId);

                // dd($last_payment[0]);
                if($request->input('payment_data') != ""){
                    $payment_data = json_decode($request->input('payment_data'));
                    $verification = Khalti::verifyPayment($payment_data, $futureemi[0][1]*100);
                    if((!isset($verification->error_key))&&(strtolower($verification->state->name)=="completed")&&(($futureemi[0][1]*100)==$verification->amount)){
                        $invoice_id = Payments::addInvoice(
                            Auth::user()->id,
                            $commitment_id,
                            "installment",
                            (($verification->amount)/100),
                            "Auto-generated invoice for Installment for ".date("F, Y",strtotime($futureemi[0][0])),
                            "unpaid",
                            $futureemi[0][0]
                        );
                        Payments::addPayment(
                            Auth::user()->id,
                            $invoice_id,
                            "khalti",
                            "completed",
                            "this was a installment payment",
                            json_encode(array(
                                'payment_data' => json_encode($payment_data),
                                'verification' => json_encode($verification)
                            ))
                        );

                        // dd($commitInfo->next_pay_date);
                        if($commitInfo->next_pay_date == $last_payment[0] )
                        {
                            // dd('inside');
                            User::updateBalance($referer,$bonus);
                            UserBalanceSheet::addBalance($referer,'referal bonus added for commitment'.$commitment_id,'credit',$bonus);
                            DB::table('commits')->where('id', $commitment_id)
                            ->update([
                                'status' => 'PaymentCompleted',
                            ]);
                        }

                        DB::table('commits')
                        ->where('id', $commitment_id)
                        ->where('user_id', Auth::user()->id)
                        ->update(['next_pay_date'=>(isset($futureemi[1][0]) ? $futureemi[1][0] : ""),'total_paid' => DB::raw('total_paid + ' . (($verification->amount)/100))]);

                        DB::table('invoice')
                        ->where('id', $invoice_id)
                        ->where('user_id', Auth::user()->id)
                        ->update(['status' => 'paid']);

                        $user=[
                            'invoice_id'=>$invoice_id,
                            'invoice_created'=>date('Y-m-d'),
                            'name'=>Auth::user()->name,
                            'email'=>Auth::user()->email,
                            'payment_method'=>'khalti',
                            'payment_type'=>'Advance Payment',
                            'item'=>$commitInfo->title.' '.'('.($futureemi[0][0]).')',
                            'amount'=>(($verification->amount)/100)
                        ];
                        foreach(['info@tripkhata.com',Auth::user()->email] as $to){
                            Mail::to($to)->send(new SendMail($user,'payment'));
                        }
                        return redirect()->route('MyCommitments')->with('success_message', 'Advance Payment done.');
                    }else{
                        echo "Something wrong with the payment you made. Please contact us";
                    }
                }
                if($request->input('confirm')!=""){
                    return redirect()->route('makePayment');
                }
                return view('contents.advancePayment',['commitInfo'=>$commitInfo, 'payments_made' => $payments_made,'futureemi' => $futureemi,'remaining' => $remaining,'generalAmount'=>$generalAmount,'breadcrumb'=>$breadcrumb,'response'=>$response]);
            break;
            case "general":
                $breadcrumb='General Payment';
                $min = (($remaining/2)<500) ? $remaining : 500;
                if($request->input('amount')<=$remaining && $request->input('amount')>=$min){
                    if($request->input('payment_data') != ""){
                        $payment_data = json_decode($request->input('payment_data'));
                        $verification = Khalti::verifyPayment($payment_data, $request->input('amount')*100);
                        if((!isset($verification->error_key))&&(strtolower($verification->state->name)=="completed")&&(($request->input('amount')*100)==$verification->amount)){
                            $invoice_id = Payments::addInvoice(
                                Auth::user()->id,
                                $commitment_id,
                                "general",
                                (($verification->amount)/100),
                                "Auto-generated invoice for General Payment",
                                "unpaid",
                                date("Y-m-d")
                            );
                            Payments::addPayment(
                                Auth::user()->id,
                                $invoice_id,
                                "khalti",
                                "completed",
                                "this was a general payment",
                                json_encode(array(
                                    'payment_data' => json_encode($payment_data),
                                    'verification' => json_encode($verification)
                                ))
                            );
                            DB::table('commits')
                            ->where('id', $commitment_id)
                            ->where('user_id', Auth::user()->id)
                            ->update(['total_paid' => DB::raw('total_paid + ' . (($verification->amount)/100))]);

                            DB::table('invoice')
                            ->where('id', $invoice_id)
                            ->where('user_id', Auth::user()->id)
                            ->update(['status' => 'paid']);

                            $user=[
                                'invoice_id'=>$invoice_id,
                                'invoice_created'=>date('Y-m-d'),
                                'name'=>Auth::user()->name,
                                'email'=>Auth::user()->email,
                                'payment_method'=>'khalti',
                                'payment_type'=>'General Payment',
                                'item'=>$commitInfo->title,
                                'amount'=>(($verification->amount)/100)
                            ];

                            foreach(['info@tripkhata.com',Auth::user()->email] as $to){
                                Mail::to($to)->send(new SendMail($user,'payment'));
                            }

                        return redirect()->route('MyCommitments')->with('success_message', 'General  Payment done.');
                        }else{
                            echo "Something wrong with the payment you made. Please contact us";
                        }
                    }
                }
                return view('contents.generalPayment',['commitInfo'=>$commitInfo, 'payments_made' => $payments_made, 'min' => $min, 'remaining' => $remaining,'generalAmount'=>$generalAmount,'breadcrumb'=>$breadcrumb]);
            break;
            case "invoice":
                print_r($commitInfo);
            break;
            default:
                $commitments = User::myCommitments();
                $breadcrumb= 'Make Payment';
                return view('contents.make_payment',['commitments'=>$commitments,'breadcrumb'=>$breadcrumb]);
        }
    }
    public function viewEmi($commitment_id){
        $commenceDateInfo = Packages::singleCommenceDateInfo($commitment_id);
        $commitInfo = User::singleCommitInfo($commitment_id);
        $payments_made = User::paymentsForSingleCommit($commitment_id,array('general','down_payment','installment'));
        $remaining = $commitInfo->travellers * $commitInfo->price_per_traveller - $payments_made;
        $last_paid = User::lastPaid($commitment_id);
        $futureemi = Packages::futureEMI($remaining, $last_paid->due, $commitInfo->commence_date);
        $breadcrumb = 'EMI';
        return view('contents.viewEmi',['emi' => $futureemi,'item' => $commitInfo,'breadcrumb'=>$breadcrumb,'commenceDateInfo'=>$commenceDateInfo,'commitment_id'=>$commitment_id]);
    }
    public function commits(Request $request){
        $commitments = User::myCommitments();
        $breadcrumb = 'Commitments';
        return view('contents.commitments',['commitments' => $commitments,'breadcrumb'=>$breadcrumb]);
    }
    public function book(Request $request){
        $breadcrumb='Book Trip';
        //id is commence_date id//
        $id = intval($request->input('clickref'));$err="";$travellers = intval($request->input('travellers'));$down = intval($request->input('down'));
        $commenceDateInfo = Packages::singleCommenceDateInfo($request->package_id,$id);
        $available_slots = Packages::availableSlots($id,$commenceDateInfo[0]['max_per_commence']);
        if($travellers==0){$travellers = 1;}if($down<1000){$down = 1000;}if($down>($commenceDateInfo[0]['price']*$travellers)){$down = $commenceDateInfo[0]['price']*$travellers;$err="Sorry, down payment cannot be more than package price";}
        if($travellers>$available_slots){$travellers=$available_slots;$err="Sorry, there are only ".$available_slots." seats available";}
        $eligiblity = User::eligibleToBook($commenceDateInfo);
        $emi = Packages::emiCalculator($down,date('Y-m')."-01",$commenceDateInfo[0]['price']*$travellers,$commenceDateInfo[0]['commence_date']);

        //ime pay
        $rand=random_int(1000, 9999);
        $user_id=auth()->user()->id;
        $ref_id="Ref-$id-$travellers-$request->package_id-$rand-$user_id";

        $response=ImePay::verifyPayment('LIGHTSLAB',$down,$ref_id);

        if($eligiblity[0]==true){
            if($available_slots>0){
                if($request->input('payment_data') != ""){
                    $payment_data = json_decode($request->input('payment_data'));

                    $verification = Khalti::verifyPayment($payment_data, $down*100);
                    if((!isset($verification->error_key))&&(strtolower($verification->state->name)=="completed")&&(($down*100)==$verification->amount)){
                        $commit_id = Payments::addCommit(
                            Auth::user()->id,
                            $commenceDateInfo[0]['id'],
                            $travellers,
                            $commenceDateInfo[0]['price'],
                            json_encode($emi)
                        );
                        $invoice_id = Payments::addInvoice(
                            Auth::user()->id,
                            $commit_id,
                            "down_payment",
                            (($verification->amount)/100),
                            "Auto-generated invoice for Down-Payment",
                            "unpaid",
                            date("Y-m-d")
                        );
                        Payments::addPayment(
                            Auth::user()->id,
                            $invoice_id,
                            "khalti",
                            "completed",
                            "down payment",
                            json_encode(array(
                                'payment_data' => json_encode($payment_data),
                                'verification' => json_encode($verification)
                            ))
                        );
                        DB::table('commits')
                        ->where('id', $commit_id)
                        ->where('user_id', Auth::user()->id)
                        ->update(['total_paid' => (($verification->amount)/100), 'status'=>'active']);

                        DB::table('invoice')
                        ->where('id', $invoice_id)
                        ->where('user_id', Auth::user()->id)
                        ->update(['status' => 'paid']);

                        $user=[
                            'name'=>Auth::user()->name,
                            'title'=>$commenceDateInfo[0]['title'].' '.'('.$commenceDateInfo[0]['commence_date'].')',
                            'booked_date'=>date('Y-m-d'),
                            'paid_amount'=>(($verification->amount)/100),
                            'payment_method'=>'Khalti',
                            'payment_type'=>'Down Payment'
                        ];

                        foreach(['info@tripkhata.com',Auth::user()->email] as $to){
                            Mail::to($to)->send(new SendMail($user,'commitment'));
                        }

                        return redirect()->route('MyCommitments')->with('success_message', 'Package Booked Successfully.');

                    }
                }
                return view('contents.book_trip',['emi'=>$emi,'down'=>$down,'err'=>$err,'item'=>$commenceDateInfo,'available_slots'=>$available_slots,'travellers'=>$travellers,'breadcrumb'=>$breadcrumb,'response'=>$response]);
            }else{
                echo "maximum people reached for this trip on this commence date";
            }
        }else{
            return redirect()->route('MyCommitments');
        }


    }

    public function showWishList(){

        $items=DB::table('wishlists')
                ->select()
                ->leftJoin('packages','packages.id','wishlists.package_id')
                ->where('user_id',Auth::user()->id)
                ->paginate(5);

        return view('contents.wishlist',compact('items'));

    }

    public function updateProfile(Request $request)
    {
        $user_id = Auth::user()->id;

        $request->validate([
            'profile_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'contact'=> 'nullable|numeric|digits_between:9,10',
            'name'=>'required',
        ]);

        if($request->has('profile_image')) {
            if(Auth::user()->profile_image!="" || isset(Auth::user()->profile_image)){
                if(file_exists(public_path('images/'.Auth::user()->profile_image))){
                    File::delete(public_path('images/'.Auth::user()->profile_image));
                }
            }

            $imageName = time().'.'.$request->profile_image->extension();
        
            $img=Image::create([
                'local_filename'=>$imageName,
                'size'=>intval(($request->profile_image->getSize()/1000)).'KB',
                'directory'=>'images',
            ]);

            $request->profile_image->move(public_path('images'), $imageName);

            $imageName=$img->id;
        }
        else{
            if(Auth::user()->profile_image!="" || isset(Auth::user()->profile_image)){
                $imageName=Auth::user()->profile_image;
            }else{
                $imageName=NULL;
            }
        }

        $fields = [
            'name' => $request->name,
            'address' => $request->address,
            'contact' => $request->contact,
            'profile_image' => $imageName,
        ];


        User::where('id',$user_id)->update($fields);
        return back()->with('success', 'Profile  Updated Successfully');
    }

    public function removeUserPhoto(){

        if(Auth::user()->profile_image!="" || isset(Auth::user()->profile_image)){
            File::delete(public_path('images/'.Auth::user()->profile_image));
        }

        User::where('id',Auth::user()->id)
                ->update([
                    'profile_image'=>NULL
                ]);

        return back()->with('success', 'Photo Removed Successfully');
    }

    public function updateUserGuide($value){
        if($value=='finish'){
            User::where('id',Auth::user()->id)
                ->update(['user_guide'=>2]);
        }else{
            User::where('id',Auth::user()->id)
                ->update(['user_guide'=>1]);
        }

        return response()->json(['success'=>'Updated']);
    }

    public function referFriend(Request $request){

        $validator = \Validator::make($request->all(), [
            'email' => "required|email",
        ]);
        if ($validator->fails()){
            return response()->json(['errors'=>$validator->errors()->all()]);
        }else{
            $userInfo=User::find($request->refId);
            $user=[
                'refUrl'=>$request->refUrl,
                'name'=>$userInfo->name
            ];
            Mail::to($request->email)->send(new SendMail($user,'refer'));
            return response()->json(['success'=>'Invitation Send Successfully']);
        }
    }

    public function refers(){

        $refer_history=DB::table('users')
                            ->select('*','users.created_at as created','users.id as u_id')
                            ->where('referrer',Auth::user()->id)
                            ->leftJoin('commits','users.id','commits.user_id')
                            ->get()
                            ->unique('u_id');

        $payments=DB::table('users')
                            ->select('*','users.created_at as created','users.id as u_id')
                            ->where('referrer',Auth::user()->id)
                            ->leftJoin('commits','users.id','commits.user_id')
                            ->where(function($q) {
                                $q->where('commits.status', 'active')
                                  ->orWhere('commits.status', 'completed');
                            })
                            ->get();


        return view('contents.refer',compact('refer_history','payments'));
    }

    public function update_password(Request $request){
        $request->validate([
        'old_password'=>'required|min:6|max:100',
        'new_password'=>'required|min:6|max:100',
        'confirm_password'=>'required|same:new_password'
        ]);

        $current_user=auth()->user();

        if(Hash::check($request->old_password,$current_user->password)){

            $current_user->update([
                'password'=>bcrypt($request->new_password)
            ]);

            return redirect()->back()->with('success','Password successfully updated.');

        }else{
            return redirect()->back()->with('error','Old password does not matched.');
        }



    }
}
