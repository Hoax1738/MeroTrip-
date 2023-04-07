<!doctype html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ __('Register') }} {{ __('- Tripkhata®') }}</title>
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
    </style>
    @include('contents.gtag')
    </head>
    <body>
        @include('layouts.frontend.navbar')
        <section class="register ">
            <section class="content">
                <section class="ftco-section">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="bg-white mt-2 px-3">
                                        <div class="py-5 text-center">
                                            <a class="navbar-brand" href="{{ url('/') }}"><div style="display: flex;align-items: center;user-select: none;color: black;"><i class="fas fa-dove" style="background: #35E1A1;padding: 10px;margin-right: 5px;border-radius: 50% !important;"></i><div>Tripkhata®</div></div></a>
                                        </div>
                                        <form method="POST" action="{{ route('register') }}">
                                            @csrf
                                            <div class="row  justify-content-center">
                                                <div class="row-6 m-3">
                                                    <div class="input-group has-validation">
                                                        <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
                                                        <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" name="name" value="{{ old('name') }}"  required placeholder="{{__('Name')}}" >
                                                        <div class="invalid-feedback">
                                                            @if ($errors->has('name'))
                                                                <strong>{{ $errors->first('name') }}</strong>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row-6 m-3">
                                                    <div class="input-group has-validation">
                                                        <span class="input-group-text"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                                                        <input type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required placeholder="{{ __('Email') }}">
                                                        <div class="invalid-feedback">
                                                            @if ($errors->has('email'))
                                                                <strong>{{ $errors->first('email') }}</strong>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row-6 m-3">
                                                    <div class="input-group has-validation">
                                                        <span class="input-group-text"><i class="fa fa-phone" aria-hidden="true"></i></span>
                                                        <input type="number" class="form-control{{ $errors->has('contact') ? ' is-invalid' : '' }}" name="contact" value="{{ old('contact') }}" required placeholder="{{ __('Contact Number') }}">
                                                        <div class="invalid-feedback">
                                                            @if ($errors->has('contact'))
                                                                <strong>{{ $errors->first('contact') }}</strong>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row-6 m-3">
                                                    <div class="input-group has-validation">
                                                        <span class="input-group-text"><i class="fa fa-key" aria-hidden="true"></i></i></span>
                                                        <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="{{ __('Password') }}">
                                                        <div class="invalid-feedback">
                                                            @if ($errors->has('password'))
                                                                <strong>{{ $errors->first('password') }}</strong>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row-6  m-3">
                                                    <div class="input-group has-validation">
                                                        <span class="input-group-text"><i class="fa fa-key" aria-hidden="true"></i></span>
                                                        <input type="password" class="form-control" id="confirm-password"  name="password_confirmation" placeholder="{{ __('Confirm Password') }}">
                                                    </div>
                                                </div>

                                                <div class="row-6  m-2 justify-content-center">
                                                        <button class="w-100 btn btn-primary btn-lg" type="submit">{{ __('Register') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </section>
        </section>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </body>
</html>
