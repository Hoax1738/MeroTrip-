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
                    <div class="card-header">Edit Package <span class="text-danger">(* Indicates The Fields Are Required)</span></div>
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
                        <div class="form-group ">
                            <label>Package Title</label>
                            <div class="col-sm-12 input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text text-danger">*</div>
                                </div>
                                <input type="text" autocomplete="off" class="form-control" name="title" placeholder="Package Name" value="{{ $packages->title }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label>Package Description</label>
                            <div class="col-sm-12">
                                <textarea type="text" autocomplete="off" class="form-control" name="description" placeholder="Package Description" >{{ $packages->description }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label>Package Highlights</label>
                            <div class="col-sm-12">
                                <textarea type="text" autocomplete="off" class="form-control" name="highlights" placeholder="Highlights" >{{ $packages->highlights }}</textarea>
                            </div>
                        </div>
                        <label class="form-check-label" for="flexCheckIndeterminate">
                            Recomended tags:
                             @foreach ($menu_tags as $menu_tag)
                                {{$menu_tag->title}},
                             @endforeach

                        </label>
                        <div class="form-group ">
                            <div class="col-sm-12 input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text text-danger py-3">*</div>
                                </div>
                                <textarea type="text" autocomplete="off" class="form-control" name="tags" placeholder="Package tags" >{{ $packages->tags }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label>Package Inclusions</label>
                            <div class="col-sm-12">
                                <textarea type="text" autocomplete="off" class="form-control" name="inclusions" placeholder="Package Inclusions" >{{ $packages->inclusions }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label>Package Exclusions</label>
                            <div class="col-sm-12">
                                <textarea type="text" autocomplete="off" class="form-control" name="exclusions" placeholder="Package Exclusions">{{ $packages->exclusions }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label>Travel Option</label>
                            <div class="col-sm-12">
                                <input type="text" autocomplete="off" class="form-control" name="travel_option" placeholder="Travel Options" value="{{ $packages->travel_option }}" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label>Package Duration</label>
                            <div class="col-sm-12 input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text text-danger">*</div>
                                </div>

                                <input type="number" autocomplete="off" class="form-control" name="duration" placeholder="Duration in Days" value="{{ $packages->duration }}" required>
                            </div>
                        </div>
                        {{-- <div class="form-group row">
                            <div class="col-sm-12">
                                <textarea type="text" autocomplete="off" class="form-control" name="map_link" placeholder="Map Lik"  required>{{ $packages->map_link }}</textarea>
                            </div>
                        </div> --}}
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <div class="form-check">
                                    <input class="form-check-input" name="featured" type="checkbox" value="1" id="flexCheckIndeterminate" {{ ($packages->featured=="1")? "checked" : ""}} value="{{old('featured')}}">
                                    <label class="form-check-label" for="flexCheckIndeterminate">
                                        Make Featured
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <div class="form-check">
                                    <input class="form-check-input" name="special_offer" type="checkbox" value="1" id="flexCheckIndeterminate" {{ ($packages->special_offer=="1")? "checked" : ""}} value="{{old('special_offer')}}">
                                    <label class="form-check-label" for="flexCheckIndeterminate">
                                        Add To Special Offers
                                    </label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div>
                            Existing Images
                            <br/><br/>
                            <div class="d-flex flex-row flex-nowrap overflow-auto">
                                @forelse($images_data as $key=>$data)
                                    <div class="col-md-4 old_img mx-2" style="margin-bottom:10px;">
                                        <div class="card border">
                                            <div class="card-header bg-success">
                                                <div class="d-flex justify-content-between">
                                                    <div class="text-white">Image #<span class="count">{{ $key+1 }}</span></div>
                                                    <small class="float-sm-right"><a href="{{ route('croom.packages.removeImages',['id'=>$packages->id,'key'=>$key]) }}" class="btn btn-danger btn-sm text-white rounded-circle" onclick="return confirm('Are you sure you want to delete this images')" >X</a></small>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                @php $images=\App\Image::find($data) @endphp
                                                @if($images!=NULL)
                                                    @if($images->drive_id==NULL)
                                                        <img src="{{url("$images->directory/$images->local_filename")}}" width="100%" style="height:200px"/>
                                                    @else
                                                        <img src="https://drive.google.com/uc?export=view&id={{$images->drive_id}}" width="100%" style="height:200px"/>
                                                    @endif    
                                                    <input type="hidden" name="old_img[]" value="{{ $data }}">
                                                @endif    
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-danger">* No Images Found</p>
                                @endforelse
                            </div>
                        </div>

                        <div x-data>
                            Images (You can add multiple images)
                            {{-- <a style="cursor: pointer; float:right;border-radius: 12px" x-on:click="$refs.this.click()" class="btn btn-primary">Add </a> --}}
                            <br/><br/>
                            <div class="row top_level">
                                <div class="col-md-4 clone_it" style="margin-bottom:10px;">
                                    <div class="card border">
                                        <div class="card-header bg-success">
                                            <div class="d-flex justify-content-between">
                                                <div class="text-white">Images</div>
                                                <small class="float-sm-right"><a href="" class="btn btn-danger btn-sm deleteitem text-white rounded-circle">X</a></small>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group ">
                                                <div class="col-sm-12 input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text text-danger">*</div>
                                                    </div>
                                                     <input type="file" name="package_img[image][]" class="form-control" accept=".png, .jpg, .jpeg" multiple>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-md-2">
                                    <a class="btn btn-primary btn-lg cloner" x-ref="this" style="border-radius: 12px; display:none" href="javascript:void(0);">Add</a>
                                </div> --}}
                            </div>
                        </div>
                        <hr>
                        <div x-data="{show:true}" class="main">
                            Existing Commence Dates
                            <a style="cursor: pointer; float:right;border-radius: 12px" x-on:click="$refs.this.click();" class="btn btn-primary">Add </a>
                            <br/><br/>
                            <div class="row top_level" x-show="show">
                                @if(count($c_date)>0)
                                @foreach($c_date as $key=>$row)
                                    <div class="col-md-4 clone_it cdate" style="margin-bottom:10px;">
                                        <div class="card border">
                                            <div class="card-header bg-success">
                                                <div class="d-flex justify-content-between">
                                                    <div class="text-white">Commence Date #<span class="count">{{ $key+1 }}</span></div>
                                                    <small class="float-sm-right"><a href="#" class="btn btn-danger btn-sm text-white removeData rounded-circle" name="key" data-id="{{ $key+1 }}" data-row="{{ $row->id }}" data-type="cdate" onclick="check(this)" data-info="{{ $key+1 }}">X</a></small>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <input type="hidden" name="old_commence_dates[{{ $key }}][id]"  value="{{ $row->id }}"/><br/>
                                                <div class="form-group">
                                                    <label>Commence Date</label>
                                                    <div class="col-sm-12 input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text text-danger">*</div>
                                                        </div>
                                                        <input type="date" autocomplete="off" class="form-control" name="old_commence_dates[{{ $key }}][commence_date]" placeholder="Commence Date" value="{{ $row->commence_date }}" required /><br/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Maximum People</label>
                                                    <div class="col-sm-12 input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text text-danger">*</div>
                                                        </div>
                                                        <input type="number" autocomplete="off" class="form-control" name="old_commence_dates[{{ $key }}][max_per_commence]" placeholder="Maximum People" value="{{ $row->max_per_commence }}" required ><br/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Package Price</label>
                                                    <div class="col-sm-12 input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text text-danger">*</div>
                                                        </div>
                                                        <input type="number" autocomplete="off" class="form-control" name="old_commence_dates[{{ $key }}][price]" placeholder="Package Price" value="{{ $row->price }}" required >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <a class="btn btn-primary btn-lg cloner" x-ref="this" style="border-radius: 12px; display:none" href="javascript:void(0);">Add</a>
                                        </div>
                                    </div>
                                @endforeach
                                @else
                                    <div class="col-md-4 clone_it" style="margin-bottom:10px;">
                                        <div class="card border">
                                            <div class="card-header bg-success">
                                                <div class="d-flex justify-content-between">
                                                    <div class="text-white">Commence Date #<span class="count">1</span></div>
                                                    <small class="float-sm-right"><a href="" class="btn btn-danger btn-sm deleteitem text-white rounded-circle">X</a></small>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <input type="hidden" name="old_commence_dates[1][id]"/><br/>
                                                <div class="form-group ">
                                                    <label>Commence Date</label>
                                                    <div class="col-sm-12 input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text text-danger">*</div>
                                                        </div>
                                                        <input type="date" autocomplete="off" class="form-control" name="old_commence_dates[1][commence_date]" placeholder="Commence Date"  value="{{ old('old_commence_dates.1.commence_date') }}" required/><br/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Maximum People</label>
                                                    <div class="col-sm-12 input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text text-danger">*</div>
                                                        </div>
                                                        <input type="number" autocomplete="off" class="form-control" name="old_commence_dates[1][max_per_commence]" placeholder="Maximum People" value="{{ old('old_commence_dates.1.max_per_commence') }}" required/><br/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Package Price</label>
                                                    <div class="col-sm-12 input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text text-danger">*</div>
                                                        </div>
                                                        <input type="number" autocomplete="off" class="form-control" name="old_commence_dates[1][price]" placeholder="Package Price"value="{{ old('old_commence_dates.1.price') }}" required/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <a class="btn btn-primary btn-lg cloner" x-ref="this" style="border-radius: 12px; display:none" href="">Add</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <hr>
                        {{-- <div x-data="{show:true}">
                            Existing Itinerary
                            <a style="cursor: pointer; float:right;border-radius: 12px" x-on:click="$refs.this.click()" class="btn btn-primary">Add </a>
                            <br/><br/>
                            <div class="row top_level">
                                @if(count($itinerary)>0)
                                    @foreach($itinerary as $key=>$row)
                                        <div class="col-md-12 clone_it iti" style="margin-bottom:10px;">
                                            <div class="card border">
                                                <div class="card-header">
                                                    Day <span class="count">{{ $key+1 }}</span>
                                                    <small class="float-sm-right"><a href="#" class="btn btn-danger btn-sm text-white removeData" name="key" data-id="{{ $key+1 }}" data-row="{{ $row->id }}" data-type="iti" onclick="check(this)" data-info="{{ $key+1 }}">X</a></small>
                                                </div>
                                                <div class="card-body">

                                                    <input type="hidden" name="old_itinerary[{{ $key }}][id]"  value="{{ $row->id }}"/><br/>
                                                    <div class="form-group ">
                                                        <div class="col-sm-12 input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text text-danger">*</div>
                                                            </div>
                                                    <input type="text" autocomplete="off" class="form-control" name="old_itinerary[{{ $key }}][title]" placeholder="Day Title" value="{{ $row->title }}" required/><br/>
                                                        </div>
                                                    </div>
                                                    <input type="text" autocomplete="off" class="form-control" name="old_itinerary[{{ $key }}][inclusions]" placeholder="Day Inclusions" value="{{ $row->inclusions }}" ><br/>

                                                    <textarea type="text" autocomplete="off" class="form-control" name="old_itinerary[{{ $key }}][description]" placeholder="Description"  >{{ $row->description }}</textarea><br/>
                                                    <input type="text" autocomplete="off" class="form-control" name="old_itinerary[{{ $key }}][key_activities]" placeholder="Key Activities" value="{{ $row->key_activities }}" /><br/>
                                                    <input type="text" autocomplete="off" class="form-control" name="old_itinerary[{{ $key }}][destination_place]" placeholder="Destination Place" value="{{ $row->destination_place }}" /><br/>
                                                    <input type="hidden" name="old_itinerary[{{ $key }}][day]" value="{{ $row->day }}">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <a class="btn btn-primary btn-lg cloner" x-ref="this" style="border-radius: 12px; display:none" href="javascript:void(0);">Add</a>
                                        </div>
                                    @endforeach
                                 @else
                                    <div class="col-md-12 clone_it" style="margin-bottom:10px;">
                                        <div class="card border">
                                            <div class="card-header">
                                                Day <span class="count">1</span>
                                                <small class="float-sm-right"><a href="" class="btn btn-danger btn-sm deleteitem text-white">X</a></small>
                                            </div>
                                            <div class="card-body">
                                                <input type="hidden" name="old_itinerary[1][id]"/><br/>
                                                <div class="form-group ">
                                                    <div class="col-sm-12 input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text text-danger">*</div>
                                                        </div>
                                                <input type="text" autocomplete="off" class="form-control" name="old_itinerary[1][title]" placeholder="Day Title" required value="{{ old('old_itinerary.1.title') }}"/><br/>
                                                    </div>
                                                </div>
                                                <textarea type="text" autocomplete="off" class="form-control" name="old_itinerary[1][inclusions]" placeholder="Day Inclusions" >{{ old('old_itinerary.1.inclusions') }}</textarea><br/>

                                                <textarea type="text" autocomplete="off" class="form-control" name="old_itinerary[1][description]" placeholder="Description" >{{ old('old.itinerary.1.description') }}</textarea><br/>
                                                <textarea type="text" autocomplete="off" class="form-control" name="old_itinerary[1][key_activities]" placeholder="Key Activities">{{ old('old.itinerary.1.key_activities') }}</textarea><br/>
                                                <textarea type="text" autocomplete="off" class="form-control" name="old_itinerary[1][destination_place]" placeholder="Destination Place">{{ old('old.itinerary.1.destination_place') }}</textarea><br/>
                                                <input type="hidden"  name="old_itinerary[1][day]"/>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <a class="btn btn-primary btn-lg cloner" style="border-radius:12px; display:none" x-ref="this" href="javascript:void(0);">Add</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <hr> --}}
                        <div x-data="{show:true}">
                            Existing Additional Information
                            <a style="cursor: pointer; float:right;border-radius: 12px" x-on:click="$refs.this.click()" class="btn btn-primary">Add </a>
                            <br/><br/>
                            <div class="row top_level">
                                @if(count($additional_info)>0)
                                    @foreach($additional_info as $key=>$row)
                                        <div class="col-md-12 clone_it additional" style="margin-bottom:10px;">
                                            <div class="card border">
                                                <div class="card-header bg-success">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="text-white">Additional Info #<span class="count">{{ $key+1 }}</span></div>
                                                        <small class="float-sm-right"><a href="#" class="btn btn-danger btn-sm text-white removeData rounded-circle" name="key" data-id="{{ $key+1 }}" data-row="{{ $row->id }}" data-type="additional" onclick="check(this)" data-info="{{ $key+1 }}">X</a></small>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <input type="hidden" name="old_additional_info[{{ $key }}][id]" value="{{ $row->id }}"  /><br/>
                                                    <label>Additional Title</label>
                                                    <input type="text" autocomplete="off" class="form-control" name="old_additional_info[{{ $key }}][title]" placeholder="Title" value="{{ $row->title }}" /><br/>
                                                    <label>Additional Description</label>
                                                    <textarea type="text" autocomplete="off" class="form-control"  name="old_additional_info[{{ $key }}][description]" placeholder="Contents" >{{ $row->description }}</textarea><br/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <a class="btn btn-primary btn-lg cloner" x-ref="this" style="border-radius: 12px; display:none" href="javascript:void(0);">Add</a>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-md-12 clone_it" style="margin-bottom:10px;">
                                        <div class="card border">
                                            <div class="card-header bg-success">
                                                <div>
                                                    <div class="text-white">Additional Info #<span class="count">1</span></div>
                                                    <small class="float-sm-right"><a href="" class="btn btn-danger btn-sm deleteitem text-white rounded-circle">X</a></small>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                            <input type="hidden" name="old_additional_info[1][id]" /><br/>
                                            <label>Additional Title</label>
                                            <input type="text" autocomplete="off" class="form-control" name="old_additional_info[1][title]" placeholder="Title" value="{{ old('old_additional_info.1.title') }}"  /><br/>
                                            <label>Additional Contents</label>
                                            <textarea type="text" autocomplete="off" class="form-control" name="old_additional_info[1][description]" placeholder="Contents"  >{{ old('old_additional_info.1.description') }}</textarea><br/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <a class="btn btn-primary btn-lg cloner" style="border-radius:12px; display:none" href="" x-ref="this">Add</a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div>
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
<script>
    function check(main){
        event.preventDefault();
        var key=parseInt(main.dataset.info);
        var id=parseInt(main.dataset.id);
        var row=parseInt(main.dataset.row);
        var type=(main.dataset.type);
        var name= document.getElementsByClassName("removeData")[key-1];
        if(key!=id){
            $(document).ready(function(){
                $(main).closest('.'+type).remove()
            });
        }else
        {
            var result = confirm("Are you sure you want to delete this item");
            if (result) {
                if(type=='cdate'){
                    window.location.href = "{{ url('/croom/packages/deleteCommenceDate') }}"+'/'+row;
                }else if(type=='iti'){
                    window.location.href = "{{ url('/croom/packages/deleteAddIt') }}"+'/'+row;
                }else{
                    window.location.href = "{{ url('/croom/packages/deleteAddInfo') }}"+'/'+row;
                }
            }
        }
    }
 </script>
@endsection

@section('page-title') Edit Package @endsection
