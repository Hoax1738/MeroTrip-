@foreach($items as $package)
<div class="col-md-4 ftco-animate">
    <div class="project-wrap">
        <a href="{{route('singlePackage',['slug'=>$package['slug']])}}" class="img" style="background-image: url($package['images']);">
            <?php $images=explode(",",$package['images']);?>
            <img class="img" src="{{$images[0]}}" alt="">
            <span class="price">{{($package['duration'])}} {{ __('Days') }}</span>
        </a>
          <span class="wishlist-btn">
            @if(Auth::check() && Auth::user()->hasRole('customer'))
                <a href="@if($package['user_id']==auth()->user()->id) {{ url('/saveWishList',['id'=>$package['id'],'status'=>'stored']) }} @else {{ url('/saveWishList',['id'=>$package['id'],'status'=>'not_stored']) }} @endif">
                    @if($package['user_id']==auth()->user()->id)
                        <i class="fa fa-heart"  style="background: #FFF;padding: 10px;margin-right: 5px;border-radius: 50% !important; color:red;"></i>
                        @else
                        <i class="fa fa-heart-o" style="background: #FFF;padding: 10px;margin-right: 5px;border-radius: 50% !important;"></i>
                    @endif
                </a>
            @else
                <a href="{{ url('login') }}"><i class="fa fa-heart-o" style="background: #FFF;padding: 10px;margin-right: 5px;border-radius: 50% !important;"></i></a>
            @endif
        </span>
        <div class="text p-4">
            <h3><a href="{{route('singlePackage',['slug'=>$package['slug']])}}">{{__($package['title'])}}</a></h3>
            {{-- <ul>
                <li><span class="flaticon-shower"></span>2</li>
                <li><span class="flaticon-king-size"></span>3</li>
                <li><span class="flaticon-mountains"></span>Near Mountain</li>
            </ul> --}}
            <span class="destination"> <i class="fa fa-map-marker"></i> {{__($package['destination'])}}</span>
            <span  style="border-right:1px solid #D3D3D3; margin: 3px;"> </span>
            <?php
            $counter = 1;
            $maximum = 3;
            $tags=explode(",",$package['tags']);
            $no_comma = array();?>
            @foreach($tags as $tag => $value )
                <?php array_push($no_comma, ucfirst($value)); $counter++;?>
                <?php if ($counter === $maximum) {
                    break;
                }
                ?>
            @endforeach
            <span class="tags ml-1">{{  implode(", ", $no_comma)}}</span>
        </div>
    </div>
</div>
@endforeach


<script>
    function loadMore(page){ 
         $.ajax({
            url:'?page='+page,
            type:'get',
            
            beforeSend: function(){
                 $('.ajax-load').show();
            }
        })
        .done(function(data){
            if(data.html==""){
                $('.ajax-load').html('No records found');
                return;
            }
            $('.ajax-load').hide();
            $('#post-data').append(data.html); 
        })

        .fail(function(jqXHR,ajaxOptions,thrownError){
            alert('Server not responding');
        });
    }

    var page=1;
    $(window).scroll(function(){
        if($(window).scrollTop()+ $(window).height() >=$(document).height()){
            page++;
            loadMore(page);
        }
    })
</script>