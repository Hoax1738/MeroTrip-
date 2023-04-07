<section class="ftco-intro ftco-section  py-5" @if (Request::is('p/*')) style="background:#f2f2f2" @endif>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 text-center">
                <div class="img"  style="background-image:  url({{asset('images/bg_2.jpg')}});">
                    <div class="overlay"></div>
                    <h2>{{ __('Refer Your Friends') }}</h2>
                    <p class="py-3">{{ __('Invite your friends and travel for free') }}</p>
                    <p class="mb-0">
                        @guest
                        <a href="{{route('register')}}" class="btn btn-primary px-4 py-2"> {{ __('Register') }}</a>
                        @else
                        <a href="{{url('/refer')}}" class="btn btn-primary px-4 py-2"> {{ __('Invite Friends') }}</a>
                        @endguest
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
