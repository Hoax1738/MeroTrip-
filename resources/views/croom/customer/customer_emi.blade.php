@extends('croom.layouts.main')
@section('content')

  @if($item->travellers>1)
  <h5 class="mb-2">Cost per traveller: NPR {{$item->price_per_traveller}}</h5>
  <h5 class="mb-2">Traveller: {{$item->travellers}}</h5>

  @endif
  <h5 class="mb-2">Total Cost: NPR {{$item->price_per_traveller*$item->travellers}}</h5>
  <h5 class="mb-2">Total Paid: NPR {{$item->total_paid}}</h5>
  <b>Estimated Payments</b>
  <table class="table">
      <thead>
        <tr>
          <th scope="col">S.N</th>
          <th scope="col">Name</th>
          <th scope="col">Date</th>
          <th scope="col">Amount</th>
          {{-- <th scope="col">Status</th> --}}

        </tr>
      </thead>
      <tbody>
          <?php $sn=1;  $sum=0;?>
          @forelse($emi as $i)
          @if($i[1]!='0')
            <?php $sum=$sum+ $i[1]?>
          <tr>
              <th scope="row">{{$sn++}}</th>
              <th scope="row">{{$item->title}}</th>
              <td>{{$i[0]}}</td>
              <td>NPR {{$i[1]}}</td>  
              {{-- <td>@if($i[1]==0) Paid @else Unpaid @endif</td> --}}
          </tr>
          @endif
          @empty
            <span class="text-danger">No records Found</span>
        @endforelse
      </tbody>
    </table>
    <div class="d-flex justify-content-end mx-5"><b class="text mx-5">Total Remaining: {{ $sum }}</b></div>
@endsection
@section('page-title')Future EMI @endsection
