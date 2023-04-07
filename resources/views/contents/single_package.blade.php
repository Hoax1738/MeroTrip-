@extends('layouts.frontend.app')
@section('title') {{__($item['title']).'- Tripkhata®'}} @endsection
@section('slider')
    <link rel="stylesheet" href="{{asset('modalImages/image.css')}}">
@endsection
@section('content')
<section class="content" style="background-color: #f2f2f2  ;">
    <section class="single-header py-4">
            <div class="container ">
                @if (Auth::check())
                @include('contents.emiAlert')
                @else
                @endif
                <p class="bread-crumb">Home <i class="fa fa-chevron-right fa-xs"></i>{{__($item['title'])}} </p>
                <div class="single-title">
                    <div class="d-flex">
                        <h4 class="font-weight-bold">{{__($item['title'])}}</h4>
                        @if(isset($max_price)&& isset($min_price))
                            <div class="mt-1 ml-2 display-5 text-success font-weight-bold">( Rs @if($max_price==$min_price) {{ $max_price }} @else {{ $min_price}} - {{ $max_price }} @endif)</div>
                        @endif
                    </div>
                    <div class="save-buttons">
                        @if(Auth::check() && Auth::user()->hasRole('customer'))<a href="#" class="mr-2"  data-toggle="modal" data-target="#ReferModal" style="letter-spacing: 1px;border-bottom: 1px dashed rgb(24, 20, 20)">Refer a Friend <i class="fas fa-share"></i></a>
                            <a href="@if(count($wishlist)>0) {{ url('/saveWishList',['id'=>$item['id'],'status'=>'stored']) }} @else {{ url('/saveWishList',['id'=>$item['id'],'status'=>'not_stored']) }} @endif">
                                @if(count($wishlist)>0)
                                <i class="fa fa-heart fa-lg"  style=" color: red;"></i>
                                @else
                                <i class="fa fa-heart-o fa-lg "></i>
                                @endif
                            </a>
                            @else
                            <a href="{{ url('login') }}"><i class="fa fa-heart-o fa-lg"></i></a>
                        @endif
                     <button class="btn btn-outline-dark ml-2" data-toggle="modal" data-target="#BookModal">{{ __('Book Now') }}</button>
                    </div>
                </div>
                @if($avg_stars>0)
                <div class="ratings">
                    <div>
                        @for($i=1; $i<=$avg_stars; $i++ )
                            <span class="fa fa-star rateChecked"></span>
                        @endfor

                        @for($i=1; $i<=5-$avg_stars; $i++ )
                            <span class="fa fa-star-o"></span>
                        @endfor

                    </div>
                    <div>
                        <span class="tags ml-2">{{ $no_of_reviews }} reviews</span>
                    </div>
                </div>
                @endif

                <div class="meta-data">
                    <span> <i class="fa fa-map-marker"></i> {{__($item['destination'])}}</span>
                    <span class="border-line" style="border:1px solid #D3D3D3;"> </span>
                    <span><i class="fas fa-calendar-alt"></i> {{__($item['duration'])}} days</span>
                    <span class="border-line" style="border:1px solid #D3D3D3;"> </span>


                    <?php
                        $inc = array_merge(explode("\n",$item['inclusions']),explode("\n",$item['highlights']),explode("\n",$item['travel_option']));
                        foreach($inc as $in){
                            $ico = strtolower(str_replace(" ","-",$in)).".png";
                            if(file_exists('icons/'.$ico)){
                            ?>
                            <img src="{{url('icons/'.$ico)}}" class="tag-cloud-link" style="height:20px; width:20px; margin:0px 5px 0px 5px;"/>
                            <span>{{__($in)}}</span>
                            <span  style="border-right:1px solid #D3D3D3; margin: 3px;"> </span>

                            <?php
                            }
                        }
                    ?>
                     <?php
                     $tags=explode(",",$item['tags']);
                     $no_comma = array();?>
                     @foreach($tags as $tag)
                        <?php  array_push($no_comma, ucfirst($tag));?>
                     @endforeach
                     <span class="tags">{{  implode(", ", $no_comma)}}</span>
                     <span class="border-line" style="border:1px solid #D3D3D3;"> </span>

                     <?php
                        $options=explode(",",$item['travel_option']);?>
                        @foreach($options as $key => $option)
                         <span class="mr-1">@if(trim(ucfirst($option)," ")=='Flight'||trim(ucfirst($option)," ")=='Plane'||trim(ucfirst($option)," ")=='Airplane') <i class="fas fa-plane"></i> @elseif(trim(ucfirst($option)," ")=='Bus') <i class="fas fa-bus" ></i> @elseif (trim(ucfirst($option)," ")=='Car') <i class="fas fa-car" ></i> @endif  {{__($option)}} </span>
                        @endforeach
                </div>
            </div>


        </section>

        <section class="single-main" >
                {{-- <div class="carousel" data-flickity='{"autoPlay": true,"prevNextButtons": true,"contain":true ,"imagesLoaded": true}'>
                    @foreach($images as $key=>$row)
                    <div class="carousel-cell">
                        <img style="height:350px;width:full" src="{{ url($row) }}" alt="{{ $key+1 }} slide" id="myImg<?php echo $key+1;?>" onclick="imgMove({{$key+1}})">
                    </div>
                    @endforeach
                </div> --}}

                <div id="carouselExampleIndicators" class="carousel slide container" data-ride="carousel">
                    <?php
                        $images=explode(',',$item['images']);
                    ?>
                    <ol class="carousel-indicators">
                        @foreach($images as $key=>$row)
                            <li data-target="#carouselExampleIndicators" data-slide-to="{{ $key }}" class="@if($key==0)active @endif"></li>
                        @endforeach
                    </ol>
                    <div class="carousel-inner">
                        @foreach($images as $key=>$row)
                            <div class="carousel-item @if($key==0)active @endif img-fluid">
                                @php $image=\App\Image::find($row); @endphp
                                @if($image!=NULL)
                                    <img class="d-block w-100" style="height: 570px; object-fit:cover;" @if($image->drive_id==NULL) src="{{url("$image->directory/$image->local_filename")}}" @else src="https://drive.google.com/uc?export=view&id={{$image->drive_id}}" @endif alt="{{ $key+1 }} slide" id="myImg<?php echo $key+1;?>" onclick="imgMove({{$key+1}})">
                                @endif    
                            </div>
                        @endforeach
                    </div>

                    @if(count($images)>1)
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    @endif
                </div>


                <div class="container">
                    <div class="row mt-5">
                        <div class="col-sm-12 col-md-12 col-lg-12 mb-4">
                            <div class="box-content">
                                <h5 class="font-weight-bold mb-3"><i class="fas fa-book-open fa-lg mr-2"></i> Overview</h5>
                                <p>{{$item['description']}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @if($item['highlights'])
                        <div class="col-sm-12 col-md-12 col-lg-12 mb-4">
                            <div class="box-content">
                                <h5 class="font-weight-bold mb-3"><i class="fas fa-clipboard-list fa-lg mr-2"></i> Highlights</h5>
                                <?php
                                    $highlights=explode("\n",$item['highlights'])
                                ;?>
                                @foreach($highlights as $data)
                                    <p>
                                        {{ __($data) }}
                                    </p>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="row">
                        @if($item['inclusions'])
                        <div class="col-sm-6 col-md-6 col-lg-6 mb-4">
                            <div class="box-content">
                                <h5 class="font-weight-bold mb-3"><i class="fas fa-clipboard-list fa-lg mr-2"></i> Inclusions</h5>
                                <p class="text-justify">
                                    <?php
                                        $inclusions=explode("\n",$item['inclusions'])
                                        ;?>
                                        @foreach($inclusions as $info)
                                        <p>
                                        <i class="fas fa-check-circle text-success mr-1"></i>{{__($info)}}</p>
                                        @endforeach
                                    </p>
                                </div>
                            </div>
                            @endif
                            @if($item['exclusions'])
                            <div class="col-sm-6 col-md-6 col-lg-6 mb-4">
                                <div class="box-content">
                                    <h5 class="font-weight-bold mb-3"><i class="fas fa-clipboard-list fa-lg mr-2"></i> Exclusions</h5>
                                        <p class="text-justify">
                                            <?php
                                            $exclusions=explode("\n",$item['exclusions'])
                                            ;?>
                                            @foreach($exclusions as $exclusion)
                                            <p>
                                            <i class="fas fa-times-circle text-danger mr-1"></i>
                                            {{__($exclusion)}}</p>
                                            @endforeach
                                        </p>
                                </div>
                            </div>
                            @endif
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12 mb-4">
                            <div class="box-content">
                                <h5 class="font-weight-bold mb-3"><i class="fas fa-route fa-lg mr-2"></i>{{__($item['title'])}} {{ __('Itinerary') }}</h5>
                                <?php $show = false; ?>
                                @foreach($item['itinerary'] as $it=>$day)
                                    <?php $itiid = rand(0,time());?>
                                        <div>
                                            <div>
                                                <div class="desc">
                                                    <div>
                                                    <a data-toggle="collapse" href="#collapse{{$itiid}}" role="button" aria-expanded="false" aria-controls="collapseExample"><p  class="toggles"><i class="fa fa-caret-right mr-2"></i><span class="mr-2" style="border-bottom:thin dotted">{{__('Day').' '.($day['day'])}}:   {{__($day['title'])}}</span></p>
                                                    </div>
                                                    </a>
                                                </div>
                                            </div>

                                            <div id="collapse{{$itiid}}" class="collapse<?php if($show) echo $show; $show = false;?>" role="tabpanel">
                                                <div class="card-body">
                                                    <div class="row mb-2">
                                                        <div class="col-sm-8 col-md-8 col-lg-8">
                                                            @if($day['description'])
                                                                <p class="text-justify">{{ $day['description'] }} </p>
                                                            @endif
                                                            @if($day['destination_place'])
                                                                <h5>{{ __('Destination') }}</h5>
                                                                <ul>
                                                                <li>{{ $day['destination_place'] }} </li>
                                                                </ul>
                                                            @endif
                                                        </div>
                                                        @if($day['images'])

                                                        <div class="col-sm-4 col-md-4 col-lg-4">
                                                            <div class="row">
                                                                <div id="carouselExampleIndicators{{ $it }}" class="carousel slide container" data-ride="carousel">
                                                                    <?php
                                                                        $itinerary_images=explode(',',$day['images']);
                                                                    ?>
                                                                    <ol class="carousel-indicators">
                                                                        @foreach($itinerary_images as $iti_key=>$itinerary_image)
                                                                            <li data-target="#carouselExampleIndicators{{ $it }}" data-slide-to="{{ $iti_key }}" class="@if($iti_key==0)active @endif"></li>
                                                                        @endforeach
                                                                    </ol>
                                                                    <div class="carousel-inner">
                                                                        @foreach($itinerary_images as $iti_key=>$itinerary_image)
                                                                            <div class="carousel-item @if($iti_key==0)active @endif img-fluid">
                                                                                @php $image=\App\Image::find($itinerary_image); @endphp
                                                                                @if($image!=NULL)
                                                                                    <img class="d-block w-100" style="height: 200px" @if($image->drive_id==NULL) src="{{ url("$image->directory/$image->local_filename") }}" @else src="https://drive.google.com/uc?export=view&id={{$image->drive_id}}" @endif>
                                                                                @endif    
                                                                            </div>
                                                                        @endforeach
                                                                    </div>

                                                                    @if(count($itinerary_images)>1)
                                                                        <a class="carousel-control-prev" href="#carouselExampleIndicators{{ $it }}" role="button" data-slide="prev">
                                                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                                            <span class="sr-only">Previous</span>
                                                                        </a>
                                                                        <a class="carousel-control-next" href="#carouselExampleIndicators{{ $it }}" role="button" data-slide="next">
                                                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                                            <span class="sr-only">Next</span>
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif

                                                        @if($day['inclusions'])
                                                            <div class="col-sm-4 col-md-4 col-lg-4">
                                                                <h5>{{ __('Inclusions') }}</h5>
                                                                <?php
                                                                $inclusions=explode("\n",$day['inclusions']);?>
                                                                <ul>
                                                                    @foreach($inclusions as $inclusion)
                                                                        <li>
                                                                            {{ __($inclusion) }}
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        @endif
                                                        @if($day['exclusions'])
                                                            <div class="col-sm-4 col-md-4 col-lg-4">
                                                                <h5>{{ __('Exclusions') }}</h5>
                                                                <?php $exclusions=explode("\n",$day['exclusions']);?>
                                                                <ul>
                                                                    @foreach($exclusions as $exclusion)
                                                                        <li>
                                                                            {{ __($exclusion) }}
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="row">
                                                        @if($day['key_activities'])
                                                        <div class="col-sm-4 col-md-8 col-lg-8">
                                                        <h5>{{ __('Key Activities') }}</h5>
                                                        <?php
                                                        $activities=explode("\n",$day['key_activities'])
                                                        ;?>
                                                        <ul>
                                                            @foreach($activities as $activity)
                                                                <li>
                                                                    {{ __($activity) }}
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                @endforeach
                            </div>
                        </div>
                    </div>



                    @if(count($reviews)>0)
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12 mb-4">
                                <div class="itinerary-section">
                                        <h5 class="font-weight-bold"> All Ratings and Reviews</h5>
                                     @foreach($reviews as $info)
                                    <div class="reviews-members pt-4 pb-4">
                                        <div class="media">
                                            <a href="#"><img alt="Generic placeholder image" src="@if($info->profile_image!=NULL || $info->profile_image!='') <?php echo url('images/'.$info->profile_image);?> @else https://ui-avatars.com/api/?name={{$info->name}}&color=7F9CF5&background=EBF4FF @endif" class="mr-3 rounded-pill"></a>
                                            <div class="media-body">
                                                <div class="reviews-members-header">
                                                    <div class="star-rating float-right">

                                                        @for($i=1; $i<=$info->rating;$i++)
                                                            <i class="fa fa-star rateChecked"></i>
                                                        @endfor

                                                        @for($i=1; $i<=5-$info->rating;$i++)
                                                            <i class="fa fa-star-o"></i>
                                                        @endfor

                                                    </div>
                                                    <h6 class="mb-1"><a class="text-black" href="#">{{ __($info->name) }}</a></h6>

                                                    <h5>{{ $info->title }}</h5>

                                                    <p class="text-gray">{{  strftime(" %b, %Y",strtotime(__($info->visit_date))) }}</p>
                                                </div>

                                                <div class="reviews-members-body mt-2">
                                                    <p class="text-justify">{{ __($info->review) }}</p>
                                                </div>

                                                <p class="text-gray float-right">{{ __('Written In') }}: {{  strftime("%d %B %Y",strtotime($info->created_at)) }}</p>

                                            </div>
                                        </div>
                                        @if(count($reviews)>1) <hr> @endif
                                    </div>
                                    @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>




                @if(count($related)>0)
                <section id="featured" class="ftco-section" >
                    <div class="container">
                        <div class="row justify-content-center pb-4">
                            <div class="col-md-6 heading-section text-center ftco-animate">
                                <span class="subheading">{{ __('Related Trips') }}</span>
                            </div>
                        </div>
                            <div class="row">
                                @forelse($related as $package)
                                    <div class="col-md-4 ftco-animate">
                                        <div class="project-wrap">
                                            <a href="{{route('singlePackage',['slug'=>$package['slug']])}}" class="img">
                                                <?php $images=explode(",",$package['images']); $image_info=\App\Image::find($images[0]);?>
                                                @if($image_info!=NULL)
                                                    <img class="img" @if($image_info->drive_id==NULL) src="{{url("$image_info->directory/$image_info->local_filename")}}" @else src="https://drive.google.com/uc?export=view&id={{$image_info->drive_id}}" @endif alt="">
                                                @endif    
                                                <span class="price">{{$package['duration']}} Days</span>
                                            </a>
                                            <span class="wishlist-btn">
                                                @if(Auth::check() && Auth::user()->hasRole('customer'))
                                                    <a href="@if($package['user_id']==auth()->user()->id) {{ url('/saveWishList',['id'=>$package['id'],'status'=>'stored']) }} @else {{ url('/saveWishList',['id'=>$package['id'],'status'=>'not_stored']) }} @endif">
                                                        @if($package['user_id']==auth()->user()->id)
                                                            <i class="fa fa-heart"  style="background: #FFF;padding: 10px;margin-right: 5px;border-radius: 50% !important; color:red;"></i>
                                                            @else
                                                            <i class="fa fa-heart-o" style="background: #FFF;padding: 10px;margin-right: 5px;border-radius: 50% !important;"></i>
                                                        @endif
                                                    </a>
                                                @else
                                                    <a href="{{ url('login') }}"><i class="fa fa-heart-o" style="background: #FFF;padding: 10px;margin-right: 5px;border-radius: 50% !important;"></i></a>
                                                @endif
                                            </span>
                                            <div class="text p-4">
                                                <h3><a href="{{route('singlePackage',['slug'=>$package['slug']])}}"> {{$package['title']}}</a></h3>

                                                <span class="destination"> <i class="fa fa-map-marker"></i> {{$package['destination']}}</span>
                                                <span  style="border-right:1px solid #D3D3D3; margin: 3px;"> </span>
                                                <?php
                                                    $counter = 1;
                                                    $maximum = 3;
                                                    $tags=explode(",",$package['tags']);
                                                    $no_comma = array();?>
                                                    @foreach($tags as $tag => $value )
                                                        <?php array_push($no_comma, ucfirst($value)); $counter++;?>
                                                        <?php if ($counter === $maximum) {
                                                            break;
                                                        }
                                                        ?>
                                                    @endforeach
                                                <span class="tags ml-1">{{  implode(", ", $no_comma)}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="col-md-12"><div class="d-flex justify-content-center text-danger">* Trip Not Available</div></div>
                                @endforelse
                            </div>
                    </div>
                </section>
                @endif




        </section>



    <div class="modal fade" id="BookModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-custom modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Choose a Package') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                    @forelse($item['commence_dates'] as $commence_date)
                        {{-- @if($commence_date['commence_date']>date('Y-m-d')) --}}
                            <div class="col-md-5">
                                <div class="card mb-4 text-center box-shadow" id="single-package-type">
                                    <div class="card-header card-header-trip">
                                        <h4 class="my-0 font-weight-normal">{{__($commence_date['commence_date'])}}</h4>
                                    </div>
                                    <div class="card-body">
                                        <?php
                                            $to = \Carbon\Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
                                            $from = \Carbon\Carbon::createFromFormat('Y-m-d',$commence_date['commence_date']);// is greater
                                            $diff_in_months = $to->diffInMonths($from);
                                            if($diff_in_months<=0) $diff_in_months=1; 
                                            $per_month=round($commence_date['price']/$diff_in_months);
                                            
                                        ?>
                                        <h3 class="card-title pricing-card-title">Rs {{ $per_month }}/mo</h3>
                                        <small class="card-title pricing-card-title">Total Cost: Rs {{__($commence_date['price'])}}</small>
                                        <ul class="list-unstyled mt-3 mb-4">
                                            {{-- <li>{{__($commence_date['title'])}}</li> --}}
                                            {{-- <li>{{ __('Date') }}: {{__($commence_date['commence_date'])}}</li> --}}
                                            {{-- <li>{{ __('Total  Seats for the date')}}: {{ ($commence_date['max_per_commence']) }}</li> --}}
                                            <li>{{ __(' Available Seats')}}: {{($commence_date['available_slots'])}}</li>
                                            <li>{{ __('Trip Duration')}}: {{($commence_date['duration'])}} Days</li>

                                        </ul>
                                        @if($commence_date['available_slots']>0 && $commence_date['commence_date']>date('Y-m-d'))
                                        <form method="post" action="{{route('calculateEMI',['trip' => $item['slug'], 'date'=>$commence_date['commence_date']])}}">@csrf<input type="hidden" name="clickref" value="{{$commence_date['id']}}"/><input type="hidden" name="package_id" value="{{$commence_date['package_id']}}"/><input type="submit" class="btn btn-outline-dark" value="Book for this date"/></form>
                                        @else
                                        <span class="text-center text-danger font-weight-bold"> * {{ __('Trip') }} {{ __('Not Available') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            {{-- @else
                                <span class="text-center text-danger font-weight-bold"> * Trip Not Available </span>
                        @endif --}}
                        @empty
                        <span class="text-center text-danger font-weight-bold">* {{ __('Trip') }} {{ __('Not Available') }} </span>
                    @endforelse
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>


        <!-- The Modal -->
     <div id="myModal" class="modal_img">

        <!-- The Close Button -->
        <div class="ourImg">
            <span class="close" id="shut">&times;</span>
        </div>

        <!-- Modal Content (The Image) -->
        <img class="modal-content_img" id="img01">

        <!-- Modal Caption (Image Text) -->
        <div id="caption"></div>
    </div>

</section>



<script>
    var modal = document.getElementById("myModal");
    var modalImg = document.getElementById("img01");
    var captionText = document.getElementById("caption");
    // img.onclick = function(){
    // modal.style.display = "block";
    // modalImg.src = this.src;
    // captionText.innerHTML = this.alt;
    // }

    function imgMove(id){
        modal.style.display = "block";
        modalImg.src = document.getElementById("myImg"+id).src;
        captionText.innerHTML = document.getElementById("myImg"+id).alt;
    }

    var span = document.getElementById("shut");

    span.onclick = function() {
        modal.style.display = "none";
    }

</script>



<script>
$('.toggles').click(function() {
    $("i", this).toggleClass("fa-caret-down fa-caret-right");
});
</script>

<script type="text/javascript">
    $(document).ready(function() {
      $('.carousel').carousel({
        interval: 1500
      });

    //   $(".carousel").on("mouseenter",function() {
    //     $(this).carousel('cycle');
    //     }).on("mouseleave", function() {
    //     $(this).carousel('pause');
    //  });

    });
</script>


@endsection
