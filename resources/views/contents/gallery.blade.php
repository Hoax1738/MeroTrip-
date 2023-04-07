@extends('layouts.frontend.app')
@section('title') Gallery @endsection
@section('content')

<section class="content">
    <section id="gallery" class="ftco-section img ftco-select-destination">
        <div class="container">
                @if (Auth::check())
                @include('contents.emiAlert')
                @else
                @endif
            <div class="row justify-content-center pb-4">
                <div class="col-md-12 heading-section text-center ftco-animate">
                    <span class="subheading">Trip Khata Gallery</span>
                </div>
            </div>
        </div>
        <div class="container container-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="carousel-destination owl-carousel ftco-animate">
                        @foreach($package_images as $package_image)
                        <div class="item">
                            <div class="project-destination">
                                <?php
                                    $images=explode(',',$package_image['images'])[0];
                                    $img=\App\Image::select()
                                                    ->where('id',$images)
                                                    ->first();               
                                ?>
                                <a href="{{route('singleGallery',['slug'=>$package_image['slug']])}}" class="img" @if($img->drive_id==NULL) style="background-image: url({{ "$img->directory/$img->local_filename" }})" @else style="background-image: url('https://drive.google.com/uc?export=view&id={{$img->drive_id}}')" @endif>
                                    <div class="text">
                                        <h3>{{$package_image['title']}}</h3>
                                        {{-- <span>8 Tours</span> --}}
                                    </div>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <button class="play">Play</button>
                </div>
            </div>
        </div>
    </section>
</section>
<script>
    $(document).ready(function(){
        $('.play').hide();
        var owl = $('.owl-carousel');
        owl.owlCarousel({
            items:4,
            loop:true,
            margin:10,
            autoplay:true,
            autoplayTimeout:1000,
            autoplayHoverPause:true
        });

        $('.play').on('click',function(){
            owl.trigger('play.owl.autoplay',[3000]);
        })
        $(".play").click(); 
    });
</script>
@endsection


