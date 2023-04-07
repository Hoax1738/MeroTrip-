@extends('layouts.app')
@section('content')
<section class="ftco-section ftco-degree-bg mt-3">
    <div class="container">
        <div class="row">
        <?php /*
            <div class="col-lg-3 sidebar ftco-animate fadeInUp ftco-animated">
                <div class="sidebar-wrap bg-light ftco-animate fadeInUp ftco-animated">
                    <div class="accordion" id="accordionExample">
                        <div class="spaced-between d-flex justify-content-between py-2">
                            <h3 class="heading mb-2" aria-controls="collapseOne">Find City
                            </h3>
                            <i id="filter-toggler" class="icon-remove" data-toggle="collapse" data-target="#filtercollapse"></i>
                        </div>
                        <div id="filtercollapse" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                            <form action="#">
                                <div class="fields">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Destination, City">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" id="checkin_date" class="form-control" placeholder="Date from">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" id="checkin_date" class="form-control" placeholder="Date to">
                                    </div>
                                    <div class="form-group">
                                        <div class="range-slider">
                                            <span>
                                                <input type="number" value="25000" min="0" max="120000"> -
                                                <input type="number" value="50000" min="0" max="120000">
                                            </span>
                                            <input value="1000" min="0" max="120000" step="500" type="range">
                                            <input value="50000" min="0" max="120000" step="500" type="range">

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" value="Search" class="btn btn-primary py-3 px-5">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            */ ?>
            <div class="col-lg-12">
                <div class="row">
                    @forelse ($items as $package)
                        <div class="col-md-4 ftco-animate fadeInUp ftco-animated">
                            <div class="destination">
                                <a href="{{route('singlePackage',['slug'=>$package['slug']])}}" class="img img-2 d-flex justify-content-center align-items-center" style="background-image: url({{$package['images']}});">
                                    <div class="icon d-flex justify-content-center align-items-center">
                                        <span class="icon-search2"></span>
                                    </div>
                                </a>
                                <div class="text p-3">
                                    <div class="d-flex">
                                        <div class="one">
                                            <h3><a href="{{route('singlePackage',['slug'=>$package['slug']])}}">{{$package['title']}}</a></h3>
                                        </div>
                                    </div>
                                    <p>{{$package['description']}}</p>
                                    <p class="days"><span>{{$package['duration']}} days</span></p>
                                    <hr>
                                    <p class="bottom-area d-flex">
                                        <span><i class="icon-map-o"></i> {{$package['destination']}}</span>
                                        <span class="ml-auto"><a href="{{route('singlePackage',['slug'=>$package['slug']])}}">Discover</a></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>No Packages Found</p>
                    @endforelse
                </div>
            </div> <!-- .col-md-8 -->
        </div>
    </div>
</section>
@endsection
