@extends('layouts.frontend.app')
@section('title') {{ __(' Write a Review ').' - Tripkhata®' }}@endsection

@section('slider')
 <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
@endsection

@section('content')

<style>
.checked {
    color: #00AF87;
}
</style>

<section class="content">
        <section class="ftco-section ftco-no-pb contact-section mb-5">
            <div class="container">
                @if (Auth::check())
                @include('contents.emiAlert')
                @else
                @endif
                <div class="row justify-content-center pb-4">
                    <div class="col-md-6 heading-section text-center ftco-animate">
                        <h2>{{ __('Write a Review ') }}</h2>
                    </div>
                </div>

                @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

                @forelse($packages as $key=>$info)
                <div class="row d-flex bg-light p-4">
                    <div class="col-lg-3">
                        <?php $images=explode(",",$info->images); $image_info=\App\Image::find($images[0]);?>
                        @if($image_info!=NULL)
                            <img @if($images_info->drive_id==NULL) src="{{url("$images_info->directory/$images_info->local_filename")}}" @else src="https://drive.google.com/uc?export=view&id={{$images_info->drive_id}}" @endif  alt="photo" class="img-fluid">
                        @endif    
                    </div>
                    <div class="col-lg-9">
                        <h5 class="mb-0"> <a href="{{ route('singlePackage',['slug'=> $info->slug]) }}">{{ __($info->title) }}</a></h5>
                        <span class="text-muted font-weight-normal">{{ __($info->destination) }}</span>
                        <div x-data="{show:false,info:'{{ old('review'.$key) }}'}">
                            <span class="fa fa-star" id="star1{{ $key+1 }}" onclick="add(this,1,{{ $key+1 }})"></span>
                            <span class="fa fa-star" id="star2{{ $key+1 }}" onclick="add(this,2,{{ $key+1 }})"></span>
                            <span class="fa fa-star" id="star3{{ $key+1 }}" onclick="add(this,3,{{ $key+1 }})"></span>
                            <span class="fa fa-star" id="star4{{ $key+1 }}" onclick="add(this,4,{{ $key+1 }})"></span>
                            <span class="fa fa-star" id="star5{{ $key+1 }}" onclick="add(this,5,{{ $key+1 }})"></span>

                            <span class="ml-2 text text-success" x-on:click="show=true" id="rate{{ $key+1 }}">Click To Rate </span>

                            @error('rating'.$key)<div><span class="text-danger">* {{__($message) }}</span></div>@enderror

                            <form x-show="show" id="reviewForm{{ $key+1 }}" action="{{ url('/saveReview') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{ __('Title of your review') }}</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Summarize your visit or highlight an interesting detail" name="title{{ $key }}" value="{{ old('title'.$key) }}">
                                    @error('title'.$key) <span class="text-danger">* {{ __($message) }}</span>@enderror
                                </div>


                                <div class="form-group">
                                    <label>{{ __('Your Review') }}</label><span x-text="info.length==0 ? '(100 minimum characters)' : info.length+ ' '+ 'characters'+' '+'(100 minimum)'" class="float-right" :class="info.length>=200?'text-success':''" id="letter"></span>
                                    <textarea x-model="info" class="form-control" placeholder="By sharing your experiences, you're helping the travellers" name="review{{ $key }}"></textarea>
                                    @error('review'.$key) <span class="text-danger">* {{ __($message) }}</span>@enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-check-label" for="exampleCheck1">{{ __('When did you travel? ') }}</label>
                                    <input type="month" class="form-control" name="visit_date{{ $key }}" value="{{ old('visit_date'.$key) }}">
                                    @error('visit_date'.$key) <span class="text-danger">* {{ __($message) }}</span>@enderror
                                </div>

                                <input type="hidden" id="valueStar{{ $key+1 }}" name="rating{{ $key }}">
                                <input type="hidden" name="package_id" value="{{ $info->package_id }}">
                                <input type="hidden" name="packageKey" value="{{ $key }}">

                                <button type="submit" class="btn btn-primary">{{ __('Submit ') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                    <div class="row pt-5"><div class="col-lg-12"><h5 class="d-flex justify-content-center text-danger">* {{ __('No Records Found') }}</h5></div><div>
                @endforelse
            </div>
        </section>
</section>



<script>
    function add(ths,sno,n){

        document.getElementById('reviewForm'+n).style.display = "block";

        for (var i=1;i<=5;i++){
        var cur=document.getElementById("star"+i+n);
        cur.className="fa fa-star";
        }

        for (var i=1;i<=sno;i++){
            var cur=document.getElementById("star"+i+n);
            if(cur.className=="fa fa-star"){
                cur.className="fa fa-star checked";
                document.getElementById("valueStar"+n).value=i;
            }
        }

        if(document.getElementById("valueStar"+n).value==1){
            document.getElementById('rate'+n).innerText='Terrible';
        }else if(document.getElementById("valueStar"+n).value==2){
            document.getElementById('rate'+n).innerText='Poor';
        }else if(document.getElementById("valueStar"+n).value==3){
            document.getElementById('rate'+n).innerText='Average';
        }else if(document.getElementById("valueStar"+n).value==4){
            document.getElementById('rate'+n).innerText='Very Good';
        }else{
            document.getElementById('rate'+n).innerText='Excellent';
        }
    }
</script>



@endsection
