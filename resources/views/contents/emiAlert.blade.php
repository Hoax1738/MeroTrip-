
<?php $user_commitments = \App\User::myCommitments();?>
@foreach ($user_commitments as $commitment )
<?php
    $commitInfo = \App\User::singleCommitInfo($commitment->id);
    $last_paid = \App\User::lastPaid($commitment->id);
    $remaining=$commitment->price_per_traveller*$commitment->travellers - $commitment->total_paid;
    if(isset($last_paid)){
        $last_paid=$last_paid->due;
    }else{
        $last_paid=null;
    }
    $futureemi = \App\Packages::futureEMI($remaining,$last_paid, $commitInfo->commence_date);
    $next_pay_date =$commitment->next_pay_date;
    $date = date('Y-m-d');

    $exp = strtotime($next_pay_date);
    $td= strtotime($date);
    $diff=$exp-$td;
    $due_date=floor($diff/(60*60*24));
?>


@if($commitment->status=='active' && $remaining!=0 && $due_date<=7 )
    <div class="alert @if($due_date>=3) alert-primary @elseif($due_date>=1) alert-warning @else alert-danger @endif" role="alert">
        <form action="{{route('postPayment')}}" method="post"> @csrf
         Your {{$commitment->title}} is expecting monthly payment of NRP {{$futureemi[0][1]}}, due by {{ date("M j, Y",strtotime($next_pay_date)) }}
        <input type="hidden" name="clickref" value="{{$commitment->commit_id}}"/>
        <input style="float: right" type="submit" class="btn btn-success py-1"  name="post[advance]" value="{{ __('Pay Now ') }}"/>
        </form>
    </div>
@endif
@endforeach




