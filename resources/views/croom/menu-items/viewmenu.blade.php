@extends('croom.layouts.main')
@section('content')
<div class="d-flex flex-row-reverse">
    <a href="{{ route('add-edit-menu')}}" class="float-right btn btn-success text-white " >Add New Menu <i class="me-2 mdi mdi-plus-circle"></i></a>
</div>

<div class="col-sm-12">
    @if(\Session::has('success'))
        <div class="alert alert-success">
            {{\Session::get('success')}}
        </div>
    @endif
</div>

<div class="table-responsive">
    <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">S.N</th>
            <th scope="col">Title</th>
            <th scope="col">Icon</th>
            <th scope="col">link</th>
            <th scope="col">Position</th>
            <th scope="col"></th>


          </tr>
        </thead>
        <tbody>
            <?php $sn=1; ?>
            @forelse($menu_items as $menu_item)
            <tr>
                <th scope="row">{{$sn++}}</th>
                <td>{{$menu_item->title}}</td>
                <td><i class="fas fa-{{$menu_item->icon}}"></i></td>
                <td>{{$menu_item->href}}</td>
                <td>{{$menu_item->position}}</td>
                <td><a class=" btn btn-primary" href="{{route('add-edit-menu',['id'=>$menu_item['id']])}}">Edit</a></td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center;">No Menu Items Found</td>
            </tr>
            @endforelse
        </tbody>
      </table>
    </div>

  @endsection

  @section('page-title') Menu Items @endsection
