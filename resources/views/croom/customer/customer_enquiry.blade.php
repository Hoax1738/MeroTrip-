@extends('croom.layouts.main')
@section('content')

<div class="table-responsive">
  <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">S.N</th>
          <th scope="col">Customer Name</th>
          <th scope="col">Email</th>
          <th scope="col">Subject </th>
          <th scope="col">Message</th>
          <th scope="col">Action</th>


        </tr>
      </thead>
      <tbody>
          <?php $sn=1; ?>
          @forelse($enquiries as $enquiry)
          <tr>
              <th scope="row">{{$sn++}}</th>
              <td>{{$enquiry->username}}</td>
              <td>{{$enquiry->email}}</td>
              <td>{{$enquiry->subject}}</td>
              <td>{{$enquiry->message}}</td>
              <td><a href = "mailto: {{$enquiry->email}}" data-toggle="tooltip" title="Reply To {{$enquiry->username}} "><i class="fas fa-reply-all"></i></a></td>
          </tr>
          @empty
          <td colspan="5" style="text-align:center;">No Enquiry Found</td>
          @endforelse
      </tbody>
    </table>
</div>

@endsection

@section('page-title') Enquiries @endsection

