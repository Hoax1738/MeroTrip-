@extends('layouts.app')
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Unpaid Invoices</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="card">
                                <div class="card-header">Unpaid invoice for hotel</div>
                                <div class="card-body">
                                the hotel invoice goes here.. for Rs 4000
                                <input type="button" class="btn btn-primary" value="pay"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Make a Payment</div>
                <div class="card-body">
                    <div class="row">
                    @forelse ($commitments as $commitment)
                        <div class="col-4">
                            <div class="card">
                                <div class="card-header">Make Payment for <b>{{$commitment->title}} ({{$commitment->commence_date}})</b></div>
                                <div class="card-body">
                                    Total Cost: NPR {{$commitment->price_per_traveller*$commitment->travellers}}<br/>
                                    Total Paid: NPR {{$commitment->total_paid}}<br/>
                                    @if(($commitment->price_per_traveller*$commitment->travellers - $commitment->total_paid)>0)
                                    Total Remaining: NPR {{$commitment->price_per_traveller*$commitment->travellers - $commitment->total_paid}}<br/>
                                    Next Pay Date: {{$commitment->next_pay_date}}<br/><br/>
                                    <div style="text-align:center">
                                        <form action="{{route('postPayment')}}" method="post">
                                            @csrf
                                            <input type="hidden" name="clickref" value="{{$commitment->commit_id}}"/>
                                            <input type="submit" name="post[advance]" value="Make Advance Payment"/>
                                            <input type="submit" name="post[general]" value="Make General Payment"/>
                                        </form>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>No commitments</p>
                    @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
