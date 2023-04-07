<?php

namespace App\Http\Controllers;
use Storage;
use App\Menu;
use App\User;
use App\Hotels;
use App\Enquiry;
use App\Setting;
use App\Packages;
use App\Payments;
use App\Itinerary;
use App\Image;
use App\CommenceDates;
use App\Mail\SendMail;

use App\AdditionalInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

use Illuminate\Container\RewindableGenerator;
use Facade\Ignition\Support\Packagist\Package;
use Illuminate\Support\Facades\Auth as FacadesAuth;




class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    public function index(Request $request)
    {
        $total_collected_emi = DB::table('invoice')
        ->sum('amount');

        $today_collected_emi = DB::table('invoice')
        ->where(DB::raw('DATE(created_at)'), date('Y-m-d'))
        ->sum('amount');

        $cancelled_emi = DB::table('commits')
        ->where('status','cancelled')
        ->count();

        $commitments = DB::table('commits')
        ->where('status','active')
        ->where(function($q) {
            $q->where('next_pay_date','!=',null)
              ->orWhere('next_pay_date','!=',' ');
        })
        ->get();

        // dd($commitments);

        // dd(225000);
        $package_cost= 0;
        $total_paid= 0;
        $total_remaining=0;
        $travelers=0;
        foreach($commitments as $commit){
            $package_cost+= $commit->price_per_traveller;
            $total_paid+=$commit->total_paid;
            $travelers= $commit->travellers;
        }
        return view('croom.home',compact('total_collected_emi','today_collected_emi','cancelled_emi'));
    }
    public function packages(Request $request){
        return view('croom.packages.list',['items' => Packages::getAll()]);
    }
    public function newPackages(Request $request){
        $menu_tags = Menu::select('title')->get();
        return view('croom.packages.new',compact('menu_tags'));
    }
    public function packageItinerary()
    {
        $items = Packages::orderBy('id','desc')->get();
        return view('croom.itinerary.packages_itinerary',['items' => $items]);

    }

    public function addItinerary($id)
    {
        $packages=Packages::find($id);
        $itinerary=Itinerary::where('package_id',$id)
                            ->get();
        return view('croom.itinerary.add_edit_itinerary',compact('packages','itinerary'));

    }

    private function saveImg($file){
        $saveAs = strtolower(preg_replace('/[^a-zA-Z0-9.-]/', '-', $file->getClientOriginalName()));
        if (Storage::disk('public_img')->exists($saveAs)) {
            $pathInfo = pathinfo($saveAs);
            $extension = isset($pathInfo['extension']) ? ('.' . $pathInfo['extension']) : '';
            if (preg_match('/(.*?)(\d+)$/', $pathInfo['filename'], $match)) {
                $base = $match[1];
                $number = intVal($match[2]);
            } else {
                $base = $pathInfo['filename'];
                $number = 0;
            }
            do {
                $saveAs = $base . ++$number . $extension;
            } while (Storage::disk('public_img')->exists($saveAs));
        }
        return $file->storeAs('',$saveAs,['disk' => 'public_img']);
    }
    public function newPackageSave(Request $request){
        $request->validate([
            'title'=>'required',
            'commence_dates.*.max_per_commence'=>'required'
        ]);

        $filepaths = array();
        if($request->has('package_img')){
            $files = $request->package_img;
            if(isset($files['image'])):
                foreach($files['image'] as $file){
                    $size=$file->getSize()/1000;
                    $file_size=intval($size).'KB';
                    $allImages= Image::create([
                        'local_filename'=>self::saveImg($file),
                        'size'=>$file_size,
                        'directory'=>'images'
                    ]);
                    $filepaths[]=$allImages->id;
                }
            endif;
        }

        $package = new Packages();
        if($request->featured==null)
        {
            $package->featured = '0';

        }
        else{
            $package->featured = $request->featured;
        }
        if($request->special_offer==null)
        {
            $package->special_offer = '0';

        }
        else{
            $package->special_offer = $request->special_offer;
        }
        $package->title = $request->title;
        $package->slug = str_replace(' ', '-', strtolower($request->title));
        $package->description = $request->description;
        $package->images = implode(",",$filepaths);
        $package->inclusions = $request->inclusions;
        $package->exclusions = $request->exclusions;
        $package->highlights = $request->highlights;
        $package->destination = $request->destination;
        $package->tags = $request->tags;
        $package->duration = $request->duration;
        $package->travel_option = $request->travel_option;
        $package->created_by = Auth::user()->id;
        $package->save();
        $packageID = $package->id;

        foreach($request->commence_dates as $commence_date){
            $commenceDate = new CommenceDates();
            $commenceDate->package_id = $packageID;
            $commenceDate->commence_date = $commence_date['commence_date'];
            $commenceDate->max_per_commence = $commence_date['max_per_commence'];
            $commenceDate->price = $commence_date['price'];
            $commenceDate->save();
        }

        foreach($request->additional_info as $additional_info){
            $AdditionalInfo = new AdditionalInfo();
            $AdditionalInfo->package_id = $packageID;
            $AdditionalInfo->title = $additional_info['title'];
            $AdditionalInfo->description = $additional_info['description'];
            $AdditionalInfo->save();
        }
        /*

        $old_images = $_POST['old_imgs'];
        $new_images = getnewimges();
        $images = implode(",",array_merge($old_images,$new_images));
        update dfsdf set images = $images


        */

        // $day = 1;
        // foreach($request->itinerary as $eachItinerary){
        //     $Itinerary = new Itinerary();
        //     $Itinerary->package_id = $packageID;
        //     $Itinerary->day = $day;
        //     $Itinerary->title = $eachItinerary['title'];
        //     $Itinerary->inclusions = $eachItinerary['inclusions'];
        //     $Itinerary->description = $eachItinerary['description'];
        //     $Itinerary->key_activities = $eachItinerary['key_activities'];
        //     $Itinerary->destination_place = $eachItinerary['destination_place'];
        //     $Itinerary->end_of_day = $eachItinerary['end_of_day'];
        //         $filepaths = array();
        //         if(array_key_exists("image",$eachItinerary)){
        //             $files = $eachItinerary['image'];
        //             foreach($files as $file){
        //                 $filepaths[] = self::saveImg($file);
        //             }
        //         }
        //     $Itinerary->images = implode(", ",$filepaths);
        //     $Itinerary->save();
        //     $day++;
        // }
        return back()->with('success', 'Package Added Successfully');
    }

    public function saveItinerary(Request $request)
    {
        if(isset($request->old_itinerary)){
            foreach($request->old_itinerary as $key=>$info){
                if(isset($request->old_itinerary[$key]['it_images'])){
                    $infos=[];
                    $existingImg=[];
                    foreach($request->old_itinerary[$key]['it_images'] as $row){
                        $size=$row->getSize()/1000;
                        $file_size=intval($size).'KB';
                        $all_images=Image::create([
                            'local_filename'=>$row->store('/','itinerary_images'),
                            'size'=>$file_size,
                            'directory'=>'it_images'
                        ]);
                        $infos[]=$all_images->id;
                    }
                    $existingImg=isset($request->old_itinerary[$key]['old_it_images'])?($request->old_itinerary[$key]['old_it_images']):array(null);
                    Itinerary::updateOrCreate([
                        'id'=>$info['id']
                    ],[
                        'title'=>$info['title'],
                        'inclusions'=>$info['inclusions'],
                        'exclusions'=>$info['exclusions'],
                        'description'=>$info['description'],
                        'key_activities'=>$info['key_activities'],
                        'destination_place'=>$info['destination_place'],
                        'images'=>empty($existingImg[0])?implode(",",$infos):implode(",",array_merge($existingImg,$infos)),
                        'package_id'=>$request->package_id,
                        'end_of_day'=>'hotel',
                        'day'=>$info['day']?$info['day']:$key
                    ]);

                }else{
                    if(isset($request->old_itinerary[$key]['old_it_images'])){
                        $infos=[];
                        $existingImg=[];
                        foreach($request->old_itinerary[$key]['old_it_images'] as $row){
                            $existingImg[]=$row;
                        }
                        Itinerary::updateOrCreate([
                            'id'=>$info['id']
                        ],[
                            'title'=>$info['title'],
                            'inclusions'=>$info['inclusions'],
                            'exclusions'=>$info['exclusions'],
                            'description'=>$info['description'],
                            'key_activities'=>$info['key_activities'],
                            'destination_place'=>$info['destination_place'],
                            'images'=>implode(',',$existingImg),
                            'package_id'=>$request->package_id,
                            'end_of_day'=>'hotel',
                            'day'=>$info['day']?$info['day']:$key
                        ]);

                    }else{
                        Itinerary::updateOrCreate([
                            'id'=>$info['id']
                        ],[
                            'title'=>$info['title'],
                            'inclusions'=>$info['inclusions'],
                            'exclusions'=>$info['exclusions'],
                            'description'=>$info['description'],
                            'key_activities'=>$info['key_activities'],
                            'destination_place'=>$info['destination_place'],
                            'images'=>null,
                            'package_id'=>$request->package_id,
                            'end_of_day'=>'hotel',
                            'day'=>$info['day']?$info['day']:$key
                        ]);
                    }
                }
            }
         }
        return back()->with('success', 'Itinerary Added Successfully');

    }

    public function removeItineraryImages($id,$key){
        $itinerary=Itinerary::find($id);
        $old_images_data=explode(",",$itinerary->images);

        if(in_array($old_images_data[$key],$old_images_data)){
            $img_path=public_path().'/'.'it_images/'.$old_images_data[$key];
            if(file_exists($img_path)) {
                unlink($img_path);
            }
            unset($old_images_data[$key]);
            $old_images_data_delete=implode(",",$old_images_data);
            $itinerary->update([
                'images'=>$old_images_data_delete
            ]);
        }
        return redirect()->back()->with('fail','Image Deleted');
    }

    public function hotels(Request $request){
        return view('croom.hotels.viewhotels',['items' => Hotels::get()]);
    }
    public function newHotels(Request $request){
        return view('croom.hotels.new');
    }
    public function newHotelSave(Request $request){
        $filepaths = array();
        if($request->has('hotel')){
            $files = $request->hotel;
            foreach($files['image'] as $file){
                $size=$file->getSize()/1000;
                $file_size=intval($size).'KB';
                $allImages= Image::create([
                    'local_filename'=>self::saveImg($file),
                    'size'=>$file_size,
                    'directory'=>'images'
                ]);
                $filepaths[]=$allImages->id;
            }
        }
        $hotel = new Hotels();
        $hotel->images = implode(", ",$filepaths);
        $hotel->description = $request->description;
        $hotel->name = $request->name;
        $hotel->inclusions = $request->inclusions;
        // $hotel->exclusions = $request->exclusions;
        $hotel->address = $request->address;
        $hotel->star_ratings = $request->star_ratings;
        if($hotel->save()){
            return back()->with('success', 'Hotel Saved Successfully');
        }else{
            return back()->with('fail', 'Hotel Not Saved');
        }
    }
    public function hotelAjax($q){
        $hotels = DB::table('hotels')
        ->where('name', 'LIKE', '%'.$q.'%')
        ->orWhere('address', 'LIKE', '%'.$q.'%')
        ->select('id','name', 'address')->get();
        echo json_encode($hotels);
    }

    public function editPackage($id){

        $packages=Packages::find($id);
        if($packages->images){
            $images_data=explode(',',$packages->images);
        }else{
            $images_data=[];
        }

        $additional_info=AdditionalInfo::where('package_id',$packages->id)
                        ->get();
        $c_date=CommenceDates::where('package_id',$packages->id)
                        ->get();
        $itinerary=Itinerary::where('package_id',$packages->id)
                            ->get();

        $menu_tags = Menu::select('title')->get();


        return view('croom.packages.edit',compact('packages','additional_info','c_date','itinerary','images_data','menu_tags'));
    }

    public function editPackageSave(Request $request,$id){
        $filepaths = array();
        if($request->has('package_img')){
            $files = $request->package_img;
            foreach($files['image'] as $file){
                $size=$file->getSize()/1000;
                $file_size=intval($size).'KB';
                 $allImages= Image::create([
                        'local_filename'=>self::saveImg($file),
                        'size'=>$file_size,
                        'directory'=>'images'
                    ]);
                    $filepaths[]=$allImages->id;
            }
        }

        if($request->old_img){
            $old_images=implode(",",$request->old_img);
            $combine=implode(",",$filepaths);
            if($combine){
                $filepaths=$old_images.",".$combine;
            }else{
                $filepaths=$old_images;
            }
        }else{
                $filepaths=implode(",",$filepaths);
            }

        if($request->featured==null)
        {
            $featured = '0';

        }
        else{
            $featured = $request->featured;
        }
        if($request->special_offer==null)
        {
            $special_offer = '0';

        }
        else{
            $special_offer = $request->special_offer;
        }


        Packages::updateOrCreate([
            'id'=>$id
            ],[
            'title'=>$request->title,
            'description'=>$request->description,
            'highlights'=>$request->highlights,
            'tags'=>$request->tags,
            'inclusions'=>$request->inclusions,
            'exclusions'=>$request->exclusions,
            'travel_option'=>$request->travel_option,
            'featured'=>$featured,
            'special_offer'=>$special_offer,
            'duration'=>$request->duration,
            'images' => $filepaths
        ]);

        if(isset($request->old_commence_dates)){
            foreach($request->old_commence_dates as $row){
                CommenceDates::updateOrCreate([
                    'id'=>$row['id']
                ],[
                    'commence_date'=>$row['commence_date'],
                    'max_per_commence'=>$row['max_per_commence'],
                    'price'=>$row['price'],
                    'package_id'=>$id
                ]);
            }
        }

        // if(isset($request->old_itinerary)){
        //     foreach($request->old_itinerary as $key=>$info){
        //         Itinerary::updateOrCreate([
        //             'id'=>$info['id']
        //         ],[
        //              'title'=>$info['title'],
        //              'inclusions'=>$info['inclusions'],
        //              'description'=>$info['description'],
        //              'key_activities'=>$info['key_activities'],
        //              'destination_place'=>$info['destination_place'],
        //              'images'=>'',
        //              'package_id'=>$id,
        //              'day'=>$info['day']?$info['day']:$key

        //         ]);
        //     }
        // }

        if(isset($request->old_additional_info)){
            foreach($request->old_additional_info as $details){
                AdditionalInfo::updateOrCreate([
                        'id'=>$details['id']
                ],[
                        'title'=>$details['title'],
                        'description'=>$details['description'],
                        'package_id'=>$id
                ]);
            }
        }

        session()->flash('success','Edited Successfully');
        return redirect()->back();
    }

    public function deleteCommenceDate($id){
        CommenceDates::destroy($id);
        return redirect()->back();
    }

    public function deleteAddInfo($id){
        AdditionalInfo::destroy($id);
        return redirect()->back();
    }

    public function deleteIt($id){
        Itinerary::destroy($id);
        return redirect()->back();
    }

    public function customers()
    {
        $allCustomers = User::select('*')
        ->leftJoin('role_user','role_user.user_id','users.id')
        ->where('role_user.role_id','2')
        ->get();
        return view('croom.customer.customers',['allCustomers'=>$allCustomers]);
    }


    public function viewCustomer($id)
    {
        $customer = User::select()
        ->where('id',$id)
        ->first();

        $customerInfo =  DB::table('commits')
        ->join('commence_dates', 'commits.commence_date_id', '=', 'commence_dates.id')
        ->join('packages', 'commence_dates.package_id', '=', 'packages.id')
        ->where('commits.user_id', $id)
        ->where('commits.status', '!=', 'abandoned')
        ->select(
            'commits.*',
            'commits.user_id as user_id',
            'commits.id as commit_id',
            'commence_dates.package_id',
            'commence_dates.commence_date',
            'commence_dates.price',
            'packages.title',
            'packages.slug')
            ->orderBy('id','DESC')
            ->get();

        return view('croom.customer.customer_details',['customerInfo'=>$customerInfo,'customer'=>$customer]);
    }

    public function customerPayments($id)
    {
        $customer = User::select()
        ->where('id',$id)
        ->first();

        $sn=1;

        $request=Request();
        $payments = User::myPayments($request,$id);

        $title=User::myPackageField('packages.title',$id);
        $type=User::myPackageField('invoice.type',$id);
        $method=User::myPackageField('method',$id);

        $setValue=[
            'title'=>$request->title?$request->title:'',
            'type'=>$request->type?$request->type:'',
            'method'=>$request->method?$request->method:'',
        ];

    //    $payments= DB::table('payments')
    //         ->join('invoice', 'payments.invoice_id', '=', 'invoice.id')
    //         ->join('commits', 'invoice.commit_id', '=', 'commits.id')
    //         ->join('commence_dates', 'commence_dates.id', '=', 'commits.commence_date_id')
    //         ->join('packages', 'packages.id', '=', 'commence_dates.package_id')
    //         ->where('payments.user_id', $id)
    //         ->select(
    //             'payments.*',
    //             'payments.id as payment_id',
    //             'payments.status as payment_status',
    //             'invoice.*',
    //             'invoice.status as invoice_status',
    //             'invoice.note as invoice_note',
    //             'commits.*',
    //             'commits.status as commits_status',
    //             'packages.title as package_title',
    //             'packages.slug as package_slug',
    //             'commence_dates.commence_date as commence_date',
    //         )
    //         ->paginate(10);

        return view('croom.customer.customer_payments',['payments'=>$payments,'customer'=>$customer,'sn'=>$sn,'title'=>$title,'method'=>$method,'type'=>$type,'setValue'=>$setValue,'id'=>$id]);


    }

    public function customerEMI(Request $request,$c_id)
    {
        $commitInfo = User::singleCommitInfo($c_id,$request->route('user_id'));
        $payments_made = User::paymentsForSingleCommit($c_id,array('general','down_payment','installment'),$request->route('user_id'));
        $remaining = $commitInfo->travellers * $commitInfo->price_per_traveller - $payments_made;
        $last_paid = User::lastPaid($c_id,$request->route('user_id'));
        $futureemi = Packages::futureEMI($remaining, $last_paid->due, $commitInfo->commence_date);
        return view('croom.customer.customer_emi',['emi' => $futureemi,'item' => $commitInfo]);
    }

    public function removeOldImages($id,$key){
        $packages=Packages::find($id);
        $old_images_data=explode(",",$packages->images);

        if(in_array($old_images_data[$key],$old_images_data)){
            $img_path=public_path().'/'.$old_images_data[$key];
            if(file_exists($img_path)) {
                unlink($img_path);
            }
            unset($old_images_data[$key]);
            $old_images_data_delete=implode(",",$old_images_data);
            $packages->update([
                'images'=>$old_images_data_delete
            ]);
        }

        session()->flash('fail','Image Deleted');
        return redirect()->back();

    }

    public function viewEnquiries()
    {
        $enquiries = Enquiry::select('*')->orderBy('id','desc')
        ->get();

        return view('croom.customer.customer_enquiry',['enquiries'=>$enquiries]);
    }

    public function updateGeneralEmi(Request $request){

        $commitment_id=$request->input('commit_id');
        $method=$request->input('method');
        $path = $request->input('post');
        $commitInfo = User::singleCommitInfo($commitment_id,$request->input('customer_id'));
        $payments_made = User::paymentsForSingleCommit($commitment_id,array('general','down_payment','installment'),$request->input('customer_id'));
        $remaining = $commitInfo->travellers * $commitInfo->price_per_traveller - $payments_made;

        $min = (($remaining/2)<500) ? $remaining : 500; // if else laganu parcha

        $validator = \Validator::make($request->all(), [
            'amount' => "required|numeric|min:$min|max:$remaining",
            'method' => 'required',
        ]);

        if ($validator->fails()){
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
        else{
            $data=[
                'amount'=>$request->input('amount'),
                'commitment_id'=>$request->input('commit_id'),
                'method'=>$request->input('method'),
                'type'=>$request->input('post')
            ];

            switch($path){
                case "general":
                    if($remaining==0){
                        return response()->json(['paid'=>'All the amount is paid']);
                    }
                    if($request->input('amount')<=$remaining && $request->input('amount')>=$min){
                        $payment_data = $data;
                        $invoice_id = Payments::addInvoice(
                           $request->input('customer_id'),
                            $commitment_id,
                            "general",
                            (($request->input('amount'))),
                            "Auto-generated invoice for General Payment",
                            "unpaid",
                            date("Y-m-d")
                        );
                        Payments::addPayment(
                            $request->input('customer_id'),
                            $invoice_id,
                            $method,
                            "completed",
                            "this was a general payment",
                            json_encode(array(
                                'payment_data' => json_encode($payment_data)
                            ))
                        );
                        DB::table('commits')
                        ->where('id', $commitment_id)
                        ->where('user_id', $request->input('customer_id'))
                        ->update(['total_paid' => DB::raw('total_paid + ' . (($request->input('amount'))))]);

                        DB::table('invoice')
                        ->where('id', $invoice_id)
                        ->where('user_id', $request->input('customer_id'))
                        ->update(['status' => 'paid']);

                        $userInfo=User::find($request->input('customer_id'));

                        $user=[
                            'invoice_id'=>$invoice_id,
                            'invoice_created'=>date('Y-m-d'),
                            'name'=>$userInfo->name,
                            'email'=>$userInfo->email,
                            'payment_method'=>'Admin',
                            'payment_type'=>'General Payment',
                            'item'=>$commitInfo->title,
                            'amount'=>$request->input('amount')
                        ];

                        foreach(['info@tripkhata.com',$userInfo->email] as $to){
                            Mail::to($to)->send(new SendMail($user,'payment'));
                        }

                        return response()->json(['success'=>'EMI  Updated']);

                    }else{
                        return response()->json(['err'=>'Something wrong with the payment you made. Please contact us']);
                }
            }
        }
    }

    public function makeBooking(){

        $users=User::select('users.id','users.name')
                    ->leftJoin('role_user','users.id','role_user.user_id')
                    ->where('role_user.role_id',2)
                    ->get();

        $packages=Packages::select('title','slug','id')
                           ->get();

        return view('croom.packages.make_booking',compact('users','packages'));
    }

    public function getSlug(Request $request){

        $package_slug=Packages::getSingle($request->slug)[0];
        return response()->json(['data'=>$package_slug]);
    }

    public function bookFirst(Request $request){

       $info=DB::table('commence_dates')
                        ->select('commence_dates.*', 'packages.title', 'packages.slug')
                        ->join('packages', 'commence_dates.package_id', '=', 'packages.id')
                        ->where('package_id',$request->package_id)
                        ->where('commence_date',$request->commence_date)
                        ->get();

        $commence_data=Packages::cleanToArr($info);
        $err='';
        $travellers = isset($request->travellers)?intval($request->input('travellers')):1;
        $down = isset($request->down)?intval($request->input('down')):1000;
        $available_slots = Packages::availableSlots($commence_data[0]['id'],$commence_data[0]['max_per_commence']);
        if($travellers==0){$travellers = 1; $err="* No of travellers should be atleast 1";}if($down<1000){$down = 1000; $err="* Down payment should be atleast 1000";}if($down>($commence_data[0]['price']*$travellers)){$down = $commence_data[0]['price']*$travellers;$err="Sorry, down payment cannot be more than package price";}
        if($travellers>$available_slots){$travellers=$available_slots;$err="Sorry, there are only ".$available_slots." seats available";}
        $eligiblity = User::eligibleToBook($commence_data,$request->user_id);
        $emi = Packages::emiCalculator($down,date('Y-m')."-01",$commence_data[0]['price']*$travellers,$commence_data[0]['commence_date']);

        if($eligiblity[0]==true){
            if($available_slots>0){
                if($request->submitClick=='btn' && $err==""){
                    $payment_data=$request->post();
                    $commit_id = Payments::addCommit(
                        $request->user_id,
                        $commence_data[0]['id'],
                        $travellers,
                        $commence_data[0]['price'],
                        json_encode($emi)
                    );
                    $invoice_id = Payments::addInvoice(
                        $request->user_id,
                        $commit_id,
                        "down_payment",
                        ($down),
                        "Auto-generated invoice for Down-Payment",
                        "unpaid",
                        date("Y-m-d")
                    );
                    Payments::addPayment(
                        $request->user_id,
                        $invoice_id,
                        "admin-booking",
                        "completed",
                        "down payment",
                        json_encode(array(
                            'payment_data' => json_encode($payment_data)
                        ))
                    );
                    DB::table('commits')
                    ->where('id', $commit_id)
                    ->where('user_id', $request->user_id)
                    ->update(['total_paid' => ($down), 'status'=>'active']);

                    DB::table('invoice')
                    ->where('id', $invoice_id)
                    ->where('user_id', $request->user_id)
                    ->update(['status' => 'paid']);

                    $userDetails=User::find($request->user_id);

                    $user=[
                        'name'=>$userDetails->name,
                        'title'=>$commence_data[0]['title'].' '.'('.$commence_data[0]['commence_date'].')',
                        'booked_date'=>date('Y-m-d'),
                        'paid_amount'=>$down,
                        'payment_method'=>'Admin',
                        'payment_type'=>'Down Payment'
                    ];

                    foreach(['info@tripkhata.com',$userDetails->email] as $to){
                        Mail::to($to)->send(new SendMail($user,'commitment'));
                    }
                    return redirect()->route('commit',['id'=>$request->user_id])->with('success', 'Package Booked Successfully.');

                }
                return view('croom.packages.booking_trip',['item'=>$commence_data,'available_slots'=>$available_slots,'down'=>$down,'travellers'=>$travellers,'err'=>$err,'package_id'=>$request->package_id,'commence_date'=>$request->commence_date,'user_id'=>$request->user_id,'emi'=>$emi]);

            }else{

                return redirect()->route('makeBooking')->with('fail','Maximum people reached for this trip on this commence date');
            }
        }else{
                return redirect()->route('commit',['id'=>$request->user_id])->with('success', 'You must have booked the package already');
        }

    }

    public function cancelCommit($id)
    {
        DB::table('commits')
                ->where('id', $id)
                ->update(['status' => 'cancelled']);

        return back()->with('success', 'Commit  Cancelled Successfully');
    }

    public function concludeCommit($id)
    {
        DB::table('commits')
                ->where('id', $id)
                ->update(['status' => 'completed']);

        return back()->with('success', 'Commit  Completed Successfully');
    }

    public function settings()
    {
        $settings=Setting::select()
        ->get();
        return view('croom.settings.settings',compact('settings'));

    }

    public function newSettings(Request $request,$id=null)
    {
        if ($id == "") {
            $title = "Add New  Setting";
            $setting = new Setting();
            $message = "New setting Added Successfully";
        } else {

            $title = "Add  New  setting";
            $message = "Setting Updated Successfully";
            $setting = Setting::find($id);
        }
        if ($request->isMethod('post')) {
            $request->validate(
                [
                    'name' => 'required',
                    'value.*' => 'mimes:jpeg,jpg,png,gif'

                ]
            );

            $setting_id = $request->id;

            if($request->has('value')) {
                $size=$request->value->getSize()/1000;
                $file_size=intval($size).'KB';

                $images = time().'.'.request()->value->getClientOriginalExtension();
                request()->value->move(public_path('images'), $images);

                $images_data=Image::create([
                    'local_filename'=>$images,
                    'size'=>$file_size,
                    'directory'=>'images'
                ]);

                $filename=$images_data->id;

            }
            else{
                $filename = '';
            }


            Setting::updateOrCreate(
                ['id' => $setting_id],
                [
                    'name' =>  $request->name,
                    'value' =>  $filename,
                ]

            );

            return redirect('settings')->with('success', $message);
        }

        return view('croom.settings.new_setting',compact('title','setting'));
    }


    public function listMenu()
    {
        $menu_items=Menu::select()->get();
        return view('croom.menu-items.viewmenu',compact('menu_items'));
    }

    public function addEditMenu(Request $request,$id=null)
    {
        if ($id == "") {
            $title = "Add New Menu Item ";
            $menu = new Menu();
            $message = "New Menu Item Added Successfully";
        } else {

            $title = "Edit Menu Item ";
            $message = "Menu Item Updated Successfully";
            $menu = Menu::find($id);
        }
        if ($request->isMethod('post')) {
            $request->validate(
                [
                    'title' => 'required',
                    'icon' => 'required',
                    'href'=>'required',
                    'position'=>'required',
                ]
            );

            $item_id = $request->id;


            Menu::updateOrCreate(
                ['id' => $item_id],
                [
                    'title' =>  $request->title,
                    'icon' =>  $request->icon,
                    'href' =>  $request->href,
                    'position' =>  $request->position,
                    'created_by'=> Auth::user()->id,
                ]
            );
            return redirect('menu-items')->with('success', $message);
        }

        return view('croom.menu-items.add-edit-menu',compact('title','menu'));


    }

    public function change_admin_password()
    {
        return view('croom.settings.admin-update-password');
    }

    public function update_admin_password(Request $request){
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
