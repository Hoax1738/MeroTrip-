@extends('croom.layouts.main')
@section('content')
<style type="text/css">
.deleteitem{
    display:none;
}
</style>
<form action="{{url('/adminupdatepassword')}}" enctype="multipart/form-data" method="POST"  id="change_password_form">@csrf
@csrf
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Update Admin Password </div>
                    <div class="card-body">
                        <div class="col-sm-12">
                            @if(session('success'))
                            <div class="alert alert-success alert-dismissible justify-content-center">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>{{__(session('success'))}}</strong>
                            </div>
                        @endif
                        @if(session('error'))
                        <div class="alert alert-danger alert-dismissible justify-content-center">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>{{__(session('error'))}}</strong>
                        </div>
                        @endif
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <input type="password" autocomplete="off" class="form-control"  name="old_password"  id="old_password" placeholder="Enter old password">
                                @if($errors->any('old_password'))
                                <span class="text-danger">{{$errors->first('old_password')}}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <input type="text" autocomplete="off" class="form-control" name="new_password" placeholder="Enter New Password"  id="new_password">
                                @if($errors->any('new_password'))
                                <span class="text-danger">{{$errors->first('new_password')}}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <input type="text" autocomplete="off" class="form-control" name="confirm_password" placeholder="Confirm Password" id="confirm_password">
                                @if($errors->any('confirm_password'))
                                <span class="text-danger">{{$errors->first('confirm_password')}}</span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col-sm-12">
                                <input class="btn btn-success text-white btn-lg" style="border-radius: 12px" value="Save" type="submit"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="{{url('old/js/admin.js')}}" type="text/javascript"></script>
@endsection

@section('page-title') Update Password @endsection
