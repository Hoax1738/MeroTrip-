@extends('croom.layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    You are logged in!
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">Total EMI Collected</div>
                    <div class="card-body">
                        Rs.{{$total_collected_emi}}
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">EMI Collected Today</div>
                    <div class="card-body">
                        Rs.{{$today_collected_emi}}
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">Delayed EMIs </div>
                    <div class="card-body">
                        Rs.0
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">EMI Need To be Collected </div>
                    <div class="card-body">
                        Rs.0
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">Cancelled Commitments </div>
                    <div class="card-body">
                        {{$cancelled_emi}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-title') Dashboard @endsection

