@extends('croom.layouts.main')
@section('content')
<style type="text/css">
.deleteitem{
    display:none;
}
</style>
<form action="{{route('croom.hotels.add.save')}}" method="post" enctype="multipart/form-data">
@csrf
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">New Hotel</div>
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
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <input type="text" autocomplete="off" class="form-control" name="name" placeholder="Hotel Name" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <input type="text" autocomplete="off" class="form-control" name="description" placeholder="About" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <input type="text" autocomplete="off" class="form-control" name="inclusions" placeholder="Inclusions" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <input type="text" autocomplete="off" class="form-control" name="address" placeholder="Address" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <input type="text" autocomplete="off" class="form-control" name="star_ratings" placeholder="Star Rating (X out of 5)" required>
                            </div>
                        </div>
                        <hr>
                        Images<br/><br/>
                        <div class="row top_level">
                            <div class="col-md-4 clone_it" style="margin-bottom:10px;">
                                <div class="card border">
                                    <div class="card-header">
                                        Image #<span class="count">1</span>
                                        <small class="float-sm-right"><a href="" class="btn btn-danger btn-sm deleteitem">X</a></small>
                                    </div>
                                    <div class="card-body">
                                        <input type="file" name="hotel[image][1]" class="form-control" accept="image/png, image/jpeg" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <a class="btn btn-primary btn-lg cloner imgcloner" style="border-radius: 12px" href="javascript:void(0);">Add</a>
                            </div>
                        </div>
                        <br/><hr>
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

@section('page-title') Add New Hotel @endsection
