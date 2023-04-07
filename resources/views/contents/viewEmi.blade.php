@extends('layouts.frontend.app')
@section('content')

<section class="content">
        <section class="ftco-section">
            <div class="container">
                @if (Auth::check())
                @include('contents.emiAlert')
                @endif
                <div class="row justify-content-center pb-4">
                    <div class="col-md-6 heading-section text-center ftco-animate">
                        <?php
                            $commitsData=DB::table('commits')
                                    ->where('id',$commitment_id)
                                    ->first();

                            $commenceData=DB::table('commence_dates')
                                        ->where('id',$commitsData->commence_date_id)
                                        ->first();

                            $packageData=DB::table('packages')
                                        ->where('id',$commenceData->package_id)
                                        ->get();

                            $commenceDateInfo=\App\Packages::cleanToArr($packageData);

                         ?>
                        <h2 class="mb-2">Payment Structure<br> {{$commenceDateInfo[0]['title']}}</h2>
                    </div>
                </div>
                <div>
                    {{-- <div class="col-sm-12 col-md-12 col-lg-12 ">
                    @if($item->travellers>1)
                    <h5 class="mb-2">Cost per traveller: NPR {{$item->price_per_traveller}}</h5>
                    <h5 class="mb-2">Travellers: {{$item->travellers}}</h5>
                    @endif
                    <h5 class="mb-2">Total cost: NPR {{$item->price_per_traveller*$item->travellers}}</h5>
                    <h5 class="mb-2">Total paid: NPR {{$item->total_paid}}</h5>
                    <h5 class="mb-2">Trip duration: {{$commenceDateInfo[0]['duration']}} days</h5>
                    <h5 class="mb-2">Trip destination: {{$commenceDateInfo[0]['destination']}}</h5>
                    </div> --}}

                    <table class="table table-bordered">
                        <thead>
                          <tr>
                            @if($item->travellers>1)
                                <th scope="col">Cost Per Traveller</th>
                                <th scope="col">Travellers</th>
                            @endif    
                            <th scope="col">Total Cost</th>
                            <th scope="col">Total Paid</th>
                            <th scope="col">Total Duration</th>
                            <th scope="col">Trip Destination</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            @if($item->travellers>1)
                                <th scope="row">NPR {{$item->price_per_traveller}}</th>
                                <td>{{$item->travellers}}</td>
                            @endif    
                            <td>NPR {{$item->price_per_traveller*$item->travellers}}</td>
                            <td>NPR {{$item->total_paid}}</td>
                            <td>{{$commenceDateInfo[0]['duration']}} days</td>
                            <td>{{$commenceDateInfo[0]['destination']}}</td>
                          </tr>
                        </tbody>
                    </table>
                </div>
                <div class="text-center mt-4 display-5">
                <b>Estimated Payments</b>
                </div>
                <div class="row py-3">
                    <?php $sn=1;?>
                    @foreach($emi as $i)
                        @if($i[1]!='0')
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
                                    {{-- <div class="card-footer">
                                        <div class="stats w-100">
                                            <button class="btn btn">Pending</button>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
</section>
@endsection

