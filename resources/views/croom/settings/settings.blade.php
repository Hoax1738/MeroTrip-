@extends('croom.layouts.main')
@section('content')
    <div class="d-flex flex-row-reverse">
        <a href="{{ route('add-edit-settings')}}" class="float-right btn btn-success text-white " >Add New Setting <i class="me-2 mdi mdi-plus-circle"></i></a>
    </div>
    <div class="col-sm-12">
        @if(\Session::has('success'))
            <div class="alert alert-success">
                {{\Session::get('success')}}
            </div>
        @endif

        </div>

    <div class="row">
        @forelse ($settings as $setting)
            <div class="col-md-4 mt-5">
                <div class="card mb-4 shadow-sm">
                    @php $image=\App\Image::find($setting->value);@endphp
                    @if($image!=NULL)
                        @if($image->drive_id==NULL)
                            <img src="{{url("$image->directory/$image->local_filename")}}"  class="img-fluid" alt="package-image">
                        @else
                            <img src="https://drive.google.com/uc?export=view&id={{$image->drive_id}}"  class="img-fluid" alt="package-image">
                        @endif    
                    @endif    
                    <div class="card-body">
                        <p class="card-text"> {{$setting['name']}}</p>
                        <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                            <a type="button" class="btn btn-sm btn-outline-secondary" href="{{route('add-edit-settings',['id'=>$setting['id']])}}">Edit</a>
                        </div>
                        <small class="text-muted">{{$setting['name']}}</small>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p>No Settings Found</p>
        @endforelse
    </div>
@endsection

@section('page-title') Settings @endsection
