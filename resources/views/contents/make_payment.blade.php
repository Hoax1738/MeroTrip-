@extends('layouts.frontend.app')
@section('title') {{ __('Make Payment').' - Tripkhata®' }}@endsection
@section('content')

<section class="content">
    <section class="ftco-section">
        <div class="container">
            @if (Auth::check())
            @include('contents.emiAlert')
            @else
            @endif
            <div class="row justify-content-center pb-4">
                <div class="col-md-6 heading-section text-center ftco-animate">
                    <h2 class="mb-4">{{ __('Make Payment') }}</h2>
                </div>
            </div>
            @if(session('success_message'))
                <div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>{{__(session('success_message'))}}</strong>
                </div>
            @endif

            @if(count($commitments)>0)
                <div class="row">
                    @foreach ($commitments as $commitment)
                                <?php
                                    $package_cost = $commitment->price_per_traveller;
                                    $total_paid=$commitment->total_paid;
                                    $total_travellers=$commitment->travellers;
                                    $total_remaining=$package_cost*$total_travellers - $total_paid;
                                    $total_cost= $package_cost*$total_travellers

                                ?>
                    <div class="col-md-6">
                        <div class="card">
                        <div class="card-header card-header-trip">
                            <h5 class="card-title"> {{ __('Make Payment for') }} {{__($commitment->title)}} ({{($commitment->commence_date)}})</h5>
                        </div>
                            <div class="card-body py-2">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"> {{ __('Total Cost') }}: NPR {{$total_cost}}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                            <label class="bmd-label-floating"> {{ __('Total Paid') }}: NPR {{$total_paid}}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"> {{ __('Total Remaining') }}: NPR {{$total_remaining}}</label>
                                        </div>
                                        </div>
                                        @if($total_remaining>0)

                                        <div class="col-md-6">
                                            <div class="form-group">
                                            <label class="bmd-label-floating"> {{ __('Next Pay Date') }}: {{$commitment->next_pay_date}}</label>
                                            </div>
                                        </div>
                                        @else
                                        <div class="col-md-6">
                                            <div class="form-group">
                                            <label class="text-primary"> {{ __('Payment Done') }}!</label>
                                            </div>
                                        </div>
                                        @endif

                                    </div>
                                    @if($total_remaining>0)
                                        <div class="row justify-content-center mt-4">
                                            <span class="pt-1 pr-5"> {{ __('Select Type') }}: </span>
                                            <form action="{{route('postPayment')}}" method="post">
                                                @csrf
                                                <input type="hidden" name="clickref" value="{{$commitment->commit_id}}"/>
                                                <input type="submit" class="btn btn-outline-dark mb-1" name="post[advance]" value="{{ __('Advance') }}"/>
                                                {{-- <input type="submit" class="btn btn-outline-dark mb-1 ml-4" name="post[general]" value="{{ __('General') }}"/> --}}
                                            </form>
                                        </div>
                                    @endif
                                    <?php $remaining_per = ($total_paid*100)/$total_cost ?>
                                    <div class="progress">
                                    <div class="progress-bar  bg-trip" role="progressbar" style="width: {{$remaining_per}}%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                  </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
            <div class="row pt-5 text-center">
                <div class="col-lg-12">
                    {{-- <h5 class="d-flex justify-content-center text-danger">* {{ __('No Records Found') }}</h5> --}}
                    <a style="text-center" class="btn btn-primary px-4 py-2" href="{{ route('packages') }}"> Add New Package</a>
                </div>
            </div>
            @endif
    </section>
</section>
@endsection
