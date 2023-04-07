@extends('croom.layouts.main')
@section('content')
<div class="col-sm-12">
    @if(\Session::has('success'))
        <div class="alert alert-success">
            {{\Session::get('success')}}
        </div>
    @endif
</div>
<div x-data>
  <div class="table-responsive">
    <table class="table">
      <div class="alert alert-success" style="display:none"></div>
        <thead class="thead-dark">
          <tr>
            <th scope="col">S.N</th>
            <th scope="col">Trip Name</th>
            <th scope="col">Commence Date</th>
            <th scope="col">Cost</th>
            <th scope="col">Paid</th>
            <th scope="col">Remaing</th>
            <th scope="col">Next Pay Date</th>
            <th scope="col">Future EMI</th>
            <th scope="col">Update EMI </th>

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

                @if($info->status =='active')
                    <td>{{$info->next_pay_date}}</td>
                    <td><a title="View Future EMI" href="{{url('/customer_emi/'.$info->id . '/' . $customer->id)}}" class=" btn btn-primary"><i class="fas fa-eye"></i> EMI</a></td>
                    <td><button x-on:click="$refs.cid.value='<?php echo $info->id;?>'" class="btn btn-success" data-toggle="modal" data-target="#emiModal"><i class="fas fa-edit"></i></button></td>
                    <td>
                        @if($info->commence_date>=Carbon\Carbon::now())
                        <a href="{{url('/cancel',['c_id'=>$info->id])}}" onclick="return checkCancel()" class="btn btn-danger">Cancel</a>
                        @endif
                        @if($info->commence_date<=Carbon\Carbon::now() && $info->status== 'active')
                        <a href="{{url('/completed',['c_id'=>$info->id])}}" onclick="return checkComplete()" class="btn btn-success">Conclude</a>
                        @endif
                    </td>
                @endif


                @if(($info->price_per_traveller*$info->travellers - $info->total_paid)<=0)
                <td  colspan="1"  style="text-align:center;">Payment Completed</td>
                @endif

                @if($info->status == 'completed')
                <td colspan="3" class="text-success" style="text-align:center;">Trip Completed</td>
                @endif

                @if($info->status == 'cancelled')
                <td colspan="3" class="text-danger" style="text-align:center;">Cancelled Rs.{{($info->total_paid/100)*10}} deducted. Refundable amount Rs.{{$info->total_paid-($info->total_paid/100)*10}}</td>
                @endif


            </tr>
        @empty
                <td colspan="9" style="text-align:center;">No Commits Found</td>
        @endforelse

        </tbody>
      </table>
  </div>


  <div class="modal fade" id="emiModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
          <form method="POST" action="{{ route('updateGeneralEmi') }}" id="frm">
            @csrf
            <input type="hidden" name="commit_id" x-ref="cid">
            <input type="hidden" name="post" id="post" value="general">
            <input type="hidden" name="customer_id" value="{{ Request::route('id') }}">


            <div class="form-group">
              <label for="amount" class="col-form-label">Amount:</label>
              <input type="number" name="amount" class="form-control" id="amount">
            </div>
            <div class="form-group">
              <label for="message-text" class="col-form-label">Payment Type:</label>
              <select class="form-control" name="method">
                  <option  value="">Select Payment</option>
                  <option  value="cash">Cash</option>
                  <option value="cheque">Cheque</option>
                  <option value="bank_transfer">Bank Transfer</option>
              </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update EMI </button>
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

  <script language="JavaScript" type="text/javascript">
    function checkCancel(){
        return confirm('Are you sure you want to cancel this commit?');
    }
    </script>

<script language="JavaScript" type="text/javascript">
    function checkComplete(){
        return confirm('Are you sure you want to conclude this commit?');
    }
    </script>

 <script>

   jQuery('#frm').submit(function(e){
     e.preventDefault();
     jQuery.ajax({
       url:'{{ url('/updateGeneralEmi') }}',
       data:jQuery('#frm').serialize(),
       type:'post',
       success:function(result){
        if(result.errors){
          jQuery('.alert-danger').html('');
          jQuery.each(result.errors, function(key, value){
            jQuery('.alert-danger').show();
            jQuery('.alert-danger').append('<li>'+value+'</li>');
          });
        }else if(result.success){
          jQuery('.alert-danger').hide();
          $('.close').click();
          jQuery('.alert-success').show();
          jQuery('.alert-success').append('<li>'+result.success+'</li>');

        }else if(result.paid){
            jQuery('.alert-danger').html('');
            jQuery('.alert-danger').show();
            jQuery('.alert-danger').append('<li>'+result.paid+'</li>');
        }else{
            jQuery('.alert-danger').html('');
            jQuery('.alert-danger').show();
            jQuery('.alert-danger').append('<li>'+result.err+'</li>');
        }
       }
     });
   });

   $('.close').click(function() {
    jQuery('.alert-danger').hide();
    jQuery('#frm')[0].reset();
});

 </script>

</div>



@endsection

@section('page-title') {{$customer->name}} Commitments @endsection
