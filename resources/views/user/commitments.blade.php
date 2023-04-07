@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">My Commitments</div>
                <div class="card-body">
                    <div class="row">
                    @forelse ($commitments as $commitment)
                        <div class="col-4">
                            <div class="card">
                                <div class="card-header">{{$commitment->title}} ({{$commitment->commence_date}})</div>
                                <div class="card-body">
                                    @if($commitment->travellers>1)
                                    Cost per traveller: NPR {{$commitment->price_per_traveller}}<br/>
                                    Travellers: {{$commitment->travellers}}<br/>
                                    @endif
                                    Total Cost: NPR {{$commitment->price_per_traveller*$commitment->travellers}}<br/>
                                    Total Paid: NPR {{$commitment->total_paid}}<br/>
                                    Total Remaining: NPR {{$commitment->price_per_traveller*$commitment->travellers - $commitment->total_paid}}<br/>
                                    Next Pay Date: {{$commitment->next_pay_date}}<br/>
                                    Status: {{$commitment->status}}<br/><br/>
                                    <div style="text-align:center">
                                        <a href="{{route('singlePackage',['slug'=>$commitment->slug])}}" class="btn btn-sm btn-primary">View Trip Info</a>
                                        <a href="{{route('viewEMI',['id'=>$commitment->id])}}" class="btn btn-sm btn-primary">Future EMI</a>
                                        <a href="{{route('myPayments')}}" class="btn btn-sm btn-primary">Payments</a>
                                        <a href="{{route('makePayment')}}" class="btn btn-sm btn-primary">Make a Payment</a>
                                        <a href="#" class="btn btn-sm btn-danger">Request cancellation</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-danger font-weight-bold">No commitments</p>
                    @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
