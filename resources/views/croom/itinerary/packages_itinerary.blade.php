@extends('croom.layouts.main')
@section('content')

<div class="table-responsive">
    <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">S.N</th>
            <th scope="col"> Package Name Name</th>
            <th scope="col">Total Duration</th>
            <th scope="col">Action</th>

          </tr>
        </thead>
        <tbody>
            <?php $sn=1; ?>
            @forelse($items as $package)
            <tr>
                <th scope="row">{{$sn++}}</th>
                <td><a href="{{route('singlePackage',['slug'=>$package['slug']])}}">{{$package['title']}}</a></td>
                <td>{{$package['duration']}} days</td>
                <td>
                    <a type="button" class="btn btn-sm btn-outline-secondary" href="{{route('itinerary.add',['id'=>$package['id']])}}">Add Itinerary</a>
                </td>

            </tr>
            @empty
            <tr>
                <td>No Packages  Found</td>
            </tr>
            @endforelse
        </tbody>
      </table>
    </div>

@endsection

@section('page-title') Package Itinerary @endsection
