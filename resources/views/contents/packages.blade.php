@extends('layouts.frontend.app')
@section('slider')
    <link rel="stylesheet" href="{{ url('/priceslider/slider.css') }}">
@endsection
@section('title') {{ __('List of Packages - Tripkhata®') }} @endsection
@section('content')
{{-- @include('layouts.frontend.breadcrumb') --}}
<section class="content">
    <section class="ftco-section">
        <div class="container">

            @if (Auth::check())
            @include('contents.emiAlert')
            @else
            @endif

            <div class="row justify-content-center pb-4">
                <div class="col-md-12 heading-section text-center ftco-animate">
                    <h2 class="mb-4">{{ucfirst($tag)}} Trips</h2>
                </div>
            </div>

            <div class="container mb-5 px-5 py-5 bg-light">
                <form action="{{ route('search.package') }}" method="POST">
                    @csrf
                    <div class="row">
                    <div class="col-md-3">
                         <label for="title">{{ __('Trip') }} {{ __('Destination') }}</label>
                         <div class="ui-widget">
                            <input id="title" class="form-control" name="title">
                          </div>
                    </div>

                    <div class="col-md-3">
                        <label for="trip_date">{{ __('Trip') }} {{ __('Date') }}</label>
                        <input type="month" class="form-control" name="trip_Date">
                    </div>

                    <div class="col-md-4">
                        <label for="inputEmail4">{{ __('Price') }} {{ __('Filter') }}</label>
                        <div id="slider-range" class="price-filter-range" name="rangeInput"></div>
                        <div style="margin-bottom:10px">
                            <input type="number" name="min" min="{{ $min }}" max="{{ $max-100 }}"  id="min_price" class="price-range-field" readonly/>
                            <input type="number" name="max" min="{{ $min }}" max="{{ $max }}"  id="max_price" class="price-range-field" readonly/>
                        </div>
                    </div>

                    <input type="hidden" name="tags" value="{{$tag}}"/>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary form-control mt-4">{{ __('Search') }}</button>
                    </div>

                    </div>
                </form>
            </div>

            @if(count($items)>0)
                <div class="row">
                    @foreach($items as $package)
                        <div class="col-md-4 ftco-animate">
                            <div class="project-wrap">
                                <a href="{{route('singlePackage',['slug'=>$package['slug']])}}" class="img">
                                    <?php $images=explode(",",$package['images']);
                                          $image_table=\App\Image::find($images[0]);
                                    ?>
                                    @if($image_table!=NULL)
                                        @if($image_table->drive_id==NULL)
                                            <img class="img" src="{{url("$image_table->directory/$image_table->local_filename")}}" alt="">
                                        @else 
                                            <img class="img" src="https://drive.google.com/uc?export=view&id={{$image_table->drive_id}}" alt="">
                                        @endif   
                                    @endif
                                    <span class="price">{{($package['duration'])}} {{ __('Days') }}</span>
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
                                    <h3><a href="{{route('singlePackage',['slug'=>$package['slug']])}}">{{__($package['title'])}}</a></h3>
                                    {{-- <ul>
                                        <li><span class="flaticon-shower"></span>2</li>
                                        <li><span class="flaticon-king-size"></span>3</li>
                                        <li><span class="flaticon-mountains"></span>Near Mountain</li>
                                    </ul> --}}
                                    <span class="destination"> <i class="fa fa-map-marker"></i> {{__($package['destination'])}}</span>
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
                    @endforeach
                </div>
             @else
                <div class="row"><div class="col-lg-12"><h5 class="d-flex justify-content-center text-danger">* {{ __('No Records Found') }}</h5></div><div>
             @endif
            {{-- <div class="d-flex justify-content-center">
                <div>
                {{$items->links()}}
                </div>
            </div> --}}
        </div>
    </section>
</section>

<script>
    $( function() {
        var ars= <?php echo json_encode($package_name); ?>;
        $("#title").autocomplete({
            source: ars,
            minLength: 0
        }).bind('focus', function () {
            $(this).autocomplete("search");
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
            var max_value='<?php echo $max;?>';
            var min_value='<?php echo $min;?>';
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

            $('#slider-range').draggable();
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






