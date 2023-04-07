@extends('croom.layouts.main')
@section('content')
<div class="container py-5">
    @if($err!="")
        <div class="alert alert-danger"> {{ $err }}</div>
    @endif    
    <div class="row">
        <div class="col-md-4">
            <div class="alert bg-light">
                <p class="py-2">Price Per Person</p>
                <h3>Rs {{ $item[0]['price'] }} </h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="alert bg-light">
                <p class="py-2">Available seats</p>
                <h3>{{ $available_slots }}</h3>
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
            <form action="" id="paymentForm" method="POST">
                @csrf
                <input type="hidden" name="clickref" value="{{$item[0]['id']}}"/>
                <input type="hidden" name="user_id" value="{{ $user_id }}"/>
                <input type="hidden" name="commence_date" value="{{$commence_date}}"/>
                <input type="hidden" name="package_id" value="{{$package_id}}"/>
            
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                            <label for="downAmount">Down Payment</label>
                            <input type="number" name="down" value="{{ $down }}" class="form-control" id="amount" aria-describedby="amountHelp" placeholder="Enter Amount">
                            <small id="amountHelp" class="form-text text-muted">The Amount you will pay at the start.</small>
                        </div>
                        <div class="col-md-5">
                            <label for="exampleInputPassword1">No. Of Travellers</label>
                            <input type="number" name="travellers" class="form-control" value="{{ $travellers }}" placeholder="No. of Travellers">
                        </div>
                        <div class="col-md-2 py-4">
                            <input type="submit" class="btn btn-primary" value="Revise EMI"/>
                        </div>
                    </div>
                </div>
            </form>
        </div>
      
        <div class="section-top-border">
            <h3 class="mb-30 title_color">Estimated Payments for {{$travellers}} Traveller<?=($travellers>1)?"s":"";?></h3>
            <div class="row py-3">
                <?php $sn=1 ?>
                @foreach($emi as $i)
                    @if($i[1]>0)
        
                <div class="col-md-4 col-12">
                    <div class="card border mx-2">
                        <div class="card-header">
                            Date: {{$i[0]}} 
                        </div>
                        <div class="card-body">
                            <h4 class="card-title">EMI Payment {{$sn++}}</h4>
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


        <form method="POST">
            @csrf
          <input type="hidden" name="submitClick" value="btn">
          <input type="hidden" name="clickref" value="{{$item[0]['id']}}"/>
          <input type="hidden" name="user_id" value="{{ $user_id }}"/>
          <input type="hidden" name="commence_date" value="{{$commence_date}}"/>
          <input type="hidden" name="package_id" value="{{$package_id}}"/>
          <input type="hidden" name="down" value="{{ $down }}">
          <input type="hidden" name="travellers" value="{{ $travellers }}" >
          <input type="submit" value="Book" class="btn btn-primary mx-2 mb-2" >
        </form>    

    </div>
</div>

@endsection
