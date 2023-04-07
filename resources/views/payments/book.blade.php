@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">My Payments</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Package Title</th>
                                        <th scope="col">Payment Type</th>
                                        <th scope="col">Payment Method</th>
                                        <th scope="col">Payment Status</th>
                                        <th scope="col">Note</th>
                                        <th scope="col">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($payments as $payment)
                                    <tr>
                                        <th>{{$payment->payment_id}}</th>
                                        <th>{{$payment->package_title}}</th>
                                        <th style="text-transform:capitalize;">{{str_replace("_"," ",$payment->type)}}</th>
                                        <th>{{$payment->method}}</th>
                                        <th>{{$payment->payment_status}}</th>
                                        <th>{{$payment->invoice_note}}</th>
                                        <th>NPR {{$payment->amount}}</th>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" style="text-align:center;">No Payments Found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <center>
                                <a class="btn btn-primary" href="{{route('makePayment')}}">Make a Payment</a>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
