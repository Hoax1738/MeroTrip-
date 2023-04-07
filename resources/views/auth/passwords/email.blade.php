@extends('layouts.frontend.app')
@section('content')
@section('title') Reset Password @endsection
<section class="ftco-section">

<section class="content">
    <section class="ftco-section">
    <div class="container margined">
        <div class="row justify-content-center pb-4">
            <div class="col-md-6 heading-section text-center ftco-animate">
                <h2 class="mb-4">Reset Password</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card  text-center">
                    <div class="card-body">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif
                    <form method="POST" action="{{ route('password.email') }}">@csrf

                        @if ($errors->has('email'))
                            <div class="alert alert-danger" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </div>
                        @endif

                        <div class="form-group row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required placeholder="Enter Email Address">
                            </div>
                        </div>

                        <div class="form-group row mb-0 ml-4">
                            <div class="offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
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
@endsection


