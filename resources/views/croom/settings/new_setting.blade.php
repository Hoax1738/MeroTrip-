@extends('croom.layouts.main')
@section('content')
    <form  @if(empty($setting['id'])) action="{{url('add-edit-settings')}}" @else action="{{url('add-edit-settings/'.$setting['id'])}}" @endif method="post" enctype="multipart/form-data">
    @csrf
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{$title}}</div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <input type="text" autocomplete="off" class="form-control" name="name" placeholder="Setting name" required
                                @if(!empty($setting['name'])) value="{{($setting['name'])}}" @else value="{{old('name')}}" @endif>
                            </div>
                            @error('name')
                                 <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <hr>
                        Image<br/><br/>
                        <div class="row top_level">
                            <div class="col-md-4 clone_it" style="margin-bottom:10px;">
                                <div class="card border">
                                    <div class="card-header">
                                        Image #
                                    </div>
                                    <div class="card-body">
                                        <input type="file" name="value" class="form-control" accept="image/png, image/jpeg, image/jpg" required  value="{{$setting->value}}">
                                        {{-- @if(!empty($setting->value))
                                        <img class="" style="width:50px;" src="{{asset('/images/'.$setting->value)}}">
                                        @endif --}}
                                        @error('value')
                                        <span class="text-danger">{{ $message }}</span>
                                         @enderror
                                    </div>

                                </div>
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

@section('page-title') {{$title}} @endsection
