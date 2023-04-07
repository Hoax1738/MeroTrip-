@extends('layouts.frontend.app')
@section('slider')
    <link rel="stylesheet" href="{{ url('/priceslider/price.css') }}">
@endsection

@section('content')
{{-- <div class="hero-wrap js-fullheight" style="background-image: url('/images/bg_5.jpg');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center" data-scrollax-parent="true">
            <div class="col-md-7 ftco-animate">
                <span class="subheading">Welcome to Tripkhata</span>
                <h1 class="mb-4">Update Your Khata Every Month</h1>
                <p class="caps">Travel to your dream destination by planning it ahead</p>
            </div>
            <a href="https://vimeo.com/45830194" class="icon-video popup-vimeo d-flex align-items-center justify-content-center mb-4">
                <span class="fa fa-play"></span>
            </a>
        </div>
    </div>
</div> --}}

<section class="ftco-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="ftco-search">
                    <div class="row">
                        <div class="col-md-12 nav-link-wrap">
                            <div class="nav nav-pills text-center" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-link active mr-md-1" id="v-pills-1-tab" data-toggle="pill" href="#v-pills-1" role="tab" aria-controls="v-pills-1" aria-selected="true">Search Tour</a>
                            </div>
                        </div>
                        <div class="col-md-12 tab-wrap">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="v-pills-1" role="tabpanel" aria-labelledby="v-pills-nextgen-tab">
                                    <form action="{{ route('search.package') }}" class="search-property-1" method="POST">
                                        @csrf
                                        <div class="row no-gutters">
                                            <div class="col-md-3 d-flex">
                                                <div class="form-group p-4 border-0">
                                                    <label for="destination">Destination</label>
                                                    <div class="form-field">
                                                        <div class="icon"><span class="fa fa-search"></span></div>
                                                        <input type="text" id="destination" name="title" class="form-control" placeholder="Search place" autocomplete="off">
                                                    </div>
                                                    <div id="searchData"></div>
                                                </div>
                                            </div>



                                            <div class="col-md-3 d-flex">
                                                <div class="form-group p-4">
                                                    <label for="check_in_date">Trip Date</label>
                                                    <div class="form-field">
                                                        <div class="icon"><span class="fa fa-calendar"></span></div>
                                                        <input type="month" id="check_in_date" class="form-control" name="trip_date" placeholder="Check In Date" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4 d-flex">
                                                <div class="form-group p-4">
                                                    <label for="price">Price Limit</label>
                                                    <div class="form-field">

                                                        <div>
                                                            <div id="slider-range" class="price-filter-range" name="rangeInput"></div>
                                                            <div style="margin-bottom:10px">
                                                              <input type="number" name="min" min="{{ $min }}" max="{{ $max-100 }}"  id="min_price" class="price-range-field"  />
                                                              <input type="number" name="max" min="{{ $min }}" max="{{ $max }}"  id="max_price" class="price-range-field"  />
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>



                                            <div class="col-md d-flex">
                                                <div class="form-group d-flex w-100 border-0">
                                                    <div class="form-field w-100 align-items-center d-flex">
                                                        <input type="submit" value="Search" class="align-self-stretch form-control btn btn-primary">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>








@if(count($featured)>0)
    <section id="featured" class="ftco-section">
        <div class="container">
            <div class="row justify-content-center pb-4">
                <div class="col-md-12 heading-section text-center ftco-animate">
                    <span class="subheading">Destination</span>
                    <h2 class="mb-4">Featured Trip</h2>
                </div>
            </div>
            <div class="row">
                @foreach($featured as $ft)

                <div class="col-md-4 ftco-animate">
                    <div class="project-wrap">
                        <a href="{{route('singlePackage',['slug'=>$ft['slug']])}}" class="img" style="background-image: url($ft['images']);">
                            <?php
                                $images=explode(',',$ft['images']);
                            ?>
                            <img class="img" src="{{ $images[0] }}" alt="featured-trip">
                            <span class="price">{{$ft['duration']}} Days</span>
                        </a>
                        <div class="text p-4">
                            <h3><a href="{{route('singlePackage',['slug'=>$ft['slug']])}}"> {{$ft['title']}}</a></h3>
                            <p class="location"><span class="fa fa-map-marker"></span> {{$ft['destination']}}</p>
                            <ul>
                                <li>{{$ft['tags']}}<li>
                                <li>Save</li><i class="far fa-heart"></i>

                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach


            </div>
        </div>
    </section>
    @endif






@if(count($special_offers)>0)
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center pb-4">
                <div class="col-md-12 heading-section text-center ftco-animate">
                    <span class="subheading">Special Offers Destination</span>
                    <h2 class="mb-4">Special Offers Destination</h2>
                </div>
            </div>
            <div class="row">
                @foreach($special_offers as $package)

                <div class="col-md-4 ftco-animate">
                    <div class="project-wrap">
                        <a href="{{route('singlePackage',['slug'=>$package['slug']])}}" class="img" style="background-image: url($package['images']);">
                            <?php
                               $special_offer_img=explode(',',$package['images']);?>
                            <img class="img" src="{{ $special_offer_img[0] }}" alt="">
                            <span class="price">{{$package['duration']}} Days</span>
                        </a>
                        <div class="text p-4">
                            <h3><a href="{{route('singlePackage',['slug'=>$package['slug']])}}"> {{$package['title']}}</a></h3>
                            <p class="location"><span class="fa fa-map-marker"></span> {{$package['destination']}}</p>
                            <ul>
                                <li>{{$package['tags']}}<li>
                                    <li>Save</li><i class="far fa-heart"></i>
                                </ul>

                        </div>
                    </div>
                </div>
                @endforeach


            </div>
        </div>
    </section>
    @endif




@if(count($top)>0)
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center pb-4">
                <div class="col-md-12 heading-section text-center ftco-animate">
                    <span class="subheading">Top Tour Packages
                    </span>
                    <h2 class="mb-4">Top Tour Packages
                    </h2>
                </div>
            </div>
            <div class="row d-flex">
                @foreach ($top as $package)
                    <div class="col-md-4 ftco-animate">
                        <div class="project-wrap">
                            <a href="{{route('singlePackage',['slug'=>$package['slug']])}}" class="img" style="background-image: url($package['images']);">
                                <?php
                                $special_offer_img=explode(',',$package['images']);?>
                                <img class="img" src="{{ $special_offer_img[0] }}" alt="">
                                <span class="price">{{$package['duration']}} Days</span>
                            </a>
                            <div class="text p-4">
                                <h3><a href="{{route('singlePackage',['slug'=>$package['slug']])}}"> {{$package['title']}}</a></h3>
                                <p class="location"><span class="fa fa-map-marker"></span> {{$package['destination']}}</p>
                                <ul>
                                    <li>{{$package['tags']}}<li>
                                        <li>Save</li><i class="far fa-heart"></i>
                                    </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif



    <section class="ftco-intro ftco-section ftco-no-pt">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 text-center">
                    <div class="img"  style="background-image: url(images/bg_2.jpg);">
                        <div class="overlay"></div>
                        <h2>We Are Tripkhata</h2>
                        <p>We can manage your  travelling dream come true.</p>
                        <p class="mb-0"><a href="{{url('/contact')}}" class="btn btn-primary px-4 py-3">Contact Us</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
<!--================ Featured Area  =================-->


<!--================ Top Packages Area  =================-->

<script>

    $(document).ready(function(){
        $('#destination').keyup(function(){
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
                        $('#searchData').fadeIn();
                        $('#searchData').html(data);
                    }
                })
            }else{
                    $('#searchData').fadeIn();
                    $('#searchData').html("");
            }

        });

        $(document).on('click','li',function(){
            if($(this).text()=='No Records Found'){
                $('#destination').val("");
                $('#searchData').fadeOut();
            }else{
                $('#destination').val($(this).text());
                $('#searchData').fadeOut();
            }

        });

        $(document).on('click','#destination',function(){
            $.ajax({
                url:"{{ url('ajaxAllDestination') }}",
                method:'post',
                data:{ _token: "{{ csrf_token() }}"},
                success:function(data){
                    $('#searchData').fadeIn();
                    $('#searchData').html(data);
                }
            })
        });


    });
</script>

<script>

    $(document).ready(function(){
    $("#min_price,#max_price").on('change', function () {

    var min_price_range = parseInt($("#min_price").val());

    var max_price_range = parseInt($("#max_price").val());

    if (min_price_range > max_price_range) {
        $('#max_price').val(min_price_range);
    }

    $("#slider-range").slider({
        values: [min_price_range, max_price_range]
    });

    });


    $("#min_price,#max_price").on("paste keyup", function () {
    var min_price_range = parseInt($("#min_price").val());

    var max_price_range = parseInt($("#max_price").val());

    if(min_price_range == max_price_range){

            // max_price_range = min_price_range+100;

            // $("#min_price").val(min_price_range);
            // $("#max_price").val(max_price_range);

            min_price_range='<?php echo $min;?>';

            max_price_range='<?php echo $max;?>';

             $("#min_price").val(min_price_range);
             $("#max_price").val(max_price_range);
    }



    $("#slider-range").slider({
        values: [min_price_range, max_price_range]
    });

    });


    $(function () {
    $("#slider-range").slider({
        range: true,
        orientation: "horizontal",
        min: <?php echo $min;?>,
        max: <?php echo $max;?>,
        values: [<?php echo $min;?>, <?php echo $max;?>],
        step:100,

        slide: function (event, ui) {
        if (ui.values[0] == ui.values[1]) {
            return false;
        }

        $("#min_price").val(ui.values[0]);
        $("#max_price").val(ui.values[1]);
        }
    });

    $("#min_price").val($("#slider-range").slider("values", 0));
    $("#max_price").val($("#slider-range").slider("values", 1));

    });

    $("#slider-range").click(function () {

    var min_price = $('#min_price').val();
    var max_price = $('#max_price').val();
    });

    });

</script>



@endsection
