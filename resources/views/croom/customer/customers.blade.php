@extends('croom.layouts.main')
@section('content')

<div class="table-responsive">
  <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">S.N</th>
          <th scope="col">Name</th>
          <th scope="col">Email</th>
          <th scope="col">Commitments</th>
          <th scope="col">Payments</th>

        </tr>
      </thead>
      <tbody>
          <?php $sn=1; ?>
          @forelse($allCustomers as $allCustomer)
          <tr>
              <th scope="row">{{$sn++}}</th>
              <td>{{$allCustomer->name}}</td>
              <td>{{$allCustomer->email}}</td>
              <td><a  href="{{route('commit',['id'=>$allCustomer['id']])}}"><i class="fas fa-eye"></i></a></td>
              <td><a class=" btn btn-primary" href="{{route('payment',['id'=>$allCustomer['id']])}}">View Payments</a></td>

          </tr>
          @empty
          <tr>
              <td>No Customer Found</td>
          </tr>
          @endforelse
      </tbody>
    </table>
  </div>  

@endsection

@section('page-title') Customers @endsection

