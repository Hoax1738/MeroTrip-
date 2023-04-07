@extends('layouts.frontend.app')
@section('title') {{ 'Book Trip For' }} {{__($item[0]['title']) }} {{ __('- Tripkhata®') }} @endsection
@section('slider')
    <link rel="stylesheet" href="{{asset('modalImages/image.css')}}">
@endsection
@section('content')
<section class="content">
    <section class="ftco-section ftco-no-pb contact-section mb-1">
        <div class="container">
            <div class="row justify-content-center pb-4 ">
                <div class="col-md-6 heading-section text-center ftco-animate">
                    <h2 class="mb-2"> {{ 'Book' }}: {{$item[0]['title']}}</h2>
                    <h6 class="mb-2"> {{ 'Trip Days' }}: {{$item[0]['duration']}}</h6>
                    <h6 class="mb-2"> {{ 'Destination' }}: {{$item[0]['destination']}}</h6>
                </div>
            </div>
            <div class="row d-flex contact-info">
                <div class="col-md-4 d-flex">
                <div class="align-self-stretch box p-4 text-center  mb-1">
                    <div class="icon d-flex align-items-center justify-content-center">
                        <span class="fa fa-user"></span>
                    </div>
                    <h3 class="mb-2"> {{ 'Price Per Person' }}</h3>
                    <p>Rs {{$item[0]['price']}}</p>
                </div>
                </div>

                <div class="col-md-4 d-flex">
                    <div class="align-self-stretch box p-4 text-center  mb-1">
                        <div class="icon d-flex align-items-center justify-content-center">
                        <span class="fa fa-users"></span>
                        </div>
                        <h3 class="mb-2"> {{ 'Available seats' }}</h3>
                        <p>{{$available_slots}}</p>
                    </div>
                </div>

                <div class="col-md-4 d-flex">
                    <div class="align-self-stretch box p-4 text-center mb-1">
                        <div class="icon d-flex align-items-center justify-content-center">
                        <span class="fa fa-paper-plane"></span>
                        </div>
                        <h3 class="mb-2"> {{ 'Travel Date' }}</h3>
                        <p>{{$item[0]['commence_date']}}</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

     <section class="ftco-section mt-5" id="flick">
        <div id="carouselExampleIndicators" class="carousel slide container" data-ride="carousel">
            <?php
                $images=explode(',',$item[0]['images']);
            ?>
            <ol class="carousel-indicators">
                @foreach($images as $key=>$row)
                    <li data-target="#carouselExampleIndicators" data-slide-to="{{ $key }}" class="@if($key==0)active @endif"></li>
                @endforeach
            </ol>
            <div class="carousel-inner">
                @foreach($images as $key=>$row)
                    <div class="carousel-item @if($key==0)active @endif img-fluid">
                        @php $image=\App\Image::find($row); @endphp
                        @if($image!=NULL)
                            <img class="d-block w-100" style="height: 570px" @if($image->drive_id==NULL) src="{{url("$image->directory/$image->local_filename")}}" @else src="https://drive.google.com/uc?export=view&id={{$image->drive_id}}" @endif alt="{{ $key+1 }} slide" id="myImg<?php echo $key+1;?>" onclick="imgMove({{$key+1}})">
                        @endif    
                    </div>
                @endforeach
            </div>

            @if(count($images)>1)
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            @endif
        </div>
    </section>

    <section class="ftco-section">
        <div class="container">
            <div class="section-top-border">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <h3 class="mb-30 title_color">{{ __('EMI  Setting') }}</h3>
                        <form action="" id="paymentForm" method="POST">
                            @csrf
                            <input type="hidden" name="clickref" value="{{$item[0]['id']}}"/>
                            <input type="hidden" id="payment_data" name="payment_data" value=""/>
                            <input type="hidden" id="productID" name="productID" value="<?php echo strtolower($item[0]['slug']."-".$item[0]['commence_date'])?>"/>
                            <input type="hidden" id="productName" name="productName" value="Down Payment for {{$item[0]['title']}} ({{$item[0]['commence_date']}})"/>
                            <input type="hidden" id="productURL" name="productURL" value="{{route('singlePackage',['slug'=>$item[0]['slug']])}}"/>
                            <div class="form-group">

                                <input type="hidden" name="package_id" value="{{ $item[0]['package_id'] }}">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>{{ __('Down Payment ') }}</label>
                                        <input type="number" class="form-control" name="down" value="{{$down}}" id="amount"  placeholder = 'Enter Amount' required>
                                        <small id="amountHelp" class="form-text text-muted">{{ __('The Amount you will pay at the start.') }}</small>
                                    </div>
                                    <div class="col-md-4">
                                        <label> {{ __('No. Of Travellers') }}</label>
                                        <input type="number" class="form-control" name="travellers" value="{{$travellers}}"  id="traveller-seat" placeholder = 'No. Of Travellers' required >
                                        <small id="amountHelp" class="form-text text-muted">{{ __('Number of travelers in trip') }}</small>
                                    </div>
                                    <div class="col-md-4 mt-3 py-4">
                                        <button type="submit"  class="btn btn-outline-dark" id="revise-emi">{{__('Revise EMI') }}</button>
                                    </div>
                                    <div class="pay-btn col-md-4">
                                        <div class="py-4">
                                            <h5 class="mb-4">{{ __('Select Payment') }}</h5>
                                            {{-- <img class="mr-4" width="100px" src="{{asset('images/khalti.png')}}" alt="Khalti" id="payment-button"> --}}
                                            <img class="mr-4" width="100px"
                                                src="{{asset('images/esewa.png')}}" onclick="event.preventDefault(); document.getElementById('esewaForm').submit()"
                                                alt="Eswewa" style="cursor: pointer">
                                                {{-- <img width="100px"
                                                src="{{asset('images/ime.svg')}}" onclick="event.preventDefault(); document.getElementById('imeForm').submit()"
                                                alt="IME" style="cursor: pointer"> --}}
                                                {{-- <button class="btn btn-primary py-2 ml-3" onclick="event.preventDefault(); document.getElementById('esewaForm').submit();" style="cursor: pointer">Pay Now</button> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="section-top-border">
                <h3 class="mb-20 title_color">Estimated Monthly Savings for {{$travellers}} Traveller<?=($travellers>1)?"s":"";?></h3>
                <div class="row py-1">
                    <?php $sn=1 ?>
                    @foreach($emi as $i)
                    @if($i[1]>0)

                    <div class="col-md-4 col-12 mb-2">
                        <div class="card card-chart">
                            <div class="card-header card-header-trip">
                                Due: {{$i[0]}}
                            </div>
                            <div class="card-body">
                                <h4 class="card-title">Monthly Savings {{$sn++}}</h4>
                                <p class="card-category">
                                    NPR {{$i[1]}}
                                </p>
                            </div>

                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <form action="{{config('esewa.url')}}" method="POST" id="esewaForm">
                        <input value="{{$down}}" name="tAmt" type="hidden">
                        <input value="{{$down}}" name="amt" type="hidden">
                        <input value="0" name="txAmt" type="hidden">
                        <input value="0" name="psc" type="hidden">
                        <input value="0" name="pdc" type="hidden">
                        <input value="{{config('esewa.scd')}}" name="scd" type="hidden">
                        <input value="{{$item[0]['id']}}.{{ $travellers }}.{{ date('Y-m-d H:i:s')}}.{{ $item[0]['package_id'] }}" name="pid" type="hidden">
                        <input value="{{route('esewa.bookSuccess')}}" type="hidden" name="su">
                        <input value="{{route('esewa.bookFail')}}" type="hidden" name="fu">  
                    </form>
                </div>
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
                        <input value="{{url('ime/bookSuccess')}}" type="hidden" name="RespUrl">
                        <input value="{{url('ime/fail')}}" type="hidden" name="CancelUrl">
                    </form>
                </div>
            </div> --}}

        </div>
    </section>
    <div id="myModal" class="modal_img">

        <!-- The Close Button -->
        <div class="ourImg">
            <span class="close" id="shut">&times;</span>
        </div>

        <!-- Modal Content (The Image) -->
        <img class="modal-content_img" id="img01">

        <!-- Modal Caption (Image Text) -->
        <div id="caption"></div>
    </div>
</section>
{{-- <script src="https://khalti.s3.ap-south-1.amazonaws.com/KPG/dist/2020.12.17.0.0.0/khalti-checkout.iffe.js"></script>
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
            onClose () {
                // document.getElementById('flick').style.display="block";
            }
        }
    };

    var checkout = new KhaltiCheckout(config);
    var btn = document.getElementById("payment-button");
    btn.onclick = function () {
        // document.getElementById('flick').style.display="none";
        var amt= $('#amount').val();
        var max='<?php echo $available_slots;?>';
        var seat=$('#traveller-seat').val();

        if(amt==0){
            alert('Value should be greater than zero');
            $('#amount').val(10);
            exit();
        }

        if(parseInt(amt)<1000){
            alert('Value should be greater or equal to 1000');
            $('#amount').val(1000);
            exit();
        }

        if(parseInt(seat)<1){
            alert('No of Travellers should be atleast 1');
            $('#seat').val(1);
            exit();
        }

        if(parseInt(seat)>max){
            alert('No of Travellers should be less than equal to '+max);
            $('#seat').val(1);
            exit();
        }

        checkout.show({amount: (document.getElementById("amount").value*100)});
    }

</script> --}}

<script>

$( "#revise-emi" ).click(function() {
    var amt= $('#amount').val();
    var max='<?php echo $available_slots;?>';
    var seat=$('#traveller-seat').val();

        if(amt==0){
            alert('Value should be greater than zero');
            $('#amount').val(1000);
            exit();
        }

        if(parseInt(amt)<1000){
            alert('Value should be greater or equal to 1000');
            $('#amount').val(1000);
            exit();
        }

        if(parseInt(seat)<1){
            alert('No of Travellers should be atleast 1');
            $('#seat').val(1);
            exit();
        }

        if(parseInt(seat)>max){
            alert('No of Travellers should be less than equal to '+max);
            $('#seat').val(1);
            exit();
        }
});

</script>
<script>
    var modal = document.getElementById("myModal");
    var modalImg = document.getElementById("img01");
    var captionText = document.getElementById("caption");
    function imgMove(id){
        modal.style.display = "block";
        modalImg.src = document.getElementById("myImg"+id).src;
        captionText.innerHTML = document.getElementById("myImg"+id).alt;
    }

    var span = document.getElementById("shut");

    span.onclick = function() {
        modal.style.display = "none";
    }

</script>

<script>
    $(document).ready(function() {
        $('.carousel').carousel({
            interval: 1500
        });

    });
</script>
@endsection
