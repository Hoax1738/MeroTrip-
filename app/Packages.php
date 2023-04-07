<?php
namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Packages extends Model
{
    protected $table = 'packages';
    protected $fillable = ['id', 'title', 'slug', 'description', 'images', 'inclusions', 'exclusions','highlights', 'tags', 'duration', 'travel_option', 'created_by','featured','special_offer'];

    public static function emiCalculator($initial_amount, $start_date, $price, $commence_date, $future=false){
        $startMonth= new \DateTime(date('Y-m',strtotime($start_date))."-01");
        $finalMonth= new \DateTime(date('Y-m', strtotime('-15 days', strtotime($commence_date)))."-01");
        $diff=(date_diff($startMonth,$finalMonth)->format("%y") * 12 ) + date_diff($startMonth,$finalMonth)->format("%m")+1;
        if(!$future) $emi[] = array("Today",$initial_amount);
        $taken_amount = $initial_amount;
        for($i=1; $i<$diff; $i++){
            $take_amount = ceil(($price-$taken_amount)/($diff-$i));
            if($diff-$i != 1) { $take_amount = ceil( $take_amount / 100 ) * 100; }
            $emi[] = array(date("Y-m",strtotime($start_date.' +'.$i.' month'))."-01",($take_amount));
            $taken_amount = $take_amount + $taken_amount;
        }
        return $emi;
    }
    public static function futureEMI($remanining, $last_paid, $commence_date){
        $startMonth= new \DateTime(date('Y-m',strtotime($last_paid." +1 month"))."-01");
        $finalMonth= new \DateTime(date('Y-m', strtotime('-7 days', strtotime($commence_date)))."-01");
        $diff=(date_diff($startMonth,$finalMonth)->format("%y") * 12 ) + date_diff($startMonth,$finalMonth)->format("%m")+2;
        $taken_amount = 0;
        for($i=1; $i<$diff; $i++){
            $take_amount = ceil(($remanining-$taken_amount)/($diff-$i));
            if($diff-$i != 1) { $take_amount = ceil( $take_amount / 100 ) * 100; }
            $emi[] = array(date("Y-m",strtotime($last_paid.' +'.$i.' month'))."-01",($take_amount));
            $taken_amount = $take_amount + $taken_amount;
        }
        return $emi;
    }
    public static function cleanToArr($d){
        return json_decode(json_encode($d),true);
    }
    public static function singleCommenceDateInfo($id,$cid=null){
        $data = DB::table('commence_dates')
            ->select('*','commence_dates.id as id')
            ->leftJoin('packages','packages.id','commence_dates.package_id')
            ->when($cid,function($q,$cid){
                $q->where('commence_dates.id',$cid);
            })
            ->where('commence_dates.package_id',$id)
            ->get();
        return self::cleanToArr($data);
    }
    public static function availableSlots($id,$max){
        $commits = DB::table('commits')
        ->where('commence_date_id',$id)
        ->where('status','active')
        ->sum('travellers');
        return ($max - $commits);
    }
    public static function getAll(){
        $packages = DB::table('packages')
            ->select('*','wishlists.id as w_id','packages.id as id')
            ->leftJoin('wishlists','packages.id','wishlists.package_id')
            ->orderBy('views', 'DESC')
            ->get()
            ->unique('id');
        return self::cleanToArr($packages);
    }
    public static function getSingle($slug){
        $packages = DB::table('packages')
            ->where('slug',$slug)
            ->select('*')
            ->get();
        return self::addPackagesAttr($packages);
    }
    public static function viewspp($slug){
        DB::table('packages')
            ->where('slug', $slug)
            ->update([
                'views' => DB::raw('views + 1')
            ]);
    }
    public static function getTop(){
        // $id=isset(auth::user()->id)?auth::user()->id:null;

        $packages = DB::table('packages')
            ->select('*','wishlists.id as w_id','packages.id as id')
            ->leftJoin('wishlists','packages.id','wishlists.package_id')
            ->orderBy('views', 'DESC')
            ->get()
            ->take(9)
            ->unique('id');
        return self::cleanToArr($packages);
    }
    public static function getSpecial(){
        // $id=isset(auth::user()->id)?auth::user()->id:null;

        $packages = DB::table('packages')
            ->select('*','wishlists.id as w_id','packages.id as id')
            ->leftJoin('wishlists','packages.id','wishlists.package_id')
            ->where('special_offer',"1")
            ->get()
            ->take(9)
            ->unique('id');
        return self::cleanToArr($packages);
    }
    public static function getFeatured(){

        // $id=isset(auth::user()->id)?auth::user()->id:null;
        // $wishlists=DB::table('wishlists')
        //                 ->pluck('user_id')
        //                 ->toArray();

        $packages = DB::table('packages')
            ->select('*','wishlists.id as w_id','packages.id as id')
            ->leftJoin('wishlists','packages.id','wishlists.package_id')
            ->where('featured',"1")
            ->get()
            ->take(9)
            ->unique('id')
            ;
            // if(isset($id) && in_array($id,$wishlists)){
            //     $packages=$packages->where('user_id',[$id,null])
            //                         ->unique('id');
            // }else{
            //     $packages=$packages->unique('id');
            // }

        return self::cleanToArr($packages);
    }
    public static function getRelated($slug){
        $packages = DB::table('packages')
            ->where('slug',$slug)
            ->select('*')
            ->get();

        $tags = explode(",",$packages[0]->tags);

        foreach($tags as $tag){
            $stags[] = trim($tag," ");
        }

        $packages = Packages::select('*','wishlists.id as w_id','packages.id as id')
            ->leftJoin('wishlists','packages.id','wishlists.package_id')
            ->where('slug',"!=",$slug)
            ->where(function($query) use($stags){
                foreach($stags as $word){
                    $query->orWhere('tags', 'LIKE', '%'.$word.'%');
                }
            })
            ->orderBy('views', 'DESC')
            ->get()
            ->unique('id');

        return self::cleanToArr($packages);
    }
    private static function addPackagesAttr($packages){
        $packages = self::cleanToArr($packages);
        foreach($packages as $index=>$package){
            $commence_dates = DB::table('commence_dates')
                ->leftJoin('packages','packages.id','commence_dates.package_id')
                ->where('package_id',$package['id'])
                ->select('*','commence_dates.id as id')
                ->get();
            $packages[$index]['commence_dates'] = self::cleanToArr($commence_dates);
            foreach($packages[$index]['commence_dates'] as $cindex => $commence_date){
                $packages[$index]['commence_dates'][$cindex]['available_slots'] = self::availableSlots($commence_date['id'],$commence_date['max_per_commence']);
            }
            $itinerary = DB::table('itinerary')
                ->where('package_id',$package['id'])
                ->select('*')
                ->get();
            $packages[$index]['itinerary'] = self::cleanToArr($itinerary);
            // foreach($itinerary as $day){
            //     $endofday = explode(':',$day->end_of_day);
            //     if($endofday[0] == "hotel"){
            //         $hotelinfo = DB::table('hotels')
            //         ->where('id',$endofday[1])
            //         ->select('*')
            //         ->get();
            //         $packages[$index]['hotels'][$endofday[1]] = self::cleanToArr($hotelinfo);
            //     }
            // }
            $additional_info = DB::table('additional_info')
                ->where('package_id',$package['id'])
                ->select('*')
                ->get();
            $packages[$index]['additional_info'] = self::cleanToArr($additional_info);

            $additional_info = DB::table('additional_info')
                ->where('package_id',$package['id'])
                ->select('*')
                ->get();
            $packages[$index]['additional_info'] = self::cleanToArr($additional_info);
        }
        return $packages;
    }
}
