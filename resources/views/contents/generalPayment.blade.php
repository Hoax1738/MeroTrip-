@extends('layouts.frontend.app')
@section('title'){{ __('General Payment For') }} {{__($commitInfo->title)}}  - Tripkhata® @endsection
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
                    <h2 class="mb-2">{{ __('Make General Payment') }}</h2>
                </div>
            </div>
        <div class="d-flex justify-content-center">
            <div class="col-md-8">
                <div class="card">
                <div class="card-header card-header-trip">
                    <h5 class="card-title">{{ __('Make General Payment for ') }} {{__($commitInfo->title)}} ({{__($commitInfo->commence_date)}})</h5>
                </div>
                    <div class="card-body py-2">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating">{{ __('Total Cost') }}: NPR {{$total_cost=$commitInfo->price_per_traveller*$commitInfo->travellers}}</label>
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
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">{{ __('Total Remaining') }}: NPR {{$remaining}}</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="font-weight-bold d-flex justify-content-center">{{ __('Enter Amount') }}</label>
                                            <form action="{{route('postPayment')}}" id="paymentForm" method="post">
                                                @csrf
                                                <input type="number" id="amount"  name="amount" value="<?php if($generalAmount) echo $generalAmount;  else echo $remaining ;?>" class="form-control"/>
                                                <input type="hidden" name="clickref" value="{{$commitInfo->id}}"/>
                                                <input type="hidden" id="payment_data" name="payment_data" value=""/>
                                                <input type="hidden" id="productID" name="productID" value="<?php echo strtolower($commitInfo->title."-".$commitInfo->commence_date)?>"/>
                                                <input type="hidden" id="productName" name="productName" value="General Payment for {{$commitInfo->title}} ({{$commitInfo->commence_date}})"/>
                                                <input type="hidden" id="productURL" name="productURL" value="{{route('singlePackage',['slug'=>$commitInfo->slug])}}"/>
                                                <input type="hidden" name="post[general]" value="general"/>
                                            </form>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                    <label class=" text-dark d-flex justify-content-center">{{ __('Select a payment method') }}</label>
                                    </div>
                                </div>
                            </div>

                             <div>
                                <div>
                                    <form action="{{config('esewa.url')}}" method="POST" id="esewaForm">
                                        <input value="{{$commitInfo->id}}.{{ date('Y-m-d H:i:s')}}" name="pid" type="hidden">
                                        <input value="<?php if($generalAmount) echo $generalAmount;  else echo $remaining ;?>" name="tAmt" type="hidden">
                                        <input value="<?php if($generalAmount) echo $generalAmount;  else echo $remaining ;?>" name="amt" type="hidden">
                                        <input value="0" name="txAmt" type="hidden">
                                        <input value="0" name="psc" type="hidden">
                                        <input value="0" name="pdc" type="hidden">
                                        <input value="{{config('esewa.scd')}}" name="scd" type="hidden">
                                        <input value="{{route('esewa.generalSuccess')}}" type="hidden" name="su">
                                        <input value="{{route('esewa.generalFail')}}" type="hidden" name="fu">
                                        <input type="hidden" name="post[general]" value="general"/>
                                    </form>
                                </div>
                            </div>
                            <div class="d-flex flex-row justify-content-center pay-btn" style="cursor: pointer">
                                <img width="100px" src="{{asset('images/khalti.png')}}" alt="Khalti" id="payment-button" class="mr-4">
                                <img width="100px"
                                    src="{{asset('images/esewa.png')}}" onclick="event.preventDefault(); document.getElementById('esewaForm').submit()"
                                    alt="Eswewa">
                            </div>
                        @endif
                        <?php $remaining_per = ($payments_made*100)/$total_cost ?>
                        <span>{{round($remaining_per)}}%</span>

                        <div class="progress mt-2">
                            <div class="progress-bar  bg-trip" role="progressbar" style="width: {{$remaining_per}}%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>

        <script src="https://khalti.s3.ap-south-1.amazonaws.com/KPG/dist/2020.12.17.0.0.0/khalti-checkout.iffe.js"></script>
        <script>
            var config = {
                // replace the publicKey with yours
                "publicKey": "test_public_key_33278810dab44de68d5a411e57d47154",
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

                var amount=document.getElementById('amount').value;
                var min= '<?php echo $min;?>';
                var max= '<?php echo $remaining;?>';

                if(amount==0){
                    alert('Value should be greater than zero');
                    exit();
                }

                if(parseInt(amount)<parseInt(min)){
                    alert('Value should be greater or equal to min value '+ min);
                    exit();
                }

                if(parseInt(amount)>parseInt(max)){
                    alert('Value should be less than or equal to max value '+max);
                    exit();
                }

                checkout.show({amount: (document.getElementById("amount").value*100)});
            }

        </script>

        <script>
            $(document).keypress(function(event) {
            if (event.key === "Enter") {
                var amt= $('#amount').val();
                var min= '<?php echo $min;?>';
                var max= '<?php echo $remaining;?>';

                if(amt==0){
                    alert('Value should be greater than zero');
                    $('#amount').val(max);
                    exit();

                }

                if(parseInt(amt)<parseInt(min)){
                    alert('Value should be greater or equal to min value '+ min);
                    $('#amount').val(max);
                    exit();

                }

                if(parseInt(amt)>parseInt(max)){
                    alert('Value should be less than or equal to max value '+max);
                    $('#amount').val(max);
                    exit();

                }


            }
        });

        </script>
    @endsection
