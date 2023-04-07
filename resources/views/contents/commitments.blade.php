@extends('layouts.frontend.app')
@section('title') {{ __('My Commitments').' - Tripkhata®' }} @endsection
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
                    <h2 class="mb-4">{{ __('My Commitments') }}</h2>
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
                    @foreach($commitments as $commitment)
                    <div class="col-md-6">
                        <div class="card">
                                <?php $images=explode(",",$commitment->images); 
                                    $image_info=\App\Image::find($images[0]);  
                                ?>
                                @if($image_info!=NULL)
                                    @if($image_info->drive_id==NULL)
                                        <div class="img" style="background-image: url({{ "$image_info->directory/$image_info->local_filename" }});height: 300px;background-size: 100%;">
                                    @else 
                                        <div class="img" style="background-image:'https://drive.google.com/uc?export=view&id='.{{$image_info->drive_id}};height: 300px;background-size: 100%;">
                                    @endif       
                                @endif
                                <div class="card-header card-header-trip">
                                    <h5 class="card-title"><a href="{{route('singlePackage',['slug'=>$commitment->slug])}}"> {{__($commitment->title)}} ({{__($commitment->commence_date)}})</a></h5>
                                </div>
                            </div>
                        {{--
                        @if($images[0]!="")
                            <div class="d-flex justify-content-center"><img class="card-header card-img-top col-md-10 img-fluid" src="{{ $images[0] }}" alt="Package Image" style="height: 300px"></div>
                        @endif --}}
                            <div class="card-body py-2">
                                <?php
                                    $package_cost = $commitment->price_per_traveller;
                                    $total_paid=$commitment->total_paid;
                                    $total_travellers=$commitment->travellers;
                                    $total_remaining=$package_cost*$total_travellers - $total_paid;
                                    $total_cost= $package_cost*$total_travellers

                                ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><strong>{{ __('Package Cost') }}</strong><br/>NPR {{$package_cost}}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                            <label class="bmd-label-floating"><strong>{{ __('Total Paid') }}</strong><br/>NPR {{$total_paid}} </label>
                                            </div>
                                        </div>
                                    </div>
                                <div class="row">
                                    <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="bmd-label-floating"><strong>{{ __('Travellers') }}</strong><br/>{{$total_travellers}} People</label>
                                    </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                        <label class="bmd-label-floating"><strong>{{ __('Total Remaining') }}</strong><br/>NPR {{$total_remaining}} </label>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                    $commitInfo = \App\User::singleCommitInfo($commitment->id);
                                    $last_paid = \App\User::lastPaid($commitment->id);
                                    if(isset($last_paid)){
                                        $last_paid=$last_paid->due;
                                    }else{
                                        $last_paid=null;
                                    }
                                    $futureemi = \App\Packages::futureEMI($total_remaining,$last_paid, $commitInfo->commence_date);
                                ?>

                                    <div class="row">
                                        <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><strong>{{ __('Total Cost') }}</strong><br/>NPR {{$total_cost}} </label>
                                        </div>
                                        </div>
                                        @if($total_remaining>0)
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                <label class="bmd-label-floating"><strong>{{ __('Upcoming Due') }}</strong><br/>NPR  @if($total_remaining<$futureemi[0][1]){{ $total_remaining }} @else {{$futureemi[0][1]}} @endif @php echo "<br/><small>" .$commitment->next_pay_date. "</small>" @endphp</label>
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                <label class="text-success">{{ __('Payment Done') }} !</label>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    @if($commitment->status=='active')
                                    <div class="row justify-content-center ml-1 mt-3 mb-4" style="gap:10px;">
                                        {{-- <div class="form-group">
                                        <a href="{{route('myPayments')}}" class="btn btn-outline-dark" style="border-radius:50px">{{ __('Payments History') }}</a>
                                        </div> --}}

                                        @if(($total_remaining)>0)
                                            <div class="form-group">
                                                <a href="{{route('viewEMI',['id'=>$commitment->id])}}" class="btn btn-outline-dark" style="border-radius:50px">{{ __('EMI Structures') }}</a>
                                            </div>

                                            <div class="dropdown form-group">
                                                <button class="btn btn-outline-dark dropdown-toggle" style="border-radius:50px" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Payment Type
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <form action="{{route('postPayment')}}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="clickref" value="{{$commitment->commit_id}}"/>
                                                        {{-- @if($commitment->next_pay_date>date('Y-m-d'))
                                                        <input type="submit" class="dropdown-item" name="post[general]" value="{{ __('General Payment') }}"/>
                                                        @endif --}}
                                                        <input type="submit" class="dropdown-item" name="post[advance]" value="{{ __('Prepay Payment') }}"/>
                                                    </form>
                                                </div>
                                            </div>

                                        @endif
                                    </div>
                                @endif

                                @if($commitment->status=='cancelled')
                                <div>
                                    <div class="form-group">
                                    <label class="text-primary">Commitment Cancelled 10% of total collected amount is deducted i.e Rs.{{($commitment->total_paid/100)*10}}. Rs.{{$commitment->total_paid-($commitment->total_paid/100)*10}} is refunded.</label>
                                    </div>
                                </div>
                                @endif

                                @if($commitment->status=='completed')
                                    <div>
                                        <div class="form-group">
                                        <label class="text-success">{{ __('Trip Completed ') }}</label>
                                        </div>
                                    </div>
                                @endif

                                <?php $remaining_per = ($total_paid*100)/$total_cost ?>
                                <span>{{round($remaining_per)}}%</span>
                                <div class="progress mb-3">
                                    <div class="progress-bar bg-trip" role="progressbar" style="width: {{$remaining_per}}%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                  </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
              @else
                <div class="row pt-5 text-center">
                    <div class="col-lg-12"><h5 class="d-flex justify-content-center text-danger">* {{ __('No Commitments is Booked') }}</h5>
                        <a style="text-center" class="btn btn-primary px-4 py-2 mt-5" href="{{ route('packages') }}"> Explore Packages</a>
                    </div>
                </div>

              @endif
    </section>
</section>
@endsection





