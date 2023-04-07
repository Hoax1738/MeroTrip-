@extends('croom.layouts.main')
@section('content')
<style type="text/css">
.deleteitem,.hotel_list{
    display:none;
}
</style>
<form action="{{url('add-edit-itinerary')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Save Itinerary<span class="text-danger"> (* Indicates The Fields Are Required)</span></div>
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
                        <div class="form-group">
                            <div class="col-sm-12 input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text ">Package Title</div>
                                </div>
                                <input type="hidden" autocomplete="off" class="form-control" name="package_id" readonly placeholder="Package Name" value="{{ $packages->id }}" required>
                                <input type="text" autocomplete="off" class="form-control" name="title" readonly placeholder="Package Name" value="{{ $packages->title }}" required>
                            </div>
                        </div>

                        <input type="hidden" name="package_id"  value="{{ $packages->id }}"/>

                        <div x-data="{show:true}">
                            Existing Itinerary
                            <a style="cursor: pointer; float:right;border-radius: 12px" x-on:click="$refs.this.click()" class="btn btn-primary">Add </a>
                            <br/><br/>
                            <div class="row top_level">
                                @if(count($itinerary)>0)
                                    @foreach($itinerary as $key=>$row)
                                        <div class="col-md-12 clone_it iti">
                                            <div class="card border">
                                                <div class="card-header bg-info">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="text-white">Day <span class="count">{{ $key+1 }}</span></div>
                                                        <small><a href="#" class="btn btn-danger btn-sm text-white rounded-circle removeData" name="key" data-id="{{ $key+1 }}" data-row="{{ $row->id }}" data-type="iti" onclick="check(this)" data-info="{{ $key+1 }}">X</a></small>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <input type="hidden" name="old_itinerary[{{ $key }}][id]"  value="{{ $row->id }}"/><br/>
                                                    <div class="form-group ">
                                                        <label>Day Title</label>
                                                        <div class="col-sm-12 input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text text-danger">*</div>
                                                            </div>
                                                             <input type="text" autocomplete="off" class="form-control" name="old_itinerary[{{ $key }}][title]" placeholder="Day Title" value="{{ $row->title }}" required/><br/>
                                                        </div>
                                                    </div>
                                                    <label>Day Inclusions</label>
                                                    <textarea type="text" autocomplete="off" class="form-control" name="old_itinerary[{{ $key }}][inclusions]" placeholder="Day Inclusions">{{ $row->inclusions }}</textarea><br/>
                                                    <label>Day Exclusions</label>
                                                    <textarea type="text" autocomplete="off" class="form-control" name="old_itinerary[{{ $key }}][exclusions]" placeholder="Day Exclusions">{{ $row->exclusions }}</textarea><br/>
                                                    <label>Day Description</label>
                                                    <textarea type="text" autocomplete="off" class="form-control" name="old_itinerary[{{ $key }}][description]" placeholder="Description"  >{{ $row->description }}</textarea><br/>
                                                    <label>Key Activities</label>
                                                    <textarea type="text" autocomplete="off" class="form-control" name="old_itinerary[{{ $key }}][key_activities]" placeholder="Key Activities"  >{{ $row->key_activities }}</textarea><br/>
                                                    <label>Destination Places</label>
                                                    <input type="text" autocomplete="off" class="form-control" name="old_itinerary[{{ $key }}][destination_place]" placeholder="Destination Place" value="{{ $row->destination_place }}" /><br/>
                                                    <label>Choose Image</label>
                                                    <input type="hidden" name="old_itinerary[{{ $key }}][day]" value="{{ $row->day }}">
                                                    <input type="file" class="form-control" name="old_itinerary[{{ $key }}][it_images][]" accept=".png, .jpg, .jpeg" multiple/><br/>

                                                    @if($row->images!=NULL || $row->images!="")
                                                        <div class="imageClone">
                                                            Existing Images
                                                            <br/><br/>
                                                            <div class="d-flex flex-row flex-nowrap overflow-auto">
                                                                <?php $imagesData=explode(",",$row->images);?>
                                                                @forelse($imagesData as $key1=>$data)
                                                                    <div class="col-md-4 old_img mx-2" style="margin-bottom:10px;">
                                                                        <div class="card border">
                                                                            <div class="card-header bg-success">
                                                                                <div class="d-flex justify-content-between">
                                                                                    <div class="text-white">Image #<span class="count">{{ $key1+1 }}</span></div>
                                                                                    <small class="float-sm-right"><a href="{{ route('itinerary.removeImages',['id'=>$row->id,'key'=>$key1]) }}" class="btn btn-danger btn-sm text-white rounded-circle" onclick="return confirm('Are you sure you want to delete this images')" >X</a></small>
                                                                                </div>
                                                                            </div>
                                                                            <div class="card-body">
                                                                                @php $images=\App\Image::find($data); @endphp
                                                                                @if($images!=NULL)
                                                                                    @if($images->drive_id==NULL)
                                                                                        <img src="{{ asset("$images->directory/$images->local_filename") }}" width="100%" style="height:200px"/>
                                                                                    @else
                                                                                        <img src="https://drive.google.com/uc?export=view&id={{$images->drive_id}}" width="100%" style="height:200px"/>
                                                                                    @endif    
                                                                                    <input type="hidden" name="old_itinerary[{{ $key }}][old_it_images][]" value="{{ $data }}">
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @empty
                                                                    <p class="text-danger">* No Images Found</p>
                                                                @endforelse
                                                            </div>
                                                        </div>
                                                     @endif
                                                    {{-- <input type="hidden" class="end_of_day" value="{{ $row->end_of_day }}" name="old_itinerary[{{ $key }}][end_of_day]"/>
                                                    <input type="text" autocomplete="off" class="form-control" name="hotel_search" placeholder="End of Day (Hotel/Tent/Checkout)"/>
                                                    <div class="hotel_list">Please select one:<ul></ul></div>
                                                    <small>Can't find the hotel you're looking for? <a href="{{route('croom.hotels.add')}}" target="_blank">Please add</a></small><br/> --}}
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
                                            <div class="card-header bg-info">
                                                <div class="d-flex justify-content-between">
                                                    <div class="text-white">Day <span class="count">1</span></div>
                                                    <small class="float-sm-right"><a href="" class="btn btn-danger btn-sm deleteitem text-white rounded-circle">X</a></small>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <input type="hidden" name="old_itinerary[1][id]"/><br/>
                                                <div class="form-group">
                                                    <label>Day Title</label>
                                                    <div class="col-sm-12 input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text text-danger">*</div>
                                                        </div>

                                                         <input type="text" autocomplete="off" class="form-control" name="old_itinerary[1][title]" placeholder="Day Title" required value="{{ old('old_itinerary.1.title') }}"/><br/>
                                                    </div>
                                                </div>
                                                <label>Day Inclusions</label>
                                                <textarea type="text" autocomplete="off" class="form-control" name="old_itinerary[1][inclusions]" placeholder="Day Inclusions" >{{ old('old_itinerary.1.inclusions') }}</textarea><br/>
                                                <label>Day Exclusions</label>
                                                <textarea type="text" autocomplete="off" class="form-control" name="old_itinerary[1][exclusions]" placeholder="Day Exclusions" >{{ old('old_itinerary.1.exclusions') }}</textarea><br/>
                                                <label>Day Description</label>
                                                <textarea type="text" autocomplete="off" class="form-control" name="old_itinerary[1][description]" placeholder="Description" >{{ old('old.itinerary.1.description') }}</textarea><br/>
                                                <label>Key Acitivites</label>
                                                <textarea type="text" autocomplete="off" class="form-control" name="old_itinerary[1][key_activities]" placeholder="Key Activities">{{ old('old.itinerary.1.key_activities') }}</textarea><br/>
                                                <label>Destination Places</label>
                                                <textarea type="text" autocomplete="off" class="form-control" name="old_itinerary[1][destination_place]" placeholder="Destination Place">{{ old('old.itinerary.1.destination_place') }}</textarea><br/>
                                                <input type="hidden"  name="old_itinerary[1][day]"/>
                                                <input type="file" class="form-control" name="old_itinerary[1][it_images][]"  accept=".png, .jpg, .jpeg" multiple/><br/>
                                                {{-- <input type="text" autocomplete="off" class="form-control" name="hotel_search" placeholder="End of Day (Hotel/Tent/Checkout)" required/>
                                                <div class="hotel_list">Please select one:<ul></ul></div>
                                                <small>Can't find the hotel you're looking for? <a href="{{route('croom.hotels.add')}}" target="_blank">Please add</a></small><br/> --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <a class="btn btn-primary btn-lg cloner" style="border-radius:12px; display:none" x-ref="this" href="javascript:void(0);">Add</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div>
                            <div class="row">
                                <div class="col-md-12" style="margin-top:10px;">
                                    <input type="submit" class="btn btn-success text-white btn-lg" style="border-radius: 12px" value="Save Itinerary"/>
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

@section('page-title') Save Itinerary @endsection
