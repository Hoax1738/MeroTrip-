@extends('layouts.app')
@section('content')
<div class="book-package" id="stick-bookbtn" style="background: #f9f9f9;">
    <div class="container">
        <div class="row px-3 py-lg-2 d-flex align-items-center">
            <div class="col-md-4 col-10">
                <h5>{{$item['title']}}</h5>
            </div>
            <div class="col-md-4 offset-md-4 col-2 d-flex justify-content-end">
                <div class="form-group">
                    <a href="book.html" class="btn btn-primary mt-2 px-5 hide-on-sm" data-toggle="modal" data-target="#BookModal">Book</a>
                    <a href="book.html" class="btn btn-primary mt-2 px-3 hide-on-sm-above" data-toggle="modal" data-target="#BookModal">Book</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="BookModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"aria-hidden="true">
    <div class="modal-dialog modal-custom" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Choose a Package</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">

                @foreach($item['commence_dates'] as $commence_date)
                    <div class="col-md-3">
                        <div class="card mb-4 text-center box-shadow" id="single-package-type">
                            <div class="card-header">
                                <h4 class="my-0 font-weight-normal">{{$commence_date['commence_date']}}</h4>
                            </div>
                            <div class="card-body">
                                <h1 class="card-title pricing-card-title">{{$commence_date['price']}}<small class="text-muted"> NPR</small></h1>
                                <ul class="list-unstyled mt-3 mb-4">
                                    <li>Date: {{$commence_date['commence_date']}}</li>
                                    <li>Price: NPR {{$commence_date['price']}}</li>
                                    <li>Maximum for the date: {{$commence_date['max_per_commence']}}</li>
                                    <li>Available Slots: {{$commence_date['available_slots']}}</li>
                                </ul>
                                @if($commence_date['available_slots']>0)
                                <form method="post" action="{{route('calculateEMI',['trip' => $item['slug'], 'date'=>$commence_date['commence_date']])}}">@csrf<input type="hidden" name="clickref" value="{{$commence_date['id']}}"/><input type="submit" class="btn btn-lg btn-block btn-outline-success" value="Book for this date"/></form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<section class="ftco-section ftco-degree-bg">
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-10 offset-md-1 col-12">
                <div class="row">
                    <div class="col-md-12 hotel-single mt-4 mb-5 ftco-animate">
                        <span><?php foreach(explode(",",$item['tags']) as $tag){echo "#".$tag." ";}?></span>
                        <h1>{{$item['title']}}</h1>
                        <div class="description">{{$item['description']}}</div>
                    </div>
                    <div class="col-md-12 ftco-animate">
                        <div class="single-slider owl-carousel">
                            <?php
                                $exp = explode(",",$item['images']);
                                foreach($exp as $img){
                            ?>
                            <div class="item">
                                <div class="hotel-img" style="background-image: url({{$img}});"></div>
                            </div>
                                <?php }?>
                        </div>
                    </div>
                    <?php
                    $inc = array_merge(explode(",",$item['inclusions']),explode(",",$item['highlights']),explode(",",$item['travel_option']));
                    foreach($inc as $in){
                        $ico = strtolower(str_replace(" ","-",$in)).".png";
                        if(file_exists('icons/'.$ico)){
                        ?>
                        <img src="{{url('icons/'.$ico)}}" style="height:20px; width:20px; margin:0px 5px 0px 20px;"/> {{$in}}
                        <?php
                        }
                    }
                    ?>
                    <div class="col-md-12 hotel-single ftco-animate mb-5 mt-4">
                        <h4 class="mb-4">Itienary</h4>
                        <div class="row px-3">
                            <div class="container container-sm-none">
                                <div class="accordion md-accordion accordion-1" id="accordionEx23" role="tablist">
                                <?php $show = true; ?>
                                @foreach($item['itinerary'] as $day)
                                    <?php $itiid = rand(0,time());?>
                                    <div class="card">
                                        <div class="card-header blue lighten-3 z-depth-1" role="tab" id="heading96">
                                            <h5 class="text-uppercase mb-0 py-1">
                                                <a class="white-text font-weight-bold" data-toggle="collapse" href="#collapse{{$itiid}}" aria-expanded="true" aria-controls="collapse{{$itiid}}">
                                                    Day {{$day['day']}}: {{$day['title']}}
                                                </a>
                                            </h5>
                                        </div>

                                        <div id="collapse{{$itiid}}" class="collapse<?php if($show) echo $show; $show = false;?>" role="tabpanel"
                                            aria-labelledby="heading96" data-parent="#accordionEx23">
                                            <div class="card-body">
                                                <div class="row my-4">
                                                    <div class="col-md-8">
                                                        {{$day['description']}}
                                                    </div>
                                                    <div class="col-md-4 mt-3 pt-2">
                                                        <div class="view z-depth-1">
                                                            <div class="single-slider owl-carousel">
                                                            <?php
                                                            $endofday = explode(':',$day['end_of_day']);
                                                            if($endofday[0]=="hotel"){
                                                                ?>
                                                                <div class="item">
                                                                    <img src="{{$item['hotels'][$endofday[1]][0]['images']}}">
                                                                </div>
                                                                <?php
                                                            }
                                                            ?>
                                                                <div class="item">
                                                                    <img src="{{$day['images']}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(count($related)>0)
                    <div class="col-md-12 hotel-single ftco-animate mb-5 mt-5">
                        <h4 class="mb-4">Related Packages</h4>
                        <div class="row">
                            @foreach($related as $package)
                            <div class="col-md-4">
                                <div class="destination">
                                    <a href="{{route('singlePackage',['slug'=>$package['slug']])}}" class="img img-2" style="background-image: url({{$package['images']}});"></a>
                                    <div class="text p-3">
                                        <div class="d-flex">
                                            <div class="one">
                                                <h3><a href="{{route('singlePackage',['slug'=>$package['slug']])}}">{{$package['title']}}</a></h3>
                                            </div>
                                        </div>
                                        <p>{{$package['description']}}</p>
                                        <hr>
                                        <p class="bottom-area d-flex">
                                            <span><i class="icon-map-o"></i> {{$package['destination']}}</span>
                                            <span class="ml-auto"><a href="{{route('singlePackage',['slug'=>$package['slug']])}}">Discover</a></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div> <!-- .col-md-8 -->
        </div>
    </div>
</section> <!-- .section -->
@endsection
