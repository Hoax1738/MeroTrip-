@extends('croom.layouts.main')
@section('content')
<div class="d-flex flex-row-reverse">
    <a href="{{ route('croom.hotels.add')}}" class="float-right btn btn-success text-white " >Add New Hotel <i class="me-2 mdi mdi-plus-circle"></i></a>
</div>

<div class="row">
    @forelse ($items as $hotel)
        <div class="col-md-4 mt-5">
            <div class="card mb-4 shadow-sm">
                @php 
                    $hotel_img=explode(',',$hotel['images']); 
                    $images=\App\Image::find($hotel_img[0]);
                @endphp
                @if($images!=NULL)
                    @if($images->drive_id==NULL)
                        <img src="{{url("$images->directory/$images->local_filename")}}" class="img-fluid" alt="package-image" style="height: 200px">
                    @else
                        <img src="https://drive.google.com/uc?export=view&id={{$images->drive_id}}" class="img-fluid" alt="package-image" style="height: 200px">
                    @endif    
                @endif  
                <div class="card-body">
                    <small class="text-muted">{{$hotel['name']}}</small>
                    <small class="text-muted">{{$hotel['star_ratings']}}</small>
                    <div class="d-flex justify-content-between align-items-center">
                    <p class="card-text"> {{$hotel['description']}}</p>
                    <small class="text-muted">{{$hotel['inclusions']}}</small>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <p>No Hotels Found</p>
    @endforelse
</div>
@endsection

@section('page-title') Hotels @endsection
