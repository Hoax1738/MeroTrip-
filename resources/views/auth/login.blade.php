<!doctype html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ __('Login').' - Tripkhata®' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('icons/tab-icon.png') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{asset('css/frontcss/style.css')}}">
    <link href="{{ url('/signup/form-validation.css') }}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        body {
            background-color: #f5f5f5;
        }
         a {
            color:#00AF87;
            text-decoration: underline;
        }
    </style>
            @include('contents.gtag')

    </head>
    <body>
        @include('layouts.frontend.navbar')
        <section class="login-form">
            <section class="content">
                <section class="ftco-section">
                    <div class="row justify-content-center">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="py-5 text-center">
                                        <a class="navbar-brand" href="{{ url('/') }}"><div style="display: flex;align-items: center;user-select: none;color: black;"><i class="fas fa-dove" style="background: #35E1A1;padding: 10px;margin-right: 5px;border-radius: 50% !important;"></i><div>Tripkhata®</div></div></a>
                                    </div>
                                    <div class="bg-white mt-2 px-3 ">
                                        @if ($errors->has('email'))
                                            <div class="alert alert-danger" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </div>
                                        @endif

                                        @if ($errors->has('password'))
                                            <div class="alert alert-danger" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </div>
                                        @endif

                                        <form method="POST" action="{{ route('login') }}"> @csrf
                                            <div class="row text-center  justify-content-center">
                                                <div class="row-6">
                                                    <div class="input-group has-validation">
                                                        <span class="input-group-text"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                                                        <input id="email" type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" placeholder="{{ __('Email Address') }}" value="{{ old('email') }}"  autofocus>
                                                    </div>
                                                </div>
                                                <div class="row-6 mt-2">
                                                    <div class="input-group has-validation">
                                                        <span class="input-group-text"><i class="fa fa-key" aria-hidden="true"></i></span>
                                                        <input id="pwd" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{ __('Password') }}">
                                                        <span class="input-group-text"><i class="fa fa-eye-slash" aria-hidden="true" onclick="myFunction(this)"></i></span>
                                                    </div>
                                                </div>
                                                <div class="checkbox mt-3">
                                                    <label>
                                                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                                                    </label>
                                                </div>
                                                @if (Route::has('password.request'))
                                                    <a class="btn btn-link " href="{{ route('password.request') }}">
                                                    {{ __('Forgot Your Password?') }}
                                                    </a>
                                                @endif
                                                <button class="w-100 btn btn-lg btn-primary m-2" type="submit">{{ __('Log In')}}</button>
                                                <span>or</span>
                                                <a href="{{ route('register') }}" type="submit"> {{ __('Click Here To Register') }} </a>
                                            </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </section>
        </section>

        <script>
            function myFunction(a) {
                var x=document.getElementById('pwd');
                if(x.type==="password"){
                    x.type="text";
                    a.classList.remove("fa-eye-slash");
                    a.classList.toggle("fa-eye");

                }else if(x.type==="text"){
                    x.type="password";
                    a.classList.remove("fa-eye");
                    a.classList.toggle("fa-eye-slash");
                }
            }
        </script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>
