@extends('layouts.frontend.app')
@section('title') {{ __('Refer').' - Tripkhata®' }} @endsection
@section('content')

<style>
    .res-border{
        border-left: 1px dashed #e0e0e0;
    }
    @media screen and (max-width: 600px) {
        .res-border{
            border-left: hidden;
            border-top: 1px dashed #e0e0e0;

    }
}
</style>
<section class="content">
    <section class="ftco-section  contact-section">
        <div class="container">
            @if (Auth::check())
                @include('contents.emiAlert')
            @else
            @endif

            @if(session('success_message'))
            <div class="alert alert-success alert-dismissible justify-content-center">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>{{session('success_message')}}</strong>
            </div>
            @endif

            <div class="row justify-content-center pb-4">
                <div class="col-md-6 heading-section text-center ftco-animate">
                    <span class="subheading">{{ __('Refer a Friend') }}</span>
                </div>
            </div>


          <?php $total_available =  collect($payments)->sum('total_paid'); ?>
          <?php $total_upcomming =  collect($payments)->sum('price_per_traveller'); ?>
          <?php $total_traveller = collect($payments)->sum('travellers');?>

            <div class="container">
                <div class="row " style="border: 1px solid #e0e0e0;">
                    <div class="col-sm-6 col-md-6 col-lg-6 p-4">
                        <p>Available to use</p>
                        <h3 class="text-success">Rs. {{auth()->user()->balance}} </h3>
                        @if(auth()->user()->balance !==null)
                        <a href="{{ route('packages') }}" class="btn btn-primary mt-3" >Explore packages</a>
                        @endif
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6 p-4 res-border">
                        <p>Future Payments </p>
                        <a class="toggles"  data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" ><span><h3 class="text-info"><i class="fas fa-chevron-down fa-xs"></i>
                            <?php $sum = 0;?>
                            @foreach ($payments  as $key=> $future_payment )
                            <?php $sum+=($future_payment->travellers*$future_payment->price_per_traveller)?>
                            @endforeach
                            <?php $total_incomming = ($sum/100*5) ?>
                             Rs. {{$total_incomming}}
                        </h3></span></a>

                        <div class="collapse" id="collapseExample">
                            <ul style="list-style-type: none;padding: 0;">

                                @foreach ($payments  as $future_payment )
                                <li>Rs. {{($future_payment->price_per_traveller)/100*5}} <small>(To be released at {{date("M d, Y",strtotime(json_decode($future_payment->emi_info,true)[count(json_decode($future_payment->emi_info,true))-1][0]))}})</small></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="container">
                <div class="row my-5 " style="border: 1px solid #e0e0e0;">
                    <div class="col-sm-12 col-md-12 col-lg-12 p-4">
                        <p> </p>
                    </div>
                </div>
            </div> --}}

            <div class="container">
                <div class="row my-5 ">
                    <div class="col-sm-12 col-md-12 col-lg-12 p-4">
                            <h5 class="font-weight-bold mb-3"><i class="fas fa-user-plus fa-sm "></i> Refer a friend</h5>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="refUrl1" value="{{url('/')}}?ref={{ Auth::user()->id }}">
                                <div class="input-group-append">
                                    <span class="input-group-text"><span id="copyLink1" onclick="copyURL(this.id,1)" style="color: rgb(68, 94, 199); cursor:pointer">Copy Link</span></span>
                                </div>
                            </div>
                            <div id="share"></div>
                            <div class="alert alert-info" role="alert">
                                Encourage your friends to sign up at Tripkhata using given link and get 5% bonus on every completed trips. You can use available balance in Tripkhata network. More info in <a href="{{url('terms')}}" style="border-bottom:solid 1px"> Terms and Condition.</a>
                            </div>
                    </div>
                </div>
            </div>

            <div class="container row justify-content-center pb-4">
                <div class="col-md-6 heading-section text-center ftco-animate">
                    <h4 class="mb-2">{{ __('Referal History ') }}</h4>
                </div>

                <table class="table">
                    <thead class="thead-light">
                      <tr>
                        <th scope="col">User ID</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Commited</th>
                      </tr>
                    </thead>
                    <tbody>
                       @forelse ($refer_history as $key=>$data)
                        <tr>
                            <th scope="row">{{ $data->u_id }}</th>
                            <td> {{ \Carbon\Carbon::parse($data->created)->format('Y-m-d')}}</td>
                            <td>@if($data->status=='active' || $data->status=='completed')<i class="fas fa-check-circle text-success mr-1"></i> @elseif($data->status==null || $data->status=='')<i class="fas fa-times-circle text-danger mr-1"></i>@endif</td>
                        </tr>
                       @empty
                        <tr><td colspan="3" class="text-center">Your invitees are shown here.</tr>
                       @endforelse
                    </tbody>
                  </table>
            </div>
    </section>
    <script>
        $('.toggles').click(function() {
            $("i", this).toggleClass(" fa-chevron-up  fa-chevron-down");
        });
    </script>

    <script>
        $("#share").jsSocials({
            url: "{{url('/')}}?ref={{ Auth::user()->id }}",
            text: "Trip Khata",
            showLabel:false,
            shares: [
                "email",
                "twitter",
                "facebook",
                "viber",
                "messenger",
                "whatsapp"
            ],
        });
    </script>
@endsection
