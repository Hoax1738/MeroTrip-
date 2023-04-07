<?php

namespace App\Http\Controllers;

use DB;
use App\Menu;
use App\Review;
use App\Enquiry;
use App\Setting;
use App\Packages;
use App\CommenceDates;
use App\Mail\SendMail;
use Facade\Ignition\Support\Packagist\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Artisan;
use App\User;
use App\Image;

class PackagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Packages  $packages
     * @return \Illuminate\Http\Response
     */
    public function home(Packages $packages){
        $package_images = Packages::select('images','title','slug')->get();
        $special_offers = Packages::getSpecial();
        $top = Packages::getTop();
        $featured = Packages::getFeatured();
        // dd($featured);
        $search_background = Setting::select()->where('name','search_background')->first();
        $menu_items = Menu::select()->orderBy('position','asc')->get();
        return view('contents.home',['special_offers' => $special_offers,'top' => $top,'featured' => $featured,'search_background'=>$search_background,'menu_items'=>$menu_items,'package_images'=>$package_images]);
    }
    public function show(Packages $packages){
        $breadcrumb = 'Packages';

        $min=CommenceDates::min('price');
        $max=CommenceDates::max('price');

        if($min==$max){
            $max=$max+100;
        }

        $package_name=Packages::pluck('title');

        $items = Packages::get();

        $tag=null;

        return view('contents.packages',['items'=>$items,'breadcrumb'=>$breadcrumb,'min'=>$min,'max'=>$max,'package_name'=>$package_name,'tag'=>$tag]);
    }
    public function showsingle(Packages $packages, $slug){

        Packages::viewspp($slug);
        $item = Packages::getSingle($slug)[0];
        $related = Packages::getRelated($slug);

        $price=DB::table('commence_dates')
                    ->where('package_id',$item['id'])
                    ->pluck('price')
                    ->toArray();

        $max_price=max($price);
        $min_price=min($price);

        $maximum_stars=Review::where('package_id',$item['id'])
                        ->sum('rating');

        $maximum_users=Review::where('package_id',$item['id'])
                        ->count();

        $no_of_reviews= Review::where('package_id',$item['id'])
                        ->count();

        if($maximum_users==0){
            $maximum_users=1;
        }

        $avg_stars=round($maximum_stars/$maximum_users);

        if($avg_stars>=5){
            $avg_stars=5;
        }

        if(Auth::user()){
            $wishlist=DB::table('wishlists')
            ->where('user_id',Auth::user()->id)
            ->where('package_id',$item['id'])
            ->get();
        }else{
            $wishlist=[];
        }

        $reviews=Review::select('reviews.title','visit_date','review','name','profile_image','rating','reviews.created_at')
                    ->leftJoin('packages','packages.id','reviews.package_id')
                    ->leftJoin('users','users.id','reviews.user_id')
                    ->where('slug',$slug)
                    ->get();

        return view('contents.single_package',['item' => $item,'related' => $related,'wishlist'=>$wishlist,'reviews'=>$reviews,'avg_stars'=>$avg_stars,'no_of_reviews'=>$no_of_reviews,'max_price'=>$max_price,'min_price'=>$min_price]);
    }


    public function aboutPage()
    {
        $breadcrumb = 'About Us';
        return view('contents.aboutus',compact('breadcrumb'));
    }

    public function contactPage()
    {
        $breadcrumb = 'Contact';
        return view('contents.contact',compact('breadcrumb'));
    }

    public function testimonialPage()
    {
        $breadcrumb = 'Testimonial';
        return view('contents.testimonial',compact('breadcrumb'));
    }

    public function termsPage()
    {
        return view('contents.terms_condition');
    }

    public function policyPage()
    {
        return view('contents.privacy_policy');
    }

    public function faqPage()
    {
        return view('contents.faq');
    }

    public function tagPage($tag)
    {
        $price=Packages::select()
                        ->leftJoin('commence_dates','packages.id','commence_dates.package_id')
                        ->where('tags','like','%'.$tag.'%');
                                      
        $min=$price->min('price');

        $max=$price->max('price');

        $items = Packages::select('*','wishlists.id as w_id','packages.id as id')
        ->leftJoin('wishlists','packages.id','wishlists.package_id')
        ->where('tags','like','%'.$tag.'%')
        ->orderBy('views', 'DESC')
        ->get()
        ->unique('id');

        $package_name=Packages::where('tags','like','%'.$tag.'%')->pluck('title');

        return view('contents.tag_package',compact('items','min','max','package_name','tag'));
    }

    public function galleryPage()
    {

        $package_images = Packages::select('images','title','slug')->take(9)->orderBy('id','desc')->get();
        $breadcrumb = 'Gallery';
        return view('contents.gallery',compact('breadcrumb','package_images'));
    }

    public function singleGallery(Request $request,$slug)
    {
        $imageitems = Packages::getSingle($slug)[0];
        return view('contents.single_gallery',compact('imageitems'));


    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Packages  $packages
     * @return \Illuminate\Http\Response
     */
    public function edit(Packages $packages)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Packages  $packages
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Packages $packages){
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Packages  $packages
     * @return \Illuminate\Http\Response
     */
    public function destroy(Packages $packages)
    {
        //
    }
    public function searchPackage(Request $request){
        if(isset($request->tags)){
            $price=Packages::select()
            ->leftJoin('commence_dates','packages.id','commence_dates.package_id')
            ->where('tags','like','%'.$request->tags.'%'); 
    
            $min=$price->min('price');
            $max=$price->max('price');
            $package_name=Packages::where('tags','like','%'.$request->tags.'%')->pluck('title');
            $tag=$request->tags;

        }else{
            $min=CommenceDates::min('price');
            $max=CommenceDates::max('price');
            $package_name=Packages::pluck('title');
            $tag=null;
        }

        $data=explode("-",$request->trip_date);
        $breadcrumb = 'Search';
        $date=($request->cdate);
        $cdate=date('Y-m-d', strtotime(str_replace('.', '/', $date)));
        $items=Packages::select()
                    ->leftJoin('commence_dates','commence_dates.package_id','packages.id')
                    ->when($request->title,function($q,$status){
                        $q->where('title','LIKE','%'.$status.'%')
                            ->orWhere('tags','LIKE','%'.$status.'%');
                    })
                    ->when($request->cdate,function($q,$status){
                        $q->where('commence_date',date('Y-m-d', strtotime(str_replace('.', '/', $status))));
                    })

                    ->when($request->trip_date,function($q) use($data){
                        $q->whereYear('commence_date', '=', $data[0])
                          ->whereMonth('commence_date', '=', $data[1]);
                    })

                    ->when($request->price,function($q,$status){
                        $q->where('price',$status);
                    })

                    ->when($request->tags,function($q,$status){
                        $q->where('tags','LIKE','%'.$status.'%');
                    })

                    ->when($request->min,function($q) use($request) {
                        $q->when($request->max,function ($q) use ($request){
                            $q->whereBetween('price',[$request->min,$request->max]);
                        });
                    })

                    ->get()->unique('package_id');

        return view('contents.packages',['items' => $items,'breadcrumb'=>$breadcrumb,'min'=>$min,'max'=>$max,'package_name'=>$package_name,'tag'=>$tag]);
    }

    public function getAjaxDestination(Request $request){

        $items=Packages::select()
                ->leftJoin('commence_dates','commence_dates.package_id','packages.id')
                ->when($request->title,function($q,$status){
                    $q->where('title','LIKE','%'.$status.'%')
                      ->orWhere('tags','LIKE','%'.$status.'%');
                })
                ->get()->unique('package_id');

        foreach($items as $row){
            $img=explode(',',$row->images);
            $img_data=Image::find($img[0]);

            if($img_data->drive_id==NULL){
                $img_info[]="$img_data->directory/$img_data->local_filename";
            }else{
                $img_info[]="https://drive.google.com/uc?export=view&id=$img_data->drive_id";
            }
        }        

        if($items->isEmpty()){
            return response()->json(['error'=>'No Records Found']);
        }else{
            return response()->json(['success'=>$items,'images'=>$img_info]);
        }

    }

    public function getAllAjaxDestination(){
        $allRecords=Packages::select()
        ->leftJoin('commence_dates','commence_dates.package_id','packages.id')
        ->get()->unique('package_id');

        // foreach($allRecords as $row){
        //     $output.='<li class="font-weight-bold">'.$row['title'].'<li>';
        // }

        // $output.='</ul>';
        // echo $output;

        if($allRecords->isEmpty()){
            return response()->json(['error'=>'Array Empty']);
        }
        else
        {
            return response()->json(['success'=>$allRecords]);
        }
    }

    public function saveWishList($id,$status){
        if(Auth::check()){
            if($status=='not_stored'){
                $abc=DB::table('wishlists')
                ->insert([
                    'package_id'=>$id,
                    'user_id'=>Auth::user()->id,
                    'created_at' =>  \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),
                ]);
                return redirect()->back()->with('success_message','Package Added To  Wishlist');

            }else{
                DB::table('wishlists')
                    ->where('package_id',$id)
                    ->where('user_id',Auth::user()->id)
                    ->delete();

                    return redirect()->back()->with('success_message','Package Removed From Wishlist');

            }


        }else{
            return redirect()->route('login');
        }
    }

    public function showAddReview(){

        $packages=Packages::select('package_id','title','slug','images','destination')
                ->leftJoin('commence_dates','packages.id','commence_dates.package_id')
                ->leftJoin('commits','commence_dates.id','commits.commence_date_id')
                ->where('user_id',Auth::user()->id)
                ->where('commits.status','active')
                ->get()->unique('package_id');

        // $packages=Packages::select('title','slug','images','id','destination')->get();
        return view('contents.add_review',compact('packages'));
    }

    public function saveReview(Request $request){

        $key=$request->packageKey;
        $request->validate([
            "rating$key"=>'required',
            "title$key"=>'required',
            "review$key"=>'required|min:200',
            "visit_date$key"=>'required'
        ]);

         Review::create([
             'rating'=>$request->post('rating'.$key),
             'title'=>$request->post('title'.$key),
             'review'=>$request->post('review'.$key),
             'visit_date'=>\Carbon\Carbon::createFromFormat('Y-m',$request->post('visit_date'.$key)),
             'user_id'=>Auth::user()->id,
             'package_id'=>$request->package_id
         ]);

         return redirect('/review')->with('success','Inserted Successfully');
    }


    public function sendEnquiry(Request $request)
    {
        // dd($request->message);
        $request->validate(
            [
                'username' => 'required',
                'email' => 'required',
                'subject' => 'required',
                'message'=>'required',
            ]
        );
        if($request->isMethod('post'))
        {
            $data = $request->all();
            $enquiry= new Enquiry();
            $enquiry->username=$data['username'];
            $enquiry->email=$data['email'];
            $enquiry->subject=$data['subject'];
            $enquiry->message=$data['message'];
            $enquiry->save();
            return redirect('/contact')->with('success_message','Thanks for your message, We will reply ASAP');
        }

    }

    public function clear(){

        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        Artisan::call('optimize');
        Artisan::call('route:cache');
        Artisan::call('config:cache');
        echo '<h1>All Clear</h1>';
    }

    public function check(){
        // $user=[
        //     'invoice_id'=>123,
        //     'invoice_created'=>'2021-01-08',
        //     'name'=>'Pemba',
        //     'email'=>'pemba@gmail.com',
        //     'payment_method'=>'khalti',
        //     'payment_type'=>'Advance Payment',
        //     'item'=>'Trip To solu',
        //     'amount'=>'123',
        //     'due_date'=>'2020-01-20',
        //     'title'=>'Pemba',
        //     'payment_amount'=>200,
        //     'next_pay_date'=>'2020-01-20'
        // ];

        //  foreach(['admin@gmail.com',Auth::user()->email] as $to){
        //     Mail::to($to)->send(new SendMail($user,'payment'));
        //  }
        // echo "Hello";

        // return view('email.refermail');

        Artisan::call('storage:link');

    }
}
