@extends('croom.layouts.main')
@section('content')

<form method="post" enctype="multipart/form-data">
    @csrf
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">New Package <span class="text-danger">(* Indicates The Fields Are Required)</span></div>
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
                            <label>Package Name</label>
                            <div class="col-sm-12 input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text text-danger">*</div>
                                </div>
                                <input type="text" autocomplete="off" class="form-control" name="title" placeholder="Package Name"  value="{{old('title')}}" required/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label>Package Description</label>
                            <div class="col-sm-12">
                                <textarea type="text" autocomplete="off" class="form-control" name="description" placeholder="Package Description" >{{ old('description') }}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Package Destination</label>
                            <div class="col-sm-12 input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text text-danger">*</div>
                                </div>
                                <input type="text" autocomplete="off" class="form-control" name="destination" placeholder="Package Destination"  value="{{old('destination')}}" required/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label>Highlights</label>
                            <div class="col-sm-12">
                                <textarea type="text" autocomplete="off" class="form-control" name="highlights" placeholder="Highlights" >{{old('highlights')}}</textarea>
                            </div>
                        </div>
                        <label class="form-check-label" for="flexCheckIndeterminate">
                            Recomended tags:
                             @foreach ($menu_tags as $menu_tag)
                                {{$menu_tag->title}},
                             @endforeach
                        </label>
                        <div class="form-group">
                            <div class="col-sm-12 input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text text-danger py-3">*</div>
                                </div>
                                <textarea type="text" autocomplete="off" class="form-control" name="tags" placeholder="Package tags" required >{{old('tags')}}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label>Inclusions</label>
                            <div class="col-sm-12">
                                <textarea type="text" autocomplete="off" class="form-control" name="inclusions" placeholder="Package Inclusions">{{old('inclusions')}}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label>Exclusions</label>
                            <div class="col-sm-12">
                                <textarea type="text" autocomplete="off" class="form-control" name="exclusions" placeholder="Package Exclusions">{{old('exclusions')}}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label>Travel Options</label>
                            <div class="col-sm-12">
                                <input type="text" autocomplete="off" class="form-control" name="travel_option" placeholder="Travel Options"  value="{{old('travel_option')}}"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label>Duration in Days</label>
                            <div class="col-sm-12 input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text text-danger">*</div>
                                </div>
                                <input type="number" autocomplete="off" class="form-control" name="duration" placeholder="Duration in Days" required value="{{old('duration')}}"/>
                            </div>
                        </div>

                        {{-- <label class="form-check-label" for="flexCheckIndeterminate">
                           Embedded Google map
                        </label> --}}

                        {{-- <div class="form-group row">
                            <div class="col-sm-12">
                                <textarea type="text" autocomplete="off" class="form-control" name="map_link" placeholder="Map Link ">{{old('map_link')}}</textarea>
                            </div>
                        </div> --}}

                        <div class="form-group row">
                            <div class="col-sm-12">
                                <div class="form-check">
                                    <input class="form-check-input" name="featured" type="checkbox" value="1" @if(old('featured')==1) checked @endif/>
                                    <label class="form-check-label">
                                        Make Featured
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <div class="form-check">
                                    <input class="form-check-input" name="special_offer" type="checkbox" value="1" @if(old('special_offer')==1) checked @endif/>
                                    <label class="form-check-label">
                                        Add To Special Offers
                                    </label>
                                </div>
                            </div>
                        </div>
                        <hr>
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
                                                <small class="float-sm-right"><a href="" class="btn btn-danger btn-sm deleteitem text-white rounded-circle" style="display: none">X</a></small>
                                            </div>    
                                        </div>
                                        <div class="card-body input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text text-danger">*</div>
                                            </div>
                                            <input type="file" name="package_img[image][]" class="form-control" accept=".png, .jpg, .jpeg" required multiple/>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-md-2">
                                    <a class="btn btn-primary btn-lg cloner" x-ref="this" style="border-radius: 12px; display:none" href="javascript:void(0);">Add</a>
                                </div> --}}
                            </div>
                        </div>

                            <hr>
                        <div x-data>
                            Commences Date
                            <a style="cursor: pointer; float:right;border-radius: 12px" x-on:click="$refs.this.click();" class="btn btn-primary">Add </a>
                            <br/><br/>
                            <div class="row top_level">
                                <div class="col-md-4 clone_it" style="margin-bottom:10px;">
                                    <div class="card border">
                                        <div class="card-header bg-success">
                                            <div class="d-flex justify-content-between">
                                                <div class="text-white">Commence Date #<span class="count">1</span></div>
                                                <small class="float-sm-right"><a href="" class="btn btn-danger btn-sm deleteitem text-white rounded-circle" style="display: none">X</a></small>
                                            </div>    
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label>Commence Date</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text text-danger">*</div>
                                                    </div>
                                                    <input type="date" autocomplete="off" class="form-control" name="commence_dates[1][commence_date]" placeholder="Commence Date" required  value="{{ old('commence_dates.1.commence_date') }}"/><br/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Maxiumum People</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text text-danger">*</div>
                                                    </div>
                                                    <input type="number" autocomplete="off" class="form-control" name="commence_dates[1][max_per_commence]" placeholder="Maximum People" value="{{ old('commence_dates.1.max_per_commence') }}"required/><br/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Package Price</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text text-danger">*</div>
                                                    </div>
                                                    <input type="number" autocomplete="off" class="form-control" name="commence_dates[1][price]" placeholder="Package Price" value="{{ old('commence_dates.1.price') }}" required/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <a class="btn btn-primary btn-lg cloner" x-ref="this" style="border-radius: 12px; display:none" href="">Add</a>
                                </div>
                            </div>
                        </div>

                        {{-- <hr>
                        <div x-data>
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

                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text text-danger">*</div>
                                                    </div>
                                        <input type="text" autocomplete="off" class="form-control" name="itinerary[1][title]" placeholder="Day Title" value="{{ old('itinerary.1.title') }}" required/><br/>
                                                </div>
                                            </div>
                                        <textarea type="text" autocomplete="off" class="form-control" name="itinerary[1][inclusions]" placeholder="Day Inclusions">{{ old('itinerary.1.inclusions') }}</textarea><br/>
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
                                                        <input type="file" name="itinerary[1][image][1]" class="form-control" accept="image/png, image/jpeg"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <a class="btn btn-warning btn-lg cloner imgcloner" style="border-radius:12px" href="javascript:void(0);">Add</a>
                                            </div>
                                        </div>
                                        <hr>
                                        <textarea type="text" autocomplete="off" class="form-control" name="itinerary[1][description]" placeholder="Description">{{ old('itinerary.1.description') }}</textarea><br/>
                                        <textarea type="text" autocomplete="off" class="form-control" name="itinerary[1][key_activities]" placeholder="Key Activities">{{ old('itinerary.1.key_activities') }}</textarea><br/>
                                        <textarea type="text" autocomplete="off" class="form-control" name="itinerary[1][destination_place]" placeholder="Destination Place">{{ old('itinerary.1.destination_place') }}</textarea><br/>
                                        <input type="hidden" class="end_of_day" name="itinerary[1][end_of_day]" value="{{ old('itinerary.1.end_of_day') }}" />
                                        <input type="text" autocomplete="off" class="form-control" name="hotel_search" placeholder="End of Day (Hotel/Tent/Checkout)" required/>
                                        <div class="hotel_list">Please select one:<ul></ul></div>
                                        <small>Can't find the hotel you're looking for? <a href="{{route('croom.hotels.add')}}" target="_blank">Please add</a></small><br/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <a class="btn btn-primary btn-lg cloner" style="border-radius:12px; display:none" x-ref="this" href="javascript:void(0);">Add</a>
                                </div>
                            </div>
                        </div>
                        <hr> --}}
                        <div x-data>
                            Additional Information
                            <a style="cursor: pointer; float:right;border-radius: 12px" x-on:click="$refs.this.click()" class="btn btn-primary">Add </a>
                            <br/><br/>
                            <div class="row top_level">
                                <div class="col-md-12 clone_it" style="margin-bottom:10px;">
                                    <div class="card border">
                                        <div class="card-header bg-success">
                                            <div class="d-flex justify-content-between">
                                                <div class="text-white">Additional Info #<span class="count">1</span></div>
                                                <small class="float-sm-right"><a href="" class="btn btn-danger btn-sm deleteitem text-white rounded-circle" style="display: none">X</a></small>
                                            </div>    
                                        </div>
                                        <div class="card-body">
                                        <label>Additional Title</label>
                                        <input type="text" autocomplete="off" class="form-control" name="additional_info[1][title]" placeholder="Title" value="{{ old('additional_info.1.title') }}" /><br/>
                                        <label>Additional Contents</label>
                                        <textarea type="text" autocomplete="off" class="form-control" name="additional_info[1][description]" placeholder="Contents" >{{ old('additional_info.1.description') }}</textarea><br/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <a class="btn btn-primary btn-lg cloner" style="border-radius:12px; display:none" href="" x-ref="this">Add</a>
                                </div>
                            </div>
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

@section('page-title') New Package @endsection

