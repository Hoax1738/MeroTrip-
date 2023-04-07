@extends('croom.layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Meta List</div>
                <div class="card-body">
                    <form method="post" action="">
                        @csrf
                        <div class="form-group row">
                            <div class="col-sm-2">
                                <select required name="type" class="form-control">
                                    <option>Select Type</option>
                                    <option value="package_inc">Package Includes</option>
                                    <option value="package_tags">Package Tags</option>
                                    <option value="travel_option">Travel Option</option>
                                    <option value="hotel_inc">Hotel Includes</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <input type="text" required class="form-control" name="name" placeholder="Name">
                            </div>
                            <div class="col-sm-2">
                                <input type="text" required class="form-control" name="slug" placeholder="Slug">
                            </div>
                            <div class="col-sm-5">
                                <input type="text" required class="form-control" name="description" placeholder="Description">
                            </div>
                            <div class="col-sm-1">
                                <input type="submit" class="btn btn-primary" value="Add"/>
                            </div>
                        </div>
                    </form>
                    <table width="100%">
                        <tr>
                            <th>Type</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Description</th>
                        </tr>
                    @forelse ($items as $meta)
                        <tr>
                            <td>{{$meta['type']}}</td>
                            <td>{{$meta['name']}}</td>
                            <td>{{$meta['slug']}}</td>
                            <td>{{$meta['description']}}</td>
                        </tr>
                    @empty
                        <p>No Packages Found</p>
                    @endforelse
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
