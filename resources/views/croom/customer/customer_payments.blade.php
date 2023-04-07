@extends('croom.layouts.main')
@section('content')
<div x-data="{display:false}">
  <div class="d-flex justify-content-end mb-2"><a href="#" x-on:click="!display?display=true:display=false">Advance Search</a></div>
  <div x-show="display">
    <form method="POST" action="{{ route('payment',['id'=>$id]) }}">
      @csrf
      <div class="container-fluid bg-white">
      <div class="row pt-4 ">
        <div class="col-lg-6">
          <label for="inputEmail4">Package Title</label>
          <select class="form-control" name="title">
              <option value="">Choose Title..</option>
              @foreach($title as $row)
              <option value="{{ $row->title }}" <?=$setValue['title'] == $row->title ? ' selected="selected"' : '';?> >{{ $row->title }}</option>
              @endforeach
          </select>
        </div>
        <div class="col-lg-6">
          <label for="inputEmail4">Payment Method</label>
          <select class="form-control" name="method">
            <option value="">Choose Method..</option>
            @foreach($method as $row)
            <option value="{{ $row->method }}" <?=$setValue['method'] == $row->method ? ' selected="selected"' : '';?> >{{ $row->method }}</option>
            @endforeach
          </select>
        </div>
      </div>


      <div class="row mt-2">
        <div class="col-lg-6">
          <label for="inputEmail4">Payment Type</label>
          <select class="form-control" name="type">
            <option value="">Choose Type..</option>
            @foreach($type as $row)
            <option value="{{ $row->type }}" <?=$setValue['type'] == $row->type ? ' selected="selected"' : '';?> >{{ $row->type }}</option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="row mt-3 pb-5">
        <div class="col-lg-3">
          <button type="submit" class="btn btn-primary">Search</button>
        </div>
      </div>

    </div>
    </form>
  </div>
</div>

<div class="table-responsive">
  <table class="table table-hover">
      <thead class="text-primary">
        <th>
          ID
        </th>
        <th>
          Package Title
        </th>
        <th>
          Commence Date
        </th>
        <th>
          Payment Type
        </th>
        <th>
          Payment Method
        </th>
        <th>No of Travellers</th>
        <th>
          Amount
        </th>
      </thead>
      <tbody>
          @forelse ($payments as $payment)
        <tr>
          <td>
              {{$sn++}}
          </td>
          <td>
              {{$payment->package_title}}

          </td>
          <td>
              {{$payment->commence_date}}
          </td>
          <td>
              <a href="#"  title="@if(str_replace("_"," ",$payment->type)=='installment') Next Pay Date : {{$payment->next_pay_date}} Paid For: @else Paid Date: @endif {{$payment->due}}">{{str_replace("_"," ",$payment->type)}}</a>
          </td>
          <td>
              {{$payment->method}}
          </td>

          <td>
            {{$payment->travellers}}
        </td>


          <td class="text-primary">
              {{$payment->amount}}</
          </td>
        </tr>
        @empty
        <td colspan="7" style="text-align:center;">No Payments Found</td>
        @endforelse

      </tbody>
    </table>
  </div>

  {{ $payments->appends(Request::except('_token'))->links()}}

@endsection
@section('page-title'){{$customer->name}} Payment History @endsection

