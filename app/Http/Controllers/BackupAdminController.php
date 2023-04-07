<?php

namespace App\Http\Controllers;
use Auth;
use Storage;
use App\Hotels;
use App\Packages;
use App\Itinerary;
use App\CommenceDates;
use App\AdditionalInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class BackupAdminController extends Controller
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
        $package->title = $request->title;
        $package->slug = $request->title;
        $package->description = $request->description;
        $package->images = implode(", ",$filepaths);
        $package->inclusions = $request->inclusions;
        $package->highlights = $request->highlights;
        $package->destination = 'Requires Filed';
        $package->featured = '1';
        $package->special_offer = '1';



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
        return view('croom.packages.list',['items' => Packages::getAll()]);
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
        
        $packages=Packages::find($id);
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

        $filepaths1 = array();
        if($request->has('old_itinerary_img_new')){
            $files = $request->old_itinerary_img_new;
            if(isset($files[1]['image'])){
                foreach($files[1]['image'] as $file){
                    $filepaths1[] = self::saveImg($file);
                }
            }
        }

        if($request->old_itinerary_img){
            $old_o_images=implode(",",$request->old_itinerary_img);
            $old_n_images=implode(",",$filepaths1);
            if($old_n_images){
                $filepaths1=$old_o_images.",".$old_n_images;
            }else{
                $filepaths1=$old_o_images;
            }
        }else{
            $filepaths1=implode(",",$filepaths1);
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

    //    foreach($request->commence_dates as $row){
    //         CommenceDates::create([
    //             'commence_date'=>$row['commence_date'],
    //             'max_per_commence'=>$row['max_per_commence'],
    //             'price'=>$row['price'],
    //             'package_id'=>$id
    //         ]);
    //    }


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
                     'images'=>$filepaths1,
                     'package_id'=>$id
    
                ]);
            }
        }
    //    $day = 1;
    //    foreach($request->itinerary as $info){
    //         Itinerary::create([
    //             'title'=>$info['title'],
    //             'inclusions'=>$info['inclusions'],
    //             'description'=>$info['description'],
    //             'key_activities'=>$info['key_activities'],
    //             'destination_place'=>$info['destination_place'],
    //             'end_of_day'=>'safas',
    //             'images'=>implode(",",$filepaths2),
    //             'package_id'=>$id,
    //             'day'=>$day
    //         ]);
    //         $day++;
    //     }
        
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
        
    //    foreach($request->additional_info as $details){
    //         AdditionalInfo::create([
    //                 'title'=>$details['title'],
    //                 'description'=>$details['description'],
    //                 'package_id'=>$id
    //         ]);
    //    }

        echo "Updated Data";    
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



}
