@extends('layouts.frontend.app')
@section('title') {{ __('Advance Payment For') }} {{__($commitInfo->title)}}  - Tripkhata® @endsection
@section('content')
{{-- @include('layouts.frontend.breadcrumb') --}}

<section class="content">
    <section class="ftco-section">
        <div class="container">
            @if (Auth::check())
            @include('contents.emiAlert')
            @else
            @endif
            <div class="row justify-content-center pb-4">
                <div class="col-md-6 heading-section text-center ftco-animate">
                    <h2 class="mb-2">{{ __('Make Advance Payment') }}</h2>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                    <div class="card-header card-header-trip">
                        <h5 class="card-title"> {{ __('Make Advance Payment for ') }} {{__($commitInfo->title)}} ({{__($commitInfo->commence_date)}})</h5>
                    </div>
                    <div class="card-body py-2">
                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group">
                                <label class="bmd-label-floating"> {{ __('Total Cost') }}: NPR {{$total_cost=$commitInfo->price_per_traveller*$commitInfo->travellers}}</label>
                            </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                <label class="bmd-label-floating">{{ __('Total Paid') }}: NPR {{$payments_made}}</label>
                                </div>
                            </div>
                            </div>

                            @if($remaining>0)
                                <div class="row">
                                        <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"> {{ __('Total Remaining') }} NPR {{$remaining}}</label>
                                        </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                            <label class="bmd-label-floating"> {{ __('Paying Advance For') }}: {{$futureemi[0][0]}}</label>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"> {{ __('Payment Amount') }}: NPR @if($remaining<$futureemi[0][1]){{ $remaining }} @else {{$futureemi[0][1]}} @endif</label>
                                            </div>
                                        </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                        <label class=" text-dark d-flex justify-content-center">{{ __('Select a Payment Method') }}</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <form action="{{route('postPayment')}}" id="paymentForm" method="post">
                                                @csrf
                                                <input type="hidden" name="clickref" value="{{$commitInfo->id}}"/>
                                                <input type="hidden" name="confirm" value="true"/>
                                                <input type="hidden" id="payment_data" name="payment_data" value=""/>
                                                <input type="hidden" id="amount" name="amount" value="@if($remaining<$futureemi[0][1]){{ $remaining }} @else {{$futureemi[0][1]}} @endif"/>
                                                <input type="hidden" id="productID" name="productID" value="<?php echo strtolower($commitInfo->title."-".$commitInfo->commence_date)?>"/>
                                                <input type="hidden" id="productName" name="productName" value="General Payment for {{$commitInfo->title}} ({{$commitInfo->commence_date}})"/>
                                                <input type="hidden" id="productURL" name="productURL" value="{{route('singlePackage',['slug'=>$commitInfo->slug])}}"/>
                                                <input type="hidden"  name="post[advance]" value="advance"/>
                                            </form>
                                            {{-- <input type="image" style="width: 50%" src="{{asset('images/khalti.png')}}" id="payment-button"/> --}}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                            <form action="{{config('esewa.url')}}" method="POST" id="esewaForm">
                                                <input value="@if($remaining<$futureemi[0][1]){{ $remaining }} @else {{$futureemi[0][1]}} @endif" name="tAmt" type="hidden">
                                                <input value="@if($remaining<$futureemi[0][1]){{ $remaining }} @else {{$futureemi[0][1]}} @endif" name="amt" type="hidden">
                                                <input value="0" name="txAmt" type="hidden">
                                                <input value="0" name="psc" type="hidden">
                                                <input value="0" name="pdc" type="hidden">
                                                <input value="{{config('esewa.scd')}}" name="scd" type="hidden">
                                                <input value="{{$commitInfo->id}}.{{ date('Y-m-d H:i:s')}}" name="pid" type="hidden">
                                                <input value="{{route('esewa.success')}}" type="hidden" name="su">
                                                <input value="{{route('esewa.fail')}}" type="hidden" name="fu">
                                                <input type="hidden"  name="post[advance]" value="advance"/>
                                            {{-- <input type="image" style="width: 50%" src="{{asset('images/esewa_logo.png')}}" alt="Submit"> --}}
                                        </form>
                                    </div>

                                    {{-- <div class="row">
                                        <div class="col-md-6">
                                            <form action="https://stg.imepay.com.np:7979/WebCheckout/Checkout" method="POST" id="imeForm">
                                                @csrf
                                                <input value="{{$response['Amount']}}" name="TranAmount" type="hidden">
                                                <input value="{{$response['TokenId']}}" name="TokenId" type="hidden">
                                                <input value="POST" name="method" type="hidden">
                                                <input value="LIGHTSLAB" name="MerchantCode" type="hidden">
                                                <input value="{{$response['RefId']}}" name="RefId" type="hidden">
                                                <input value="{{url('ime/advancePayment')}}" type="hidden" name="RespUrl">
                                                <input value="{{url('ime/fail')}}" type="hidden" name="CancelUrl">
                                            </form>
                                        </div>
                                    </div> --}}
                                </div>

                                <div class="d-flex flex-row  justify-content-center pay-btn" >
                                    {{-- <img width="100px" src="{{asset('images/khalti.png')}}" alt="Khalti" id="payment-button" class="mr-4"> --}}
                                    <img width="100px"
                                        src="{{asset('images/esewa.png')}}" onclick="event.preventDefault(); document.getElementById('esewaForm').submit()"
                                        alt="Eswewa" class="mr-3" style="cursor: pointer">
                                        {{-- <img width="100px"
                                        src="{{asset('images/ime.svg')}}" onclick="event.preventDefault(); document.getElementById('imeForm').submit()"
                                        alt="Ime" class="mr-3" style="cursor: pointer"> --}}
                                        {{-- <button class="btn btn-primary" onclick="event.preventDefault(); document.getElementById('esewaForm').submit();" style="cursor: pointer">Pay Now</button> --}}
                                </div>
                            @endif

                            <?php $remaining_per = ($payments_made*100)/$total_cost ?>
                            <span>{{round($remaining_per)}}%</span>

                            <div class="progress mt-2">
                                <div class="progress-bar bg-trip" role="progressbar" style="width: {{$remaining_per}}%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
</section>
{{--
<script src="https://khalti.s3.ap-south-1.amazonaws.com/KPG/dist/2020.12.17.0.0.0/khalti-checkout.iffe.js"></script>
<script>
    var config = {
        // replace the publicKey with yours
        "publicKey": "live_public_key_b89a91af1eb144d3aa39b4d3940a3a58",
        // "publicKey": "test_public_key_33278810dab44de68d5a411e57d47154",

        "productIdentity": document.getElementById("productID").value,
        "productName": document.getElementById("productName").value,
        "productUrl": document.getElementById("productURL").value,
        "paymentPreference": [
            "KHALTI",
            "EBANKING",
            "MOBILE_BANKING",
            "CONNECT_IPS",
            "SCT",
            ],
        "eventHandler": {
            onSuccess (payload) {
                document.getElementById("payment_data").value = JSON.stringify(payload);
                document.getElementById('paymentForm').submit();
            },
            onError (error) {},
            onClose () {}
        }
    };

    var checkout = new KhaltiCheckout(config);
    var btn = document.getElementById("payment-button");
    btn.onclick = function () {
        checkout.show({amount: (document.getElementById("amount").value*100)});
    }

</script> --}}

@endsection
