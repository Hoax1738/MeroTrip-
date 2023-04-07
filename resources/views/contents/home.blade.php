@extends('layouts.frontend.app')
@section('title') Tripkhata® - Start Saving for Your Next Vacation Plan @endsection
@section('slider')
    <link rel="stylesheet" href="{{ url('/priceslider/price.css') }}">
@endsection
@section('content')
<section class="content">
    <section class="ftco-section" >
        <div class="container">
                @if (Auth::check())
                @include('contents.emiAlert')
                @endif
            <div class="scrolling-wrapper1 user-select-none">
                @foreach ( $menu_items as $menu_item )
                <a href="{{url('tag/'.$menu_item->href)}}"><div class="card1">{{$menu_item->title}}<i class="fas fa-{{$menu_item->icon}} ml-4"></i></div></a>
                @endforeach

            </div>
        </div>
    </section>

    <section class="ftco-intro ftco-section">
        <div class="container">
            @if(session('success_message'))
            <div class="alert alert-success alert-dismissible justify-content-center">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>{{session('success_message')}}</strong>
            </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="img d-flex align-items-center">
                         @if(isset($search_background->value)) 
                            @php $images=\App\Image::find($search_background->value); @endphp
                                style="background-image: @if($images->drive_id==NULL) url('{{ asset("$images->directory/$images->local_filename") }}')  @else url(https://drive.google.com/uc?export=view&id={{$images->drive_id}}) @endif;height:500px;" >
                        @endif    
                        <div class="wrapper">
                            <div class="search-input">
                            <form method="POST" action="{{ route('search.package') }}" id="searchForm">
                                @csrf
                                <input type="text" placeholder="{{ __('Where to?') }}" id="destination" autocomplete="off" name="title">
                            </form>
                            <div class="autocom-box">
                                <div id="searchData"></div>
                            </div>

                            <div class="icon"><a href="#" onclick="event.preventDefault();document.getElementById('searchForm').submit();"><i class="fas fa-search"></i></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="poster-title1" >
            <h1>{{ __('Start Saving!') }}</h1>
            <h1>{{ __('For your next vacation 🌴') }}</h1>
        </div>
    </div>


    @if(count($featured)>0)
        <section id="featured" class="ftco-section" >
            <div class="container">
                <div class="row justify-content-center pb-4">
                    <div class="col-md-6 heading-section text-center ftco-animate">
                        <span class="subheading">{{ __('Featured Trips') }}</span>
                    </div>
                </div>

                <div class="row">
                    <div class="@if(count($featured)==1)col-md-4 @elseif(count($featured)==2)col-md-8 @else col-md-12 @endif">
                        <div class="feature-owl owl-carousel owl-theme ftco-animate">
                            @foreach($featured as $ft)
                            <div class="item">
                                <div class="project-wrap mt-2">
                                    <a href="{{route('singlePackage',['slug'=>$ft['slug']])}}" class="img">
                                        <?php
                                            $images=explode(',',$ft['images']);
                                            $images_info=\App\Image::find($images[0]);
                                        ?>
                                        @if($images_info!=NULL)
                                            <img class="img" @if($images_info->drive_id==NULL) src="{{url("$images_info->directory/$images_info->local_filename")}}" @else src="https://drive.google.com/uc?export=view&id={{$images_info->drive_id}}" @endif alt="featured-trip">
                                        @endif    
                                        <span class="price">{{$ft['duration']}} {{ __('Days') }}</span>
                                    </a>
                                    <span class="wishlist-btn mt-2">
                                        @if(Auth::check() && Auth::user()->hasRole('customer'))
                                            <a href="@if($ft['user_id']==auth()->user()->id) {{ url('/saveWishList',['id'=>$ft['id'],'status'=>'stored']) }} @else {{ url('/saveWishList',['id'=>$ft['id'],'status'=>'not_stored']) }} @endif">
                                                @if($ft['user_id']==auth()->user()->id)
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
                                        <h3><a href="{{route('singlePackage',['slug'=>$ft['slug']])}}"> {{__($ft['title'])}}</a></h3>
                                        <span class="destination"> <i class="fa fa-map-marker"></i> {{__($ft['destination'])}}</span>
                                        <span  style="border-right:1px solid #D3D3D3; margin: 3px;"> </span>
                                        <?php
                                        $counter = 1;
                                        $max = 3;
                                        $tags=explode(",",$ft['tags']);
                                        $no_comma = array();?>
                                        @foreach($tags as $tag => $value )
                                            <?php array_push($no_comma, ucfirst($value)); $counter++;?>
                                            <?php if ($counter === $max) {
                                                break;
                                            }
                                            ?>
                                        @endforeach
                                        <span class="tags ml-1">{{  implode(", ", $no_comma)}}</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </section>
    @endif

    @if(count($special_offers)>0)
        <section class="ftco-section">
            <div class="container">
                <div class="row justify-content-center pb-4">
                    <div class="col-md-12 heading-section text-center ftco-animate">
                        <span class="subheading">{{ __('Special Offers Destination') }}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="@if(count($special_offers)==1)col-md-4 @elseif(count($special_offers)==2)col-md-8 @else col-md-12 @endif">
                        <div class="special-offers-owl owl-carousel owl-theme ftco-animate">
                            @foreach($special_offers as $ft)
                            <div class="item">
                                <div class="project-wrap mt-2">
                                    <a href="{{route('singlePackage',['slug'=>$ft['slug']])}}" class="img">
                                        <?php
                                            $images=explode(',',$ft['images']);
                                            $images_info=\App\Image::find($images[0]);
                                        ?>
                                        @if($images_info!=NULL)
                                            <img class="img" @if($images_info->drive_id==NULL) src="{{url("$images_info->directory/$images_info->local_filename")}}" @else src="https://drive.google.com/uc?export=view&id={{$images_info->drive_id}}" @endif alt="special-offers">
                                        @endif    
                                        <span class="price">{{$ft['duration']}} {{ __('Days') }}</span>
                                    </a>
                                    <span class="wishlist-btn mt-2">
                                        @if(Auth::check() && Auth::user()->hasRole('customer'))
                                            <a href="@if($ft['user_id']==auth()->user()->id) {{ url('/saveWishList',['id'=>$ft['id'],'status'=>'stored']) }} @else {{ url('/saveWishList',['id'=>$ft['id'],'status'=>'not_stored']) }} @endif">
                                                @if($ft['user_id']==auth()->user()->id)
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
                                        <h3><a href="{{route('singlePackage',['slug'=>$ft['slug']])}}"> {{__($ft['title'])}}</a></h3>
                                        <span class="destination"> <i class="fa fa-map-marker"></i> {{__($ft['destination'])}}</span>
                                        <span  style="border-right:1px solid #D3D3D3; margin: 3px;"> </span>
                                        <?php
                                        $counter = 1;
                                        $max = 3;
                                        $tags=explode(",",$ft['tags']);
                                        $no_comma = array();?>
                                        @foreach($tags as $tag => $value )
                                            <?php array_push($no_comma, ucfirst($value)); $counter++;?>
                                            <?php if ($counter === $max) {
                                                break;
                                            }
                                            ?>
                                        @endforeach
                                        <span class="tags ml-1">{{  implode(", ", $no_comma)}}</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- @if(count($top)>0)
        <section class="ftco-section">
            <div class="container">
                <div class="row justify-content-center pb-4">
                    <div class="col-md-12 heading-section text-center ftco-animate">
                        <span class="subheading">{{ __('Top Tour Packages') }}
                        </span>

                    </div>
                </div>
                <div class="row d-flex">
                    <div class="@if(count($top)==1) col-md-4 @elseif(count($top)==2) col-md-8 @else col-md-12 @endif">
                        <div class="top-owl owl-carousel owl-theme ftco-animate">
                            @foreach($top as $ft)
                            <div class="item">
                                <div class="project-wrap mt-2">
                                    <a href="{{route('singlePackage',['slug'=>$ft['slug']])}}" class="img" style="background-image: url($ft['images']);">
                                        <?php
                                            $images=explode(',',$ft['images']);
                                        ?>
                                        <img class="img" src="{{ $images[0] }}" alt="featured-trip">
                                        <span class="price">{{$ft['duration']}} {{ __('Days') }}</span>
                                    </a>
                                    <span class="wishlist-btn mt-2">
                                        @if(Auth::check() && Auth::user()->hasRole('customer'))
                                            <a href="@if($ft['user_id']==auth()->user()->id) {{ url('/saveWishList',['id'=>$ft['id'],'status'=>'stored']) }} @else {{ url('/saveWishList',['id'=>$ft['id'],'status'=>'not_stored']) }} @endif">
                                                @if($ft['user_id']==auth()->user()->id)
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
                                        <h3><a href="{{route('singlePackage',['slug'=>$ft['slug']])}}"> {{__($ft['title'])}}</a></h3>
                                        <span class="destination"> <i class="fa fa-map-marker"></i> {{__($ft['destination'])}}</span>
                                        <span  style="border-right:1px solid #D3D3D3; margin: 3px;"> </span>
                                        <?php
                                        $counter = 1;
                                        $max = 3;
                                        $tags=explode(",",$ft['tags']);
                                        $no_comma = array();?>
                                        @foreach($tags as $tag => $value )
                                            <?php array_push($no_comma, ucfirst($value)); $counter++;?>
                                            <?php if ($counter === $max) {
                                                break;
                                            }
                                            ?>
                                        @endforeach
                                        <span class="tags ml-1">{{  implode(", ", $no_comma)}}</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif --}}
</section>

<script>
    function slugify(content) {
    return content.toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,'');
    }
    $(document).ready(function(){
        $('#destination').keyup(function(e){
            var title=$(this).val();
            if(title!=''){
                $.ajax({
                    url:"{{ url('ajaxDestination') }}",
                    method:'post',
                    data:{
                        _token: "{{ csrf_token() }}",
                        title:title
                    },
                    success:function(data){
                        $('#searchData').empty();
                        $('#searchData').fadeIn();
                        if(data.success){
                            // jQuery.each(data.success, function(key, value){
                            // var images=value['images'].split(',');
                            // jQuery('#searchData').append('<li class="font-weight-bold text-dark">'+'<img src="'+images[0]+'" height="60px" width="60px" style="margin-right:20px;">'+value['title']+'</li>');
                            // });
                            $('#searchForm').attr('action','{{ route("search.package") }}');
                            var length=( Object.keys(data.success).length);
                            var images=data.images;

                            if(length>2){
                                jQuery('#searchData').append('<li class="font-weight-bold text-dark" data-slug="'+data.success[0]['slug']+'">'+'<img src="'+images[0]+'" height="60px" width="60px" style="margin-right:20px;">'+data.success[0]['title']+'</li>');
                                jQuery('#searchData').append('<li class="font-weight-bold text-white text-center" style="background:#00AF87;">'+'View More'+'</li>');
                            }else if(length==1){
                                jQuery('#searchData').append('<li class="font-weight-bold text-dark" data-slug="'+data.success[0]['slug']+'">'+'<img src="'+images[0]+'" height="60px" width="60px" style="margin-right:20px;">'+data.success[0]['title']+'</li>');
                            }
                        }else if(data.error){
                            // jQuery('#searchData').append('<p class="text-danger text-center py-2">'+data.error+'</p>');
                            $('#searchForm').attr('action','{{ route("packages") }}');
                        }
                    }
                })
            }else{
                    $('#searchData').fadeIn();
                    $('#searchData').html("");
            }
        });
        $(document).on('click','.autocom-box li',function(){
            var name=$(this).attr('data-slug');
            // var name=slugify($(this).text());
            if($(this).text()=='View More'){
                $('#searchForm').submit();
                exit();
            }
            // $('#destination').val($(this).text());
            // $('#searchData').fadeOut();
            // $('#searchData').empty();
            window.location.href = "{{url('p')}}" + "/" + name;
        });
        // $(document).on('click','#destination',function(){
        //     if(document.getElementById('searchData').innerHTML === ""){
        //     $.ajax({
        //         url:"{{ url('ajaxAllDestination') }}",
        //         method:'post',
        //         data:{ _token: "{{ csrf_token() }}"},
        //         success:function(data){
        //             if(data.success){
        //                 $('#searchData').empty();
        //                 $('#searchData').fadeIn();
        //                 jQuery.each(data.success, function(key, value){
        //                     var images=value['images'].split(',');
        //                     jQuery('#searchData').append('<li class="font-weight-bold text-dark" style=>'+'<img src="'+images[0]+'" height="60px" width="60px" style="margin-right:20px;">'+value['title']+'</li>');
        //                 });
        //             }else{
        //                 $('#searchData').html("");
        //             }
        //         }
        //     });
        // }else{
        //     $('#searchData').html("");
        // }
        // });
    });
</script>


<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script>
    $('.feature-owl').owlCarousel({
        loop:true,
        margin:10,
        autoplay:true,
        autoplayTimeout:3000,
        autoplayHoverPause:true,
        responsive:{
            0:{
                items:1,
                mouseDrag: false,
                touchDrag: true
            },
            600:{
                items:@if(count($featured)==1) 1 @elseif(count($featured)==2) 2 @else 3 @endif,
                mouseDrag: false,
                touchDrag: true,
            },
            1000:{
                items:@if(count($featured)==1) 1 @elseif(count($featured)==2) 2 @else 3 @endif
            }
        },
    });

    // $('.top-owl').owlCarousel({
    //     loop:true,
    //     margin:10,
    //     autoplay:true,
    //     autoplayTimeout:3000,
    //     autoplayHoverPause:true,
    //     responsive:{
    //         0:{
    //             items:1
    //         },
    //         600:{
    //             items:@if(count($top)==1) 1 @elseif(count($top)==2) 2 @else 3 @endif
    //         },
    //         1000:{
    //             items:@if(count($top)==1) 1 @elseif(count($top)==2) 2 @else 3 @endif
    //         }
    //     },
    // });

    $('.special-offers-owl').owlCarousel({
        loop:true,
        margin:10,
        autoplay:true,
        autoplayTimeout:3000,
        autoplayHoverPause:true,
        responsive:{
            0:{
                items:1,
                mouseDrag: false,
                touchDrag: true
            },
            600:{
                items:@if(count($special_offers)==1) 1 @elseif(count($special_offers)==2) 2 @else 3 @endif,
                mouseDrag: false,
                touchDrag: true,
            },
            1000:{
                items:@if(count($special_offers)==1) 1 @elseif(count($special_offers)==2) 2 @else 3 @endif
            }
        },
    });
 </script>

@endsection
