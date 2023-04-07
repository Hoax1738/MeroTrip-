@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Make a General Payment for {{$commitInfo->title}} ({{$commitInfo->commence_date}})</div>
                <div class="card-body">
                    Total Cost: NPR {{$commitInfo->price_per_traveller*$commitInfo->travellers}}<br/>
                    Total Paid: NPR {{$payments_made}}<br/>
                    @if($remaining>0)
                    Total Remaining: NPR {{$remaining}}<br/><br/>
                    <form action="{{route('postPayment')}}" id="paymentForm" method="post">
                        @csrf
                        <input type="number" id="amount" min="{{$min}}" step="500" max="{{$remaining}}" name="amount" value="{{$remaining}}"/> 
                        <input type="hidden" name="clickref" value="{{$commitInfo->id}}"/>
                        <input type="hidden" id="payment_data" name="payment_data" value=""/>
                        <input type="hidden" id="productID" name="productID" value="<?php echo strtolower($commitInfo->title."-".$commitInfo->commence_date)?>"/>
                        <input type="hidden" id="productName" name="productName" value="General Payment for {{$commitInfo->title}} ({{$commitInfo->commence_date}})"/>
                        <input type="hidden" id="productURL" name="productURL" value="{{route('singlePackage',['slug'=>$commitInfo->slug])}}"/>
                        <input type="hidden" name="post[general]" value="general"/>
                        <input type="button" id="payment-button" value="Pay Now"/>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var config = {
        "publicKey": "test_public_key_dc74e0fd57cb46cd93832aee0a507256",
        "productIdentity": document.getElementById("productID").value,
        "productName": document.getElementById("productName").value,
        "productUrl": document.getElementById("productURL").value,
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
</script>
@endsection