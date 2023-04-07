@extends('layouts.frontend.app')
@section('content')
<section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('images/bg_1.jpg');">
    <div class="overlay"></div>
    <div class="container">
      <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-center">
        <div class="col-md-9 ftco-animate pb-5 text-center">
         <p class="breadcrumbs"><span class="mr-2"><a href="{{url('/')}}">{{ __('Home') }}<i class="fa fa-chevron-right"></i></a></span> <span>{{ _('Dashboard') }}<i class="fa fa-chevron-right"></i></span></p>
         <h1 class="mb-0 bread">Dashboard</h1>
       </div>
     </div>
   </div>
</section>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ _('Dashboard') }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    {{ __('You are logged in!') }}
                    <a href="{{route('account')}}" style="text-align:center;" class="btn btn-primary">{{ __('Go To Account') }}</a>

                    <p>{{ __('30 Days') }}</p>
                    <p>{{ __("60 Days") }}</p>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
