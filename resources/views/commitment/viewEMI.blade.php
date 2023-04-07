@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">EMI</div>
                <div class="card-body">
                    @if($item->travellers>1)
                    Cost per traveller: NPR {{$item->price_per_traveller}}<br/>
                    @endif
                    Total Cost: NPR {{$item->price_per_traveller*$item->travellers}}<br/>
                    Total Paid: NPR {{$item->total_paid}}<br/><br/>
                    <strong>Estimated Payments</strong>
                    <?php
                    $per_row = (count($emi)>6)?6:count($emi);
                    ?>
                    <div class="row">
                    @foreach($emi as $i)
                        <div class="col-{{intval(12/$per_row)}}" style="margin-top:20px;">
                            <div class="card">
                                <div class="card-header">
                                {{$i[0]}}
                                </div>
                                <div class="card-body">
                                NPR {{$i[1]}}
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection