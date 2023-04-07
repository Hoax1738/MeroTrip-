@extends('croom.layouts.main')
@section('content')
<form method="POST" action="{{ route('bookFirst') }}">
@csrf
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Book Package</div>
                    <div class="card-body">
                        <div class="col-sm-12">
                        @if(\Session::has('success'))
                            <div class="alert alert-success">
                                {{\Session::get('success')}}
                            </div>
                        @endif
                        @if(\Session::has('fail'))
                            <div class="alert alert-danger">
                                {{\Session::get('fail')}}
                            </div>
                        @endif
                        </div>

                        <input type="hidden" name="package_id" id="p_id"> 
                        
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <select class="form-control" name="user_id" required>
                                    <option value="">Select User...</option>
                                    @foreach($users as $row)
                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                    @endforeach
                                </select>    
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <select class="form-control" name="package_slug" id="p_slug" required>
                                    <option value="">Select Package...</option>
                                    @foreach($packages as $row)
                                        <option value="{{ $row->slug }}">{{ $row->title }}</option>
                                    @endforeach
                                </select>    
                            </div>
                        </div>

                        <div class="form-group row" style="display:none" id="c_date">
                            <div class="col-sm-12">
                                <select class="form-control" name="commence_date" id="add">
                                </select>    
                            </div>
                        </div>
                        
                    
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <input class="btn btn-success text-white btn-lg" style="border-radius: 12px; display:none" value="Save" type="submit" id="submit"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

<script>    
    jQuery('#p_slug').on('change', function(){   
        if($('#p_slug').val()==""){
            $('#c_date').css('display','none');
        }else{
            jQuery.ajax({
                url: "{{ url('/getSlug') }}",
                method: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    slug: $(this).val(),
                },
                success: function(result){
                    $('#add').empty();       
                    jQuery.each(result.data['commence_dates'], function(key, value){
                        if(value['commence_date']>='<?php echo date('Y-m-d');?>'){ 
                            $('#c_date').css('display','block');
                            $('#submit').show();
                            $('#add').append($('<option>',
                            {
                                value: value['commence_date'],
                                text: value['commence_date']
                            }));
                        }else{
                            $('#c_date').css('display','none');
                            $('#submit').hide();
                        
                        }
                       
                        }); 
                        $('#p_id').val(result.data['id']);   
                    }
                });
            }
    });

</script>

@endsection

@section('page-title') Make Bookings @endsection
