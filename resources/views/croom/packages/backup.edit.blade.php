@extends('croom.layouts.main')
@section('content')
<style type="text/css">
.deleteitem,.hotel_list{
    display:none;
}
</style>
<form action="" method="post" enctype="multipart/form-data">
    @csrf
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Edit Package</div>
                    <div class="card-body">
                        <div class="col-sm-12">
                            @if(\Session::has('success'))
                                <div class="alert alert-success">
                                    {{\Session::get('success')}}
                                </div>
                            @endif
                            @if(\Session::has('fail'))
                                <div class="alert alert-danger">
                                    {{\Session::get('fail')}}
                                </div>
                            @endif
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <input type="text" autocomplete="off" class="form-control" name="title" placeholder="Package Name" value="{{ $packages->title }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <input type="text" autocomplete="off" class="form-control" name="description" placeholder="Package Description" value="{{ $packages->description }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <input type="text" autocomplete="off" class="form-control" name="highlights" placeholder="Highlights" value="{{ $packages->highlights }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <input type="text" autocomplete="off" class="form-control" name="tags" placeholder="Tags" value="{{ $packages->tags }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <input type="text" autocomplete="off" class="form-control" name="inclusions" placeholder="Inclusions" value="{{ $packages->inclusions }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <input type="text" autocomplete="off" class="form-control" name="travel_option" placeholder="Travel Options" value="{{ $packages->travel_option }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <input type="text" autocomplete="off" class="form-control" name="duration" placeholder="Duration in Days" value="{{ $packages->duration }}">
                            </div>
                        </div>
                        <hr>
                        <div>
                            Existing Images
                            <br/><br/>
                            <div class="row">
                                @forelse($images_data as $key=>$data)
                                    <div class="col-md-4 old_img" style="margin-bottom:10px;">
                                        <div class="card border">
                                            <div class="card-header">
                                                Image #<span class="count">{{ $key+1 }}</span>
                                                <small class="float-sm-right"><a href="" class="btn btn-danger btn-sm text-white" onclick="$(this).closest('.old_img').remove();return false;">X</a></small>
                                            </div>
                                            <div class="card-body">
                                                <img src="{{ url(trim($data)) }}" width="100%"/>
                                                <input type="hidden" name="old_img[]" value="{{ $data }}">
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-danger">* No Images Found</p>
                                @endforelse
                            </div>
                        </div>

                        <div x-data>
                            Images 
                            <a style="cursor: pointer; float:right;border-radius: 12px" x-on:click="$refs.this.click()" class="btn btn-primary">Add </a>
                            <br/><br/>
                            <div class="row top_level">
                                <div class="col-md-4 clone_it" style="margin-bottom:10px;">
                                    <div class="card border">
                                        <div class="card-header">
                                            Image #<span class="count">1</span>
                                            <small class="float-sm-right"><a href="" class="btn btn-danger btn-sm deleteitem text-white">X</a></small>
                                        </div>
                                        <div class="card-body">
                                            <input type="file" name="package_img[image][1]" class="form-control" accept="image/png, image/jpeg">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <a class="btn btn-primary btn-lg cloner" x-ref="this" style="border-radius: 12px; display:none" href="javascript:void(0);">Add</a>
                                </div>
                            </div>
                        </div>          
                        <hr>
                        <div x-data="{show:false}">
                            <template x-if="show==false">
                                <a style="cursor: pointer"  @click="show=true">Existing Commences Date</a>
                            </template>
                            <template x-if="show==true">
                                <a style="cursor:pointer"  @click="show=false">Hide</a>
                            </template>
                            <br/><br/>
                            <div class="row top_level" x-show="show">
                                @foreach($c_date as $key=>$row)    
                                    <div class="col-md-4 cdate" style="margin-bottom:10px;">
                                        <div class="card border">
                                            <div class="card-header">
                                                Commence Date #<span class="count">{{ $key+1 }}</span>
                                                <small class="float-sm-right"><a href="{{ route('croom.packages.deleteCommenceDate',['id'=>$row->id]) }}" class="btn btn-danger btn-sm text-white" onclick="return confirm('Are you sure you want to delete this item')">X</a></small>
                                            </div>
                                            <div class="card-body">
                                                <input type="hidden" name="old_commence_dates[{{ $key }}][id]"  value="{{ $row->id }}"/><br/>
                                                <input type="text" autocomplete="off" class="form-control" name="old_commence_dates[{{ $key }}][commence_date]" placeholder="Commence Date" value="{{ $row->commence_date }}"/><br/>
                                                <input type="text" autocomplete="off" class="form-control" name="old_commence_dates[{{ $key }}][max_per_commence]" placeholder="Maximum People" value="{{ $row->max_per_commence }}"><br/>
                                                <input type="text" autocomplete="off" class="form-control" name="old_commence_dates[{{ $key }}][price]" placeholder="Package Price" value="{{ $row->price }}">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach    
                            </div>
                        </div>

                        {{-- <div x-data>
                            Commences Date 
                            <a style="cursor: pointer; float:right;border-radius: 12px" x-on:click="$refs.this.click()" class="btn btn-primary">Add </a>
                            <br/><br/>
                            <div class="row top_level"> 
                                <div class="col-md-4 clone_it" style="margin-bottom:10px;">
                                    <div class="card border">
                                        <div class="card-header">
                                            Commence Date #<span class="count">1</span>
                                            <small class="float-sm-right"><a href="" class="btn btn-danger btn-sm deleteitem text-white">X</a></small>
                                        </div>
                                        <div class="card-body">
                                            <input type="text" autocomplete="off" class="form-control" name="commence_dates[1][commence_date]" placeholder="Commence Date" /><br/>
                                            <input type="text" autocomplete="off" class="form-control" name="commence_dates[1][max_per_commence]" placeholder="Maximum People" ><br/>
                                            <input type="text" autocomplete="off" class="form-control" name="commence_dates[1][price]" placeholder="Package Price">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <a class="btn btn-primary btn-lg cloner" x-ref="this" style="border-radius: 12px; display:none" href="">Add</a>
                                </div>
                            </div>
                        </div> --}}

                        <hr>
                        <div>
                            Existing Itinerary
                            <br/><br/>
                            <div class="row top_level">
                                @foreach($itinerary as $key=>$row)
                                    <div class="col-md-12 clone_it" style="margin-bottom:10px;">
                                        <div class="card border">
                                            <div class="card-header">
                                                Day <span class="count">{{ $key+1 }}</span>
                                                <small class="float-sm-right"><a href="{{ route('croom.packages.deleteAddIt',['id'=>$row->id]) }}" class="btn btn-danger btn-sm  text-white" onclick="return confirm('Are you sure you want to delete this item')">X</a></small>
                                            </div>
                                            <div class="card-body">
                                                <input type="hidden" name="old_itinerary[{{ $key }}][id]"  value="{{ $row->id }}"/><br/>
                                                <input type="text" autocomplete="off" class="form-control" name="old_itinerary[{{ $key }}][title]" placeholder="Day Title" value="{{ $row->title }}"/><br/>
                                                <input type="text" autocomplete="off" class="form-control" name="old_itinerary[{{ $key }}][inclusions]" placeholder="Day Inclusions" value="{{ $row->inclusions }}"/><br/>
                                                <h6>Existing Images</h6>
                                                <div class="row top_level">
                                                    <?php
                                                    $data=explode(",",$row->images);?>
                                                    @foreach($data as $info)
                                                        <div class="col-md-4 it_image" style="margin-bottom:10px;">
                                                            <div class="card border">
                                                                <div class="card-header">
                                                                    Image #<span class="count">1</span>
                                                                    <small class="float-sm-right"><a href="" class="btn btn-danger btn-sm text-white" onclick="$(this).closest('.it_image').remove();return false;">X</a></small>
                                                                </div>
                                                                <div class="card-body">
                                                                    <img src="{{ url($info) }}" alt="it-images" width="100%">
                                                                    <input type="hidden" name="old_itinerary_img[]" value="{{ $info }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach    
                                                </div>
                                                <h6>Images</h6>
                                                <hr>
                                                <div class="row top_level">
                                                    <div class="col-md-4 clone_it" style="margin-bottom:10px;">
                                                        <div class="card border">
                                                            <div class="card-header">
                                                                Image #<span class="count">1</span>
                                                                <small class="float-sm-right"><a href="" class="btn btn-danger btn-sm deleteitem text-white">X</a></small>
                                                            </div>
                                                            <div class="card-body">
                                                                <input type="file" name="old_itinerary_img_new[1][image][1]" class="form-control" accept="image/png, image/jpeg">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <a class="btn btn-warning btn-lg cloner imgcloner" style="border-radius:12px" href="javascript:void(0);">Add</a>
                                                    </div>
                                                </div>
                                                <hr>
                                                <input type="text" autocomplete="off" class="form-control" name="old_itinerary[{{ $key }}][description]" placeholder="Description" value="{{ $row->description }}"/><br/>
                                                <input type="text" autocomplete="off" class="form-control" name="old_itinerary[{{ $key }}][key_activities]" placeholder="Key Activities" value="{{ $row->key_activities }}"/><br/>
                                                <input type="text" autocomplete="off" class="form-control" name="old_itinerary[{{ $key }}][destination_place]" placeholder="Destination Place" value="{{ $row->destination_place }}"/><br/>
                                                <input type="hidden" class="end_of_day" value="{{ $row->end_of_day }}" name="old_itinerary[{{ $key }}][end_of_day]"/>
                                                <input type="text" autocomplete="off" class="form-control" name="hotel_search" placeholder="End of Day (Hotel/Tent/Checkout)"/>
                                                <div class="hotel_list">Please select one:<ul></ul></div>
                                                <small>Can't find the hotel you're looking for? <a href="{{route('croom.hotels.add')}}" target="_blank">Please add</a></small><br/>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach    
                            </div>
                        </div> 
                        
                        {{-- <div x-data>
                            Itinerary
                            <a style="cursor: pointer; float:right;border-radius: 12px" x-on:click="$refs.this.click()" class="btn btn-primary">Add </a>
                            <br/><br/>
                            <div class="row top_level">
                                <div class="col-md-12 clone_it" style="margin-bottom:10px;">
                                    <div class="card border">
                                        <div class="card-header">
                                            Day <span class="count">1</span>
                                            <small class="float-sm-right"><a href="" class="btn btn-danger btn-sm deleteitem text-white">X</a></small>
                                        </div>
                                        <div class="card-body">
                                            <input type="text" autocomplete="off" class="form-control" name="itinerary[1][title]" placeholder="Day Title" /><br/>
                                            <input type="text" autocomplete="off" class="form-control" name="itinerary[1][inclusions]" placeholder="Day Inclusions" /><br/>
                                            <h6>Images</h6>
                                            <hr>
                                            <div class="row top_level">
                                                <div class="col-md-4 clone_it" style="margin-bottom:10px;">
                                                    <div class="card border">
                                                        <div class="card-header">
                                                            Image #<span class="count">1</span>
                                                            <small class="float-sm-right"><a href="" class="btn btn-danger btn-sm deleteitem text-white">X</a></small>
                                                        </div>
                                                        <div class="card-body">
                                                            <input type="file" name="itinerary[1][image][1]" class="form-control" accept="image/png, image/jpeg">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <a class="btn btn-warning btn-lg cloner imgcloner" style="border-radius:12px" href="javascript:void(0);">Add</a>
                                                </div>
                                            </div>
                                            <hr>
                                            <input type="text" autocomplete="off" class="form-control" name="itinerary[1][description]" placeholder="Description"/><br/>
                                            <input type="text" autocomplete="off" class="form-control" name="itinerary[1][key_activities]" placeholder="Key Activities"/><br/>
                                            <input type="text" autocomplete="off" class="form-control" name="itinerary[1][destination_place]" placeholder="Destination Place"/><br/>
                                            <input type="hidden" class="end_of_day"  name="itinerary[1][end_of_day]"/>
                                            <input type="text" autocomplete="off" class="form-control" name="hotel_search" placeholder="End of Day (Hotel/Tent/Checkout)"/>
                                            <div class="hotel_list">Please select one:<ul></ul></div>
                                            <small>Can't find the hotel you're looking for? <a href="{{route('croom.hotels.add')}}" target="_blank">Please add</a></small><br/>
                                        </div>
                                    </div>
                                </div>   
                                <div class="col-md-1">
                                    <a class="btn btn-primary btn-lg cloner" style="border-radius:12px; display:none" x-ref="this" href="javascript:void(0);">Add</a>
                                </div>
                            </div>
                        </div>  --}}

                        <hr>
                        <div>
                            Existing Additional Information
                            <br/><br/>
                            <div class="row top_level">
                                @foreach($additional_info as $key=>$row)
                                    <div class="col-md-12 clone_it" style="margin-bottom:10px;">
                                        <div class="card border">
                                            <div class="card-header">
                                                Additional Info #<span class="count">{{ $key+1 }}</span>
                                                <small class="float-sm-right"><a href="{{ route('croom.packages.deleteAddInfo',['id'=>$row->id]) }}" class="btn btn-danger btn-sm  text-white" onclick="return confirm('Are you sure you want to delete this item')">X</a></small>
                                            </div>
                                            <div class="card-body">
                                                <input type="hidden" name="old_additional_info[{{ $key }}][id]" value="{{ $row->id }}"  /><br/>
                                                <input type="text" autocomplete="off" class="form-control" name="old_additional_info[{{ $key }}][title]" placeholder="Title" value="{{ $row->title }}"/><br/>
                                                <input type="text" autocomplete="off" class="form-control"  name="old_additional_info[{{ $key }}][description]" placeholder="Contents" value="{{ $row->description }}"/><br/>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            {{-- Additional Information
                            <a style="cursor: pointer; float:right;border-radius: 12px" x-on:click="$refs.this.click();" class="btn btn-primary">Add </a>
                            <br/><br/> --}}
                            {{-- <div class="row top_level">
                                <div class="col-md-12 clone_it" style="margin-bottom:10px;">
                                    <div class="card border">
                                        <div class="card-header">
                                            Additional Info #<span class="count">1</span>
                                            <small class="float-sm-right"><a href="" class="btn btn-danger btn-sm deleteitem text-white">X</a></small>
                                        </div>
                                        <div class="card-body">
                                            <input type="text" autocomplete="off" class="form-control" name="additional_info[1][title]" placeholder="Title" /><br/>
                                            <input type="text" autocomplete="off" class="form-control"  name="additional_info[1][description]" placeholder="Contents"/><br/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <a class="btn btn-primary btn-lg cloner" style="border-radius:12px; display:none" href="" x-ref="this">Add</a>
                                </div>
                            </div> --}}
                            <div class="row">
                                <div class="col-md-12" style="margin-top:10px;">
                                    <input type="submit" class="btn btn-success text-white btn-lg" style="border-radius: 12px" value="Save Package"/>
                                </div>
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

@section('page-title') Edit Package @endsection
