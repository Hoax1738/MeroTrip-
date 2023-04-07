@extends('layouts.app')
@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-4">
            <div class="alert bg-light">
                <p class="py-2">Price Per Person</p>
                <h3>Rs {{$item[0]['price']}}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="alert bg-light">
                <p class="py-2">Available seats</p>
                <h3>{{$available_slots}}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="alert bg-light">
                <p class="py-2">Travel Date</p>
                <h3>{{$item[0]['commence_date']}}</h3>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3>
                EMI Settings
            </h3>
            <form action="" id="paymentForm" method="post">
                @csrf
                <input type="hidden" name="clickref" value="{{$item[0]['id']}}"/>
                <input type="hidden" id="payment_data" name="payment_data" value=""/>
                <input type="hidden" id="productID" name="productID" value="<?php echo strtolower($item[0]['slug']."-".$item[0]['commence_date'])?>"/>
                <input type="hidden" id="productName" name="productName" value="Down Payment for {{$item[0]['title']}} ({{$item[0]['commence_date']}})"/>
                <input type="hidden" id="productURL" name="productURL" value="{{route('singlePackage',['slug'=>$item[0]['slug']])}}"/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                            <label for="downAmount">Down Payment</label>
                            <input type="number" name="down" value="{{$down}}" class="form-control" id="amount" aria-describedby="amountHelp" placeholder="Enter Amount">
                            <small id="amountHelp" class="form-text text-muted">The Amount you will pay at the start.</small>
                        </div>
                        <div class="col-md-5">
                            <label for="exampleInputPassword1">No. Of Travellers</label>
                            <input type="number" name="travellers" class="form-control" min="1" max="{{$available_slots}}" value="{{$travellers}}" placeholder="No. of Travellers">
                        </div>
                        <div class="col-md-2 py-4">
                            <input type="submit" class="btn btn-primary" value="Revise EMI"/>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            <h5>Estimated Payments for {{$travellers}} Traveller<?=($travellers>1)?"s":"";?></h5>

            <?php
            $per_row = (count($emi)>6)?6:count($emi);
            ?>
            <div class="row">
            @foreach($emi as $i)
                @if($i[1]>0)
                <div class="col-{{intval(12/$per_row)}} py-2">
                    <div class="card">
                        <div class="card-header">
                        {{$i[0]}}
                        </div>
                        <div class="card-body">
                        NPR {{$i[1]}}
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
            </div>
        </div>
        <div class="row py-3">
                <div class="col-md-8 offset-md-2">
                        <input type="button" id="payment-button" class="btn btn-success w-100" value="Pay Down Payment and Book"/>
                </div>
            </div>
    </div>
</div>
<script src="https://khalti.com/static/khalti-checkout.js"></script>
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
