@extends('layouts.frontend.app')
@section('title') {{ __('Contact').' - Tripkhata®' }} @endsection
@section('content')

<section class="content">

    <section class="ftco-section  contact-section">
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
                <div class="col-md-6 heading-section text-center ftco-animate">
                    <h2 class="mb-2">{{ __('Contact') }}</h2>
                </div>
            </div>
        <div class="row d-flex contact-info">
            <div class="col-md-3 d-flex">
            <div class="align-self-stretch box p-4 text-center">
            <div class="icon d-flex align-items-center justify-content-center">
            <span class="fa fa-map-marker"></span>
            </div>
            <h3 class="mb-2"> {{ __('Address') }}</h3>
            <p><a> {{ __('Shantinagar, Kathmandu') }}</a></p>
        </div>
        </div>
        <div class="col-md-3 d-flex">
        <div class="align-self-stretch box p-4 text-center">
            <div class="icon d-flex align-items-center justify-content-center">
            <span class="fa fa-phone"></span>
        </div>
        <h3 class="mb-2">{{ __('Contact') }}</h3>
        <p><a>+977-9860010920</a></p>
        </div>
    </div>
    <div class="col-md-3 d-flex">
        <div class="align-self-stretch box p-4 text-center">
        <div class="icon d-flex align-items-center justify-content-center">
        <span class="fa fa-paper-plane"></span>
        </div>
        <h3 class="mb-2"> {{ __('Email Address') }}</h3>
        <p><a href="mailto:info@tripkhata.com">{{ __('info@tripkhata.com') }}</a></p>
    </div>
    </div>
    <div class="col-md-3 d-flex">
    <div class="align-self-stretch box p-4 text-center">
        <div class="icon d-flex align-items-center justify-content-center">
        <span class="fa fa-globe"></span>
    </div>
    <h3 class="mb-2">{{ __('Website') }}</h3>
    <p><a href="https://tripkhata.com/"> {{ __('TripKhata.com') }}</a></p>
    </div>
    </div>
    </div>
    </div>
    </section>

    <section class="ftco-section contact-section ftco-no-pt">
        <div class="container">
        <div class="row block-9">
            <div class="col-md-6 order-md-last d-flex">
            <form action="{{route('sendenquiry')}}" method="POST" class="bg-light p-5 contact-form">
                @csrf
                <div class="form-group">
                <input type="text" name="username" class="form-control" placeholder="{{ __('Name') }}">
                </div>
                @error('username')
                <span class="text-danger">{{ $message }}</span>
                @enderror
                <div class="form-group">
                <input type="text" name="email" class="form-control" placeholder="{{ __('Email') }}">
                </div>
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                <div class="form-group">
                <input type="text" name="subject" class="form-control" placeholder="{{ __('Subject') }}">
                </div>
                @error('subject')
                <span class="text-danger">{{ $message }}</span>
                @enderror
                <div class="form-group">
                <textarea name="message" cols="30" rows="7" class="form-control" placeholder="{{ __('Message') }}"></textarea>
                </div>
                @error('message')
                <span class="text-danger">{{ $message }}</span>
                @enderror
                <div class="form-group">
                <input type="submit" value="{{ __('Send Message') }}" class="btn btn-primary py-3 px-5">
                </div>
            </form>

            </div>

            <div class="col-md-6 d-flex">
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d7065.888125326886!2d85.34532949999999!3d27.688123700000002!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2snp!4v1617944591865!5m2!1sen!2snp" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>       </div>
        </div>
    </div>
    </section>


</section>

@endsection
