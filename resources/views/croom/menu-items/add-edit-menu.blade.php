@extends('croom.layouts.main')
@section('content')
    <form  @if(empty($menu['id'])) action="{{url('add-edit-menu')}}" @else action="{{url('add-edit-menu/'.$menu['id'])}}" @endif method="post" enctype="multipart/form-data">
    @csrf
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{$title}}</div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <input type="text" autocomplete="off" class="form-control" name="title" placeholder="Title" required
                                @if(!empty($menu['title'])) value="{{($menu['title'])}}" @else value="{{old('tittle')}}" @endif>
                            </div>
                            @error('title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <input type="text" autocomplete="off" class="form-control" name="position" placeholder="Position" required
                                @if(!empty($menu['position'])) value="{{($menu['position'])}}" @else value="{{old('position')}}" @endif>
                            </div>
                            @error('position')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12">
                                <input type="text" autocomplete="off" class="form-control" name="href" placeholder="Link" required
                                @if(!empty($menu['href'])) value="{{($menu['href'])}}" @else value="{{old('href')}}" @endif>
                            </div>
                            @error('href')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>


                        <div class="form-group row">
                            <div class="col-sm-12">
                                <input type="text" autocomplete="off" class="form-control" name="icon" placeholder="Font awesome icon" required
                                @if(!empty($menu['icon'])) value="{{($menu['icon'])}}" @else value="{{old('icon')}}" @endif>
                            </div>
                            @error('href')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror

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

@endsection

@section('page-title') {{$title}} @endsection
