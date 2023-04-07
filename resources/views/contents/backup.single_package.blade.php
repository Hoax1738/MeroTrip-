<section class="ftco-section ftco-no-pt ftco-no-pb">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 ftco-animate py-md-5 mt-md-5">
          <h2 class="mb-3">{{$item['title']}}</h2>
            <img src="{{asset($item['images'])}}" alt="" class="img-fluid">
            <div class="col-lg-3  col-md-3">
                <div class="blog_info text-right">
                    <div class="post_tag">
                        <a href="#"><?php foreach(explode(",",$item['tags']) as $tag){echo "#".$tag." ";}?>
                        </a>
                    </div>
                    <div class="tag-widget post-tag-container mb-5 mt-5">
                        <?php
                        $inc = array_merge(explode(",",$item['inclusions']),explode(",",$item['highlights']),explode(",",$item['travel_option']));
                        foreach($inc as $in){
                            $ico = strtolower(str_replace(" ","-",$in)).".png";
                            if(file_exists('icons/'.$ico)){
                            ?>
                            <img src="{{url('icons/'.$ico)}}" class="tag-cloud-link" style="height:20px; width:20px; margin:0px 5px 0px 20px;"/>{{$in}}
                            <?php
                            }
                        }
                        ?>
                </div>
                </div>
            </div>
          <p>{{$item['description']}}</p>

          <section class="blog_area single-post-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 posts-list">
                        <div class="modal  fade" id="BookModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"aria-hidden="true">
                            <div class="modal-dialog modal-custom modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Choose a Package</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">

                                        @foreach($item['commence_dates'] as $commence_date)
                                            <div class="col-md-4">
                                                <div class="card mb-4 text-center box-shadow" id="single-package-type">
                                                    <div class="card-header card-header-info">
                                                        <h4 class="my-0 font-weight-normal">{{$commence_date['commence_date']}}</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <h1 class="card-title pricing-card-title">{{$commence_date['price']}}<small class="text-muted"> NPR</small></h1>
                                                        <ul class="list-unstyled mt-3 mb-4">
                                                            <li>Date: {{$commence_date['commence_date']}}</li>
                                                            <li>Price: NPR {{$commence_date['price']}}</li>
                                                            <li>Maximum for the date: {{$commence_date['max_per_commence']}}</li>
                                                            <li>Available Slots: {{$commence_date['available_slots']}}</li>
                                                        </ul>
                                                        @if($commence_date['available_slots']>0)
                                                        <form method="post" action="{{route('calculateEMI',['trip' => $item['slug'], 'date'=>$commence_date['commence_date']])}}">@csrf<input type="hidden" name="clickref" value="{{$commence_date['id']}}"/><input type="submit" class="btn btn-lg genric-btn success medium" value="Book for this date"/></form>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="genric-btn danger medium" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="comments-area">
                            <h4>Itienary</h4>
                            <?php $show = true; ?>
                            @foreach($item['itinerary'] as $day)
                            <?php $itiid = rand(0,time());?>
                            <div class="comment-list">
                                <div class="single-comment justify-content-between d-flex">
                                    <div class="user justify-content-between d-flex">
                                        <div class="thumb">
                                            <img src="image/blog/c1.jpg" alt="">
                                        </div>
                                        <div class="desc">
                                            <h5><a href="#">Day {{$day['day']}}: {{$day['title']}}
                                            </a></h5>
                                        </div>
                                    </div>

                                    <div id="collapse{{$itiid}}" class="collapse<?php if($show) echo $show; $show = false;?>" role="tabpanel">
                                            <div class="card-body">
                                                <div class="row my-4">
                                                    <div class="col-md-8">
                                                        {{$day['description']}}
                                                    </div>
                                                    <div class="col-md-4 mt-3 pt-2">
                                                        <div class="view z-depth-1">
                                                            <div class="single-slider owl-carousel">
                                                            <?php
                                                            $endofday = explode(':',$day['end_of_day']);
                                                            if($endofday[0]=="hotel"){
                                                                ?>
                                                                <div class="item">
                                                                    <img src="{{$item['hotels'][$endofday[1]][0]['images']}}">
                                                                </div>
                                                                <?php
                                                            }
                                                            ?>
                                                                <div class="item">
                                                                    <img src="{{$day['images']}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>

                                    <div class="reply-btn">
                                        <a  class="btn-reply text-uppercase" data-toggle="collapse" href="#collapse{{$itiid}}" role="button" aria-expanded="false" aria-controls="collapseExample">View More</a>
                                    </div>

                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </section>



        </div> <!-- .col-md-8 -->
        <div class="col-lg-4 sidebar ftco-animate bg-light py-md-5">
          <div class="sidebar-box ftco-animate">
            <h3>Related Package</h3>
            @forelse($related as $package)
            <div class="block-21 mb-4 d-flex">
              <a class="blog-img mr-4" href="{{route('singlePackage',['slug'=>$package['slug']])}}" >{{$package['title']}}</a>
              <img class="blog-img mr-4" src="{{asset($item['images'])}}" >
              <div class="text">
                <h3 class="heading"><a href="#">{{$package['description']}}</a></h3>
                <div class="meta">
                  <div><a href="{{route('singlePackage',['slug'=>$package['slug']])}}"><span class="fa fa-calendar"></span> {{$package['duration']}}</a></div>

                </div>
              </div>
            </div>
            @empty
            <p>No related package found</p>
            @endforelse



          </div>
        </div>

      </div>
    </div>
  </section> <!-- .section -->

  <section class="ftco-intro ftco-section ftco-no-pt">
   <div class="container">
    <div class="row justify-content-center">
     <div class="col-md-12 text-center">
      <div class="img"  style="background-image: url(images/bg_2.jpg);">
       <div class="overlay"></div>
       <h2>We Are Pacific A Travel Agency</h2>
       <p>We can manage your dream building A small river named Duden flows by their place</p>
       <p class="mb-0"><a href="#" class="btn btn-primary px-4 py-3">Ask For A Quote</a></p>
     </div>
   </div>
  </div>
  </div>
  </section>
<!--================Blog Area =================-->

