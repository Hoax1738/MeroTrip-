@extends('layouts.frontend.app')
@section('title') About Us @endsection
@section('content')
<section class="content">
    <section class="ftco-section services-section">
        <div class="container">
            @if (Auth::check())
            @include('contents.emiAlert')
            @else
            @endif
            <div class="row d-flex">
                <div class="col-md-6 order-md-last heading-section pl-md-5 ftco-animate d-flex align-items-center">
                    <div class="w-100">
                        <h3 class="mb-4">Pay in EMI, Travel wherever you want</h3>
                        <p class="text-justify about-p">We make your dream vacation come true with trip khata. We understand that it is difficult to manage a large sum of money to travel. With trip khata you can plan your travel ahead of time and pay monthly installments to reach your goal.<br>
                         The process is very simple. You choose your favourite package with dates that you prefer. Then, we will plan your savings accordingly. We let you pay for your packages in terms of monthly payment. </p>
                        <p><a href="{{url('/packages')}}" class="btn btn-primary mt-3 py-2 px-4 mb-4">View Destination</a></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12 col-lg-6 d-flex align-self-stretch ftco-animate">
                            <div class="services services-1 color-2 d-block img" style="background-image: url(images/saving.jpg);">
                                <div class="icon d-flex align-items-center justify-content-center"><i class="fas fa-hand-holding-usd fa-3x text-light"></i></div>
                                <div class="media-body">
                                    <h3 class="heading  mb-3" >Small Saving Great Results</h3>
                                    <!--<p>A small river named Duden flows by their place and supplies it with the necessary</p>-->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6 d-flex align-self-stretch ftco-animate">
                            <div class="services services-1 color-2 d-block img" style="background-image: url(images/services-2.jpg);">
                                <div class="icon d-flex align-items-center justify-content-center"><i class="fas fa-route fa-3x text-light"></i></div>
                                <div class="media-body">
                                    <h3 class="heading mb-3">Save At your own pace</h3>
                                    <!--<p>A small river named Duden flows by their place and supplies it with the necessary</p>-->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6 d-flex align-self-stretch ftco-animate">
                            <div class="services services-1 color-2 d-block img" style="background-image: url(images/af.jpg);">
                                <div class="icon d-flex align-items-center justify-content-center"><i class="fas fa-wallet fa-3x text-light"></i></i></div>
                                <div class="media-body">
                                    <h3 class="heading mb-3">Make every trip Affordable</h3>
                                    <!--<p>A small river named Duden flows by their place and supplies it with the necessary</p>-->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6 d-flex align-self-stretch ftco-animate">
                            <div class="services services-1 color-2 d-block img" style="background-image: url(images/commit.jpg);">
                                <div class="icon d-flex align-items-center justify-content-center"><i class="fas fa-check fa-3x text-light"></i></div>
                                <div class="media-body">
                                    <h3 class="heading mb-3">Complete your commitments</h3>
                                    <!--<p>A small river named Duden flows by their place and supplies it with the necessary</p>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- <section class="ftco-section ftco-about img"style="background-image: url(images/mountain.jpeg);">
        <div class="overlay"></div>
        <div class="container py-md-5">
            <div class="row py-md-5">
                <div class="col-md d-flex align-items-center justify-content-center">
                    <a href="https://vimeo.com/45830194" class="icon-video popup-vimeo d-flex align-items-center justify-content-center mb-4">
                        <span class="fa fa-play"></span>
                    </a>
                </div>
            </div>
        </div>
    </section> --}}
    <section id="aboutus" class="ftco-section ftco-about ftco-no-pt img">
        <div class="container">
            <div class="row d-flex">
                <div class="col-md-12 about-intro">
                    <div class="row">
                        {{-- <div class="col-md-6 d-flex align-items-stretch ">
                            <div class="img d-flex w-100 align-items-center justify-content-center mt-2" style="background-image:url(images/valley.jpeg);">
                            </div>
                        </div> --}}
                        <div class="col-md-12 pl-md-5 py-5">
                            <div class="row justify-content-start pb-3">
                                <div class="col-md-12 heading-section ftco-animate">
                                    <h3 class="mb-4">Make your tour from dream to Reality with us.</h3>
                                    <p class="text-justify about-p">We at Tripkhata are committed to make people around the world make the tour they have always wanted. We provide EMI plans for travel packages. When you commit to packages we make sure you complete it.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>


@endsection
