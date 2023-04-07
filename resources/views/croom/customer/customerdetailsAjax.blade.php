@extends('croom.layouts.main')
@section('content')
<div x-data>
<table class="table">
  <div class="alert alert-success" style="display:none"></div>
    <thead class="thead-dark">
      <tr>
        <th scope="col">S.N</th>
        <th scope="col">Trip Name</th>
        <th scope="col">Commence Date</th>
        <th scope="col">Total Cost</th>
        <th scope="col">Total Paid</th>
        <th scope="col">Total Remaing</th>
        <th scope="col">Next Pay Date</th>
        <th scope="col">Future EMI</th>
        <th scope="col">Action </th>

      </tr>
    </thead>
    <tbody>
        <?php $sn=1; ?>
    @forelse ($customerInfo as $info )
        <tr>
            <th scope="row">{{$sn++}}</th>
            <td><a href="{{route('singlePackage',['slug'=>$info->slug])}}" target="_blank">{{$info->title}}</a></td>
            <td>{{$info->commence_date}}</td>
            <td>{{$info->price_per_traveller*$info->travellers}}</td>
            <td>{{$info->total_paid}}</td>
            <td>{{$info->price_per_traveller*$info->travellers - $info->total_paid}}</td>
            <td>{{$info->next_pay_date}}</td>
            <td><a href="{{url('/customer_emi',['c_id'=>$info->id])}}" class=" btn btn-primary">Future EMI</a></td>
            <td><button x-on:click="$refs.cid.value='<?php echo $info->id;?>'" class="btn btn-success" data-toggle="modal" data-target="#emiModal" id="open">Update General EMI</button></td>

        </tr>
    @empty
            <td colspan="7" style="text-align:center;">No Commits Found</td>
    @endforelse

    </tbody>
  </table>


  <div class="modal" id="emiModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="alert alert-danger" style="display:none"></div>
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">EMI Update</h5>
          <button type="button" class="btn btn-danger text-white close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ route('updateGeneralEmi') }}">
            @csrf
            <input type="hidden" name="commit_id" x-ref="cid" > 
            <input type="hidden" name="post" id="post" value="general">
            <input type="hidden" name="customer_id" value="{{ Request::route('id') }}">


            <div class="form-group">
              <label for="amount" class="col-form-label">Amount:</label>
              <input type="number" name="amount" class="form-control" id="amount" value=200>
            </div>
            <div class="form-group">
              <label for="message-text" class="col-form-label">Payment Type:</label>
              <select class="form-control" name="method" id="method">
                  <option value="">Select Payment</option>
                  <option  value="cash">Cash</option>
                  <option value="cheque">Cheque</option>
                  <option value="bank_transfer">Bank Transfer</option>
              </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button class="btn btn-primary" id="ajaxSubmit">Update EMI </button>
              </div>
          </form>
        </div>

      </div>
    </div>
  </div>
        

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  {{-- <script>
    $('#emiModal').on('show.bs.modal', function (event) {
        console.log('Model Opened');
  var button = $(event.relatedTarget)
  var commit_id = button.data('commitId')
  var next_pay = button.data('nextPay')
  var modal = $(this)
  modal.find('.modal-body #commit_id').val(commit_id)
  modal.find('.modal-body #next_pay').val(next_pay)
})
  </script> --}}


  <script>


jQuery(document).ready(function(){
            jQuery('#ajaxSubmit').click(function(e){
               e.preventDefault();
               $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
               jQuery.ajax({
                  url: "{{ url('/updateGeneralEmi') }}",
                  method: 'post',
                  data: {
                     amount: jQuery('#amount').val(),
                     method: jQuery('#method').val(),
                     
                  },
                  success: function(result){
                  	if(result.errors)
                  	{
                  		jQuery('.alert-danger').html('');

                  		jQuery.each(result.errors, function(key, value){
                  			jQuery('.alert-danger').show();
                  			jQuery('.alert-danger').append('<li>'+value+'</li>');
                  		});
                  	}
                  	else
                  	{
                  		jQuery('.alert-danger').hide();
                      jQuery('.alert-success').html('');
                  		jQuery('.alert-success').show();
                  		jQuery('.alert-success').append('<li>Nepal</li>');
                      $('.close').click();
                      
                  	}
                  }});
               });
            });

  </script>

</div>



@endsection

@section('page-title') {{$customer->name}} Commits @endsection
