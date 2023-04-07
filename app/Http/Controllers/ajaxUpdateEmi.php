<?php

namespace App\Http\Controllers;
use Auth;
use Storage;
use App\User;
use App\Hotels;
use App\Packages;
use App\Payments;
use App\Itinerary;
use App\CommenceDates;
use App\AdditionalInfo;
use App\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class ajaxUpdateEmi extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    public function index(Request $request)
    {
        return view('croom.home');
    }
    public function packages(Request $request){
        return view('croom.packages.list',['items' => Packages::getAll()]);
    }
    public function newPackages(Request $request){
        return view('croom.packages.new');
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
        return "images/".$file->storeAs('',$saveAs,['disk' => 'public_img']);
    }
    public function newPackageSave(Request $request){
        $filepaths = array();
        if($request->has('package_img')){
            $files = $request->package_img;
            if(isset($files['image'])):
                foreach($files['image'] as $file){
                    $filepaths[] = self::saveImg($file);
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
        $package->images = implode(", ",$filepaths);
        $package->inclusions = $request->inclusions;
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

        $day = 1;
        foreach($request->itinerary as $eachItinerary){
            $Itinerary = new Itinerary();
            $Itinerary->package_id = $packageID;
            $Itinerary->day = $day;
            $Itinerary->title = $eachItinerary['title'];
            $Itinerary->inclusions = $eachItinerary['inclusions'];
            $Itinerary->description = $eachItinerary['description'];
            $Itinerary->key_activities = $eachItinerary['key_activities'];
            $Itinerary->destination_place = $eachItinerary['destination_place'];
            $Itinerary->end_of_day = $eachItinerary['end_of_day'];
                $filepaths = array();
                if(array_key_exists("image",$eachItinerary)){
                    $files = $eachItinerary['image'];
                    foreach($files as $file){
                        $filepaths[] = self::saveImg($file);
                    }
                }
            $Itinerary->images = implode(", ",$filepaths);
            $Itinerary->save();
            $day++;
        }
        return back()->with('success', 'Package Added Successfully');
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
                $filepaths[] = self::saveImg($file);
            }
        }
        $hotel = new Hotels();
        $hotel->images = implode(", ",$filepaths);
        $hotel->description = $request->description;
        $hotel->name = $request->name;
        $hotel->inclusions = $request->inclusions;
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


        return view('croom.packages.edit',compact('packages','additional_info','c_date','itinerary','images_data'));
    }

    public function editPackageSave(Request $request,$id){
        $filepaths = array();
        if($request->has('package_img')){
            $files = $request->package_img;
            foreach($files['image'] as $file){
                $filepaths[] = self::saveImg($file);
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

        $filepaths2 = array();
        if($request->has('itinerary')){
            $files = $request->itinerary;
            if(isset($files[1]['image'])){
                foreach($files[1]['image'] as $file){
                    $filepaths2[] = self::saveImg($file);
                }
            }
        }

        Packages::updateOrCreate([
            'id'=>$id
            ],[
            'title'=>$request->title,
            'description'=>$request->description,
            'highlights'=>$request->highlights,
            'tags'=>$request->tags,
            'inclusions'=>$request->inclusions,
            'travel_option'=>$request->travel_option,
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

        if(isset($request->old_itinerary)){
            foreach($request->old_itinerary as $info){
                Itinerary::updateOrCreate([
                    'id'=>$info['id']
                ],[
                     'title'=>$info['title'],
                     'inclusions'=>$info['inclusions'],
                     'description'=>$info['description'],
                     'key_activities'=>$info['key_activities'],
                     'destination_place'=>$info['destination_place'],
                     'end_of_day'=>'safas',
                     'images'=>'check',
                     'package_id'=>$id

                ]);
            }
        }

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

    public function customerEMI($c_id)
    {
        $commitInfo = User::singleCommitInfo($c_id);
        $payments_made = User::paymentsForSingleCommit($c_id,array('general','down_payment','installment'));
        $remaining = $commitInfo->travellers * $commitInfo->price_per_traveller - $payments_made;
        $last_paid = User::lastPaid($c_id);
        $futureemi = Packages::futureEMI($remaining, $last_paid->due, $commitInfo->commence_date);

        // return view('contents.viewEmi',['emi' => $futureemi,'item' => $commitInfo]);
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
        

        $validator = \Validator::make($request->all(), [
            'amount' => 'required',
            'method' => 'required'
        ]);
        
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }   

          $data=[
            'amount'=>$request->input('amount'),
            'commitment_id'=>$request->input('commit_id'),
            'method'=>$request->input('method'),
            'type'=>$request->input('post')
        ];
        $commitment_id=$request->input('commit_id');
        $method=$request->input('method');
        $path = $request->input('post');

        $commitInfo = User::singleCommitInfo($commitment_id);

        $payments_made = User::paymentsForSingleCommit($commitment_id,array('general','down_payment','installment'),$request->input('customer_id'));

        $remaining = $commitInfo->travellers * $commitInfo->price_per_traveller - $payments_made;

        switch($path){
            case "general":
                $min = (($remaining/2)<500) ? $remaining : 500;
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
                
                }
        }

        
    

}

}
