@extends('layouts.frontend.app')
@section('slider')
    <link rel="stylesheet" href="{{ url('/priceslider/slider.css') }}">
@endsection
<?php
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$tag_name =basename($actual_link);
?>
@section('title') {{ucfirst($tag_name)}} Trips @endsection
@section('content')
{{-- @include('layouts.frontend.breadcrumb') --}}
<section class="content">
    <section class="ftco-section">
        <div class="container">
            @if (Auth::check())
                @include('contents.emiAlert')
                @else
            @endif
            @if(session('success_message'))
            <div class="alert alert-success alert-dismissible justify-content-center">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>{{session('success_message')}}</strong>
            </div>
            @endif
            <div class="row justify-content-center pb-4">
                <div class="col-md-12 heading-section text-center ftco-animate">
                    <h2 class="mb-4  text-capitalize">{{$tag_name}} Trips</h2>
                </div>
            </div>

            @if(count($items)>0)
                <div class="container mb-5 px-5 py-5 bg-light">
                    <form action="{{ route('search.package') }}" method="POST">
                        @csrf
                        <div class="row">
                        <div class="col-md-3">
                            <label for="title">Trip Destination</label>
                            <input id="title" type="text" class="form-control" name="title">
                        </div>

                        <div class="col-md-3">
                            <label for="trip_date">Trip Date</label>
                            <input type="month" class="form-control" name="trip_Date">
                        </div>

                        <div class="col-md-4">
                            <label for="inputEmail4">Price Filter</label>
                            <div id="slider-range" class="price-filter-range" name="rangeInput"></div>
                            <div style="margin-bottom:10px">
                                <input type="number" name="min" min="{{ $min }}" max="{{ $max-100 }}"  id="min_price" class="price-range-field" readonly/>
                                <input type="number" name="max" min="{{ $min }}" max="{{ $max }}"  id="max_price" class="price-range-field" readonly/>
                            </div>
                        </div>

                        <input type="hidden" name="tags" value="{{$tag}}"/>

                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary form-control mt-4">Search</button>
                        </div>

                        </div>
                    </form>
                </div>
             @endif   

            <div class="row">
                @forelse($items as $package)
                    <div class="col-md-4 ftco-animate">
                        <div class="project-wrap">
                            <a href="{{route('singlePackage',['slug'=>$package['slug']])}}" class="img" style="background-image: url($package['images']);">
                                <?php $images=explode(",",$package['images']);
                                       $img_info=\App\Image::find($images[0]); 
                                ?>
                                @if($img_info!=NULL)
                                    <img class="img" @if($img_info->drive_id==NULL) src="{{url("$img_info->directory/$img_info->local_filename")}}" @else src="https://drive.google.com/uc?export=view&id={{$img_info->drive_id}}" @endif alt="">
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
            {{-- <div class="row mt-5">
                <div class="col d-flex justify-content-end">
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






