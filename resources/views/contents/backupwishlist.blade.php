@extends('layouts.frontend.app')
@section('title') {{ __('My WishList').' - Tripkhata®' }}@endsection
@section('content')

<section class="content">
        <section class="ftco-section ftco-no-pb contact-section mb-5">
            <div class="container">
                <div class="row justify-content-center pb-4">
                    <div class="col-md-6 heading-section text-center ftco-animate">
                        <h2> {{ __('My WishList') }}</h2>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 bg-light rounded shadow-sm mb-5">
                      <!-- Shopping cart table -->
                      <div class="table-responsive">
                        <table class="table">
                          <thead>
                            <tr>
                              <th scope="col" class="border-0 bg-light">
                                {{ __('S.N ') }}
                              </th>

                              <th scope="col" class="border-0 bg-light">
                                 {{ __('Details') }}
                              </th>

                              <th scope="col" class="border-0 bg-light">
                                 {{ __('Option') }}</div>
                              </th>

                              <th scope="col" class="border-0 bg-light">
                                {{ __('Highlights ') }}
                              </th>

                              <th scope="col" class="border-0 bg-light">
                                {{ __('Action ') }}
                              </th>
                            </tr>
                          </thead>
                          <tbody>
                            @forelse($lists as $key=>$row)
                            <tr>
                              <td class="border-0 align-middle pr-4"><strong>{{ ++$key }}</strong></td>
                              <th scope="row" class="border-0">
                                <?php
                                    $images=explode(',',$row->images);
                                ?>
                                <div class="p-2">
                                  <img src="{{ $images[0] }}" alt="" width="70" class="img-fluid rounded shadow-sm">
                                  <div class="ml-1 mt-1 d-inline-block align-middle">
                                    <h5 class="mb-0"> <a href="{{ route('singlePackage',['slug'=>$row->slug]) }}" class="text-dark d-inline-block align-middle">{{ __($row->title) }}</a></h5><span class="text-muted font-weight-normal font-italic d-block">Inclusions: {{ __($row->inclusions) }}</span>
                                  </div>
                                </div>
                              </th>
                              <td class="border-0 align-middle"><strong>{{__($row->travel_option) }}</strong></td>
                              <td class="border-0 align-middle"><strong>{{__($row->highlights)}}</strong></td>
                              <td class="border-0 align-middle"><a href="{{ route('saveWishList',['id'=>$row->id,'slug'=>'null','status'=>'stored']) }}" class="text-dark"><i class="fa fa-trash"></i></a></td>
                            </tr>
                           @empty
                                <tr><td class="text-danger" colspan="5">* {{ __('No Records Found ') }}</td>
                           @endforelse

                          </tbody>
                        </table>
                      </div>
                      <!-- End -->
                    </div>
                  </div>
            </div>
        </section>
</section>
@endsection


