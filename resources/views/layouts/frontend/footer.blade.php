@if (Request::is('/*'))
<footer class="ftco-footer bg-bottom ftco-no-pt" style="background-color: #faf1ed  ;">
    <div class="container">
        <div class="row mb-1">
            <div class="col-md ">
                <div class="ftco-footer-widget pt-md-5 mb-4">
                    <a class="ftco-heading-2 " href="{{ url('/') }}" > <div style="display: flex;align-items: center;user-select: none;color: black;"><i class="fas fa-dove" style="background: #35E1A1;padding: 10px;margin-right: 5px;border-radius: 50% !important;"></i><div>Mero Trip®</div></div></a>
                    <p class="py-4">Mero Trip is a saving plan service for tour packages. We let you save for your next trip.You can pay us through ESewa and Khalti.</p>
                    <ul class="ftco-footer-social list-unstyled float-md-left float-lft">
                        <li class="ftco-animate"><a href="https://www.twitter.com/tripkhata" target="_blank"><span class="fa fa-twitter"></span></a></li>
                        <li class="ftco-animate"><a href="https://www.facebook.com/tripkhata" target="_blank"><span class="fa fa-facebook"></span></a></li>
                        <li class="ftco-animate"><a href="https://www.instagram.com/tripkhata" target="_blank"><span class="fa fa-instagram"></span></a></li>
                        {{-- @if(count(config('app.languages')) > 1)
                            <div class="btn-group mb-4">
                                <button class="btn btn-sm dropdown-toggle shadow-none" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?php
                                    /* $app=strtoupper(app()->getLocale());
                                        if($app=='EN'){
                                            echo '<span class="display-5">'.'🇺🇸'.'</span>';
                                        }else {
                                            echo '<span class="display-5">'.'🇳🇵'.'</span>';
                                        }
                                    */
                                    ?>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    @foreach(config('app.languages') as $langLocale => $langName)
                                    <a class="dropdown-item" href="{{ url()->current() }}?change_language={{ $langLocale }}">{{ strtoupper($langLocale) }} ({{ $langName }})
                                        @if($langName=='English')
                                            <span class="display-5">🇺🇸</span>
                                        @else
                                            <span class="display-5">🇳🇵</span>
                                        @endif
                                    </a>
                                    @endforeach
                                </div>
                          </div>
                        @endif --}}
                    </ul>
                </div>
            </div>
                <div class="col-md  border-left">
                    <div class="ftco-footer-widget pt-md-5 mb-4 ml-md-5">
                        <h2 class="ftco-heading-2">Information</h2>
                        <ul class="list-unstyled">
                            <li><a href="{{url('/terms')}}" class=" d-block">Terms and Conditions</a></li>
                            <li><a href="{{url('/policy')}}" class=" d-block">Privacy Policy</a></li>
                            <li><a href="{{url('/faq')}}" class=" d-block">FAQ</a></li>
                            {{-- <li><a href="#" class=" d-block">Booking Conditions</a></li>
                            <li><a href="#" class=" d-block">Refund Policy</a></li> --}}
                        </ul>
                    </div>
                </div>
                <div class="col-md  border-left">
                    <div class="ftco-footer-widget pt-md-5 mb-4">
                        <h2 class="ftco-heading-2">Links</h2>
                        <ul class="list-unstyled">
                            <li><a href="{{url('/contact')}}" class="d-block">Contact</a></li>
                            <li><a href="{{url('/about')}}" class="d-block">About Us</a></li>
                            <li><a href="{{url('/packages')}}" class=" d-block">Packages</a></li>
                            <li><a href="{{url('/gallery')}}" class="d-block">Gallery</a></li>
                            {{-- <li><a href="{{url('/testimonial')}}" class="d-block">Testimonial</a></li> --}}
                        </ul>
                    </div>
                </div>
                <div class="col-md  border-left">
                    <div class="ftco-footer-widget pt-md-5 mb-4">
                        <h2 class="ftco-heading-2">Have a Questions?</h2>
                        <div class="block-23 mb-3">
                            <ul>
                                <li><i class="icon fa fa-map-marker"></i><span class="text">Shantinagar, Kathmandu <br> Nepal </span></li>
                                <li><i class="icon fa fa-phone"></i><span class="text">+977-9999999999</span></li>
                                <li><i class="icon fa fa-paper-plane"></i><span class="text">info@merotrip.com</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
        </div>
        <div class="row ftco-no-pb">
            <div class="col-md-12 text-center">
                <p class="py-4">
                    Copyright &copy;<script>document.write(new Date().getFullYear());</script> Mero Trip All Rights Reserved
                </p>
                </div>
            </div>
        </div>
    </footer>
    @else

    <footer class="ftco-footer" style="background-color: #faf1ed  ;">
    <div class="container">
    <div class="row ">
    <div class="col-md ">
    <div class="ftco-footer-widget pt-md-3 ">
        <a class="ftco-heading-2 " href="{{ url('/') }}" > <div style="display: flex;align-items: center;user-select: none;color: black;"><i class="fas fa-dove" style="background: #35E1A1;padding: 10px;margin-right: 5px;border-radius: 50% !important;"></i><div>Tripkhata®</div></div></a>
        <p class="py-3"> Copyright &copy;<script>document.write(new Date().getFullYear());</script> Mero Trip All Rights Reserved</p>
        <div class="footer-links py-1">
            <a href="{{url('/terms')}}">Terms and Conditions</a>
            <a href="{{url('/policy')}}">Privacy Policy</a>
            {{-- <a href="">Refund Policy</a>
            <a href="">Booking Conditions</a> --}}
            <a href="{{url('/faq')}}">FAQ</a>
        </div>

        <p class="py-3">Mero Trip is a saving plan service for tour packages. We let you save for your next trip.You can pay us through ESewa and Khalti.</p>
        <ul class="ftco-footer-social list-unstyled float-md-left float-lft">
            <li class="ftco-animate"><a href="https://www.twitter.com/tripkhata" target="_blank"><span class="fa fa-twitter"></span></a></li>
            <li class="ftco-animate"><a href="https://www.facebook.com/tripkhata" target="_blank"><span class="fa fa-facebook"></span></a></li>
            <li class="ftco-animate"><a href="https://www.instagram.com/tripkhata" target="_blank"><span class="fa fa-instagram"></span></a></li>
            {{-- @if(count(config('app.languages')) > 1)
                <div class="btn-group mb-4">
                    <button class="btn btn-sm dropdown-toggle shadow-none" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php /* $app=strtoupper(app()->getLocale());
                            if($app=='EN'){
                                echo '<span class="display-5">'.'🇺🇸'.'</span>';
                            }else {
                                echo '<span class="display-5">'.'🇳🇵'.'</span>';
                            }
                        */
                        ?>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        @foreach(config('app.languages') as $langLocale => $langName)
                        <a class="dropdown-item" href="{{ url()->current() }}?change_language={{ $langLocale }}">{{ strtoupper($langLocale) }} ({{ $langName }})
                            @if($langName=='English')
                                <span class="display-5">🇺🇸</span>
                            @else
                                <span class="display-5">🇳🇵</span>
                            @endif
                        </a>
                        @endforeach
                    </div>
                </div>
            @endif --}}
        </ul>
    </div>
    </div>
    </div>
    </div>
    </footer>
    @endif

    <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#00AF87"/></svg></div>
