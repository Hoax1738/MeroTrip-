@extends('layouts.frontend.app')
@section('title') {{ __('My WishList - Tripkhata®') }} @endsection
@section('content')
{{-- @include('layouts.frontend.breadcrumb') --}}
<section class="content">
    <section class="ftco-section">
        <div class="container">
            @if (Auth::check())
                @include('contents.emiAlert')
                @else
            @endif
            @if(session('success_message'))
            <div class="alert alert-success alert-dismissible justify-content-center">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>{{session('success_message')}}</strong>
            </div>
            @endif
            <div class="row justify-content-center pb-4">
                <div class="col-md-12 heading-section text-center ftco-animate">
                    <h2 class="mb-4">My WishList Trip</h2>
                </div>
            </div>

            @if(count($items)>0)
                <div class="row">
                    @foreach($items as $package)
                        <div class="col-md-4 ftco-animate">
                            <div class="project-wrap">
                                <a href="{{route('singlePackage',['slug'=>$package->slug])}}" class="img">
                                    <?php $images=explode(",",$package->images); $image_info=\App\Image::find($images[0]);?>
                                    @if($image_info!=NULL)
                                        <img class="img" @if($image_info->drive_id==NULL) src="{{url("$image_info->directory/$image_info->local_filename")}}" @else src="https://drive.google.com/uc?export=view&id={{$image_info->drive_id}}" @endif alt="">
                                    @endif    
                                    <span class="price">{{($package->duration)}} {{ __('Days') }}</span>
                                </a>
                                <span class="wishlist-btn">
                                    <a href="{{ url('/saveWishList',['id'=>$package->id,'status'=>'stored']) }}">
                                        <i class="fa fa-heart"  style="background: #FFF;padding: 10px;margin-right: 5px;border-radius: 50% !important; color:red;"></i>
                                    </a>
                                </span>
                                <div class="text p-4">
                                    <h3><a href="{{route('singlePackage',['slug'=>$package->slug])}}">{{__($package->title)}}</a></h3>
                                    <span class="destination"> <i class="fa fa-map-marker"></i> {{__($package->destination)}}</span>
                                    <span  style="border-right:1px solid #D3D3D3; margin: 3px;"> </span>
                                        <?php
                                        $tags=explode(",",$package->tags)
                                        ;?>
                                        @foreach($tags as $tag)
                                        <span class="tags">
                                                {{ ucfirst($tag) }}
                                        </span>
                                        <span  style="border-right:1px solid #D3D3D3; margin: 3px;"> </span>
                                    @endforeach

                                    </div>
                            </div>
                        </div>
                    @endforeach
                </div>
             @else
                <div class="row"><div class="col-lg-12"><h5 class="d-flex justify-content-center text-danger">* {{ __('No Packages added to wishlist.') }}</h5></div><div>
             @endif
            <div class="row mt-5">
                <div class="col d-flex justify-content-end">
                {{$items->links()}}
                </div>
            </div>
        </div>
    </section>
</section>

@endsection






