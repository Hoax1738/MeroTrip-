@extends('croom.layouts.main')
@section('content')
    <div class="d-flex flex-row-reverse">
        <a href="{{ route('croom.packages.new')}}" class="float-right btn btn-success text-white " >Add New Packages <i class="me-2 mdi mdi-plus-circle"></i></a>
    </div>    

    <div class="row">
        @forelse ($items as $package)
            <div class="col-md-4 mt-5">
                <div class="card mb-4 shadow-sm">
                    <?php
                        $img_data=explode(',',$package['images']);
                        $images=\App\Image::find($img_data[0]);
                    ?>
                    @if($images!=NULL)
                        @if($images->drive_id==NULL)
                            <img src="{{ url("$images->directory/$images->local_filename")}}" class="img-fluid" alt="package-image" style="height: 300px">
                        @else
                            <img src="https://drive.google.com/uc?export=view&id={{$images->drive_id}}" class="img-fluid" alt="package-image" style="height: 300px">
                        @endif 
                    @endif       
                    <div class="card-body">
                        <p class="card-text"> {{$package['title']}}</p>
                        <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                            <a type="button" class="btn btn-sm btn-outline-secondary" href="{{route('singlePackage',['slug'=>$package['slug']])}}">View</a>
                            <a type="button" class="btn btn-sm btn-outline-secondary" href="{{route('croom.packages.edit',['id'=>$package['id']])}}">Edit</a>
                        </div>
                        <small class="text-muted">{{$package['duration']}} Days</small>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p>No Packages Found</p>
        @endforelse    
    </div>
@endsection

@section('page-title') Our Packages @endsection
