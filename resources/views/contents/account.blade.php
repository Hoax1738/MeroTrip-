@extends('layouts.frontend.app')
@section('title') {{ __('My Account').' - Tripkhata®' }}@endsection
@section('content')

<section class="content">
        <section class="ftco-section ftco-no-pb contact-section mb-5">
            <div class="container">
                @if (Auth::check())
                @include('contents.emiAlert')
                @else
                @endif
                <div class="row justify-content-center pb-4">
                    <div class="col-md-6 heading-section text-center ftco-animate">
                        <h2> {{ __('My Account') }}</h2>
                    </div>
                </div>
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible justify-content-center">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>{{__(session('success'))}}</strong>
                    </div>
                @endif
                @if(session('error'))
                <div class="alert alert-danger alert-dismissible justify-content-center">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>{{__(session('error'))}}</strong>
                </div>
                @endif
                <div class="row">
                    <div class="col-lg-12">
                        <div class="container">
                            <div class="row gutters">
                                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="d-flex flex-column align-items-center text-center">
                                                @if($user->profile_image!=NULL)
                                                    @php $images=\App\Image::find($user->profile_image); @endphp
                                                    <img @if($images->drive_id==NULL) src="{{url("$images->directory/$images->local_filename")}}" @else src="https://drive.google.com/uc?export=view&id={{$images->drive_id}}" @endif alt="Profile" class="rounded-circle" width="130" height="120" id="pp1">
                                                @else
                                                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&color=7F9CF5&background=EBF4FF" alt="Profile" class="rounded-circle" width="150" id="pp1">
                                                @endif

                                                <div class="d-inline-block pt-4">
                                                    <label for="profilephoto"><i class="fa fa-pencil px-2" style="cursor: pointer"></i></label>
                                                    @if($user->profile_image!=NULL)
                                                        <i class="fa fa-trash px-2" style="cursor: pointer" onclick="javascript:if(confirm('Are you sure you want to delete the photo?')){window.location.replace('{{ url('removePhoto') }}'); return false;}"></i>
                                                    @endif
                                                </div>

                                                <div class="mt-3">
                                                  <h4>{{ Auth::user()->name }}</h4>
                                                  <p class="text-secondary mb-1">{{ __('Commited Package') }}: {{$commited_package}}</p>
                                                  <p class="text-muted font-size-sm">{{__($user->address)}}</p>
                                                </div>

                                                <div><button class="btn btn-primary mt-4" style="border-radius:50px" onclick="event.preventDefault; document.getElementById('profileForm').submit();"> {{ __('Save Profile') }}</button></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="row gutters">
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <form action="{{url('/update-profile')}}" enctype="multipart/form-data" method="POST" id="profileForm">@csrf

                                                    <div class="form-group">
                                                        <label for="fullName" class="font-weight-bold">{{ __('Full Name') }}</label>
                                                        <input type="text" class="form-control" name="name" placeholder="Enter Address" value="{{$user->name}}">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label for="eMail" class="font-weight-bold">{{ __('Email') }}</label>
                                                        <p>{{ Auth::user()->email }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                                <div class="row gutters mt-3">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                        <label> {{ __('Address') }}</label>
                                                        <input type="text" class="form-control" name="address" placeholder="Enter Address" value="{{$user->address}}">
                                                    </div>

                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                        <label> {{ __('Contact') }}</label>
                                                        <input type="number" class="form-control" name="contact" placeholder="Enter  Contact" value="{{$user->contact}}">
                                                        @error('contact')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                    </div>
                                                </div>

                                                <div class="row gutters" style="display: none">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                        <label for="profilephoto"> {{ __('Profile Image') }}</label>
                                                        <input type="file" name="profile_image" id="profilephoto" value="{{$user->profile_image}}" onchange="document.getElementById('pp1').src = window.URL.createObjectURL(this.files[0])" accept=".png, .jpg, .jpeg">
                                                        @error('profile_image')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                        <button class="btn btn-primary mt-4" type="submit"> {{ __('Save Profile') }}</button>
                                                    </div>
                                                </div>
                                            </form>

                                            <div class="row ml-1 mt-5">Update Password</div>
                                            <div class="row gutters">
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <form action="{{url('/updatepassword')}}" enctype="multipart/form-data" method="POST"  id="change_password_form">@csrf
                                                    <div class="form-group ml-1">
                                                        <label for="fullName" class="font-weight-bold">{{ __('Old Password') }}</label>
                                                        <input type="password" class="form-control" name="old_password"  id="old_password" placeholder="Enter old password">
                                                        @if($errors->any('old_password'))
		                                                <span class="text-danger">{{$errors->first('old_password')}}</span>
		                                                @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row gutters mt-3">
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <label> {{ __('New Password') }}</label>
                                                    <input type="text" class="form-control" name="new_password" placeholder="Enter New Password"  id="new_password" >
                                                    @if($errors->any('new_password'))
                                                    <span class="text-danger">{{$errors->first('new_password')}}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row gutters mt-3">
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <label> {{ __('Confirm Password') }}</label>
                                                    <input  class="form-control" name="confirm_password" placeholder="Confirm Password" id="confirm_password" >
                                                    @if($errors->any('confirm_password'))
                                                    <span class="text-danger">{{$errors->first('confirm_password')}}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        
                                            <button class="btn btn-primary mt-4" type="submit"> {{ __('Update Password ') }}</button>
                                        </form>


                                            <div class="row ml-1 mt-3">Other Details</div>
                                            <div class="row gutters mt-3">
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <a class="btn btn-outline-dark" style="border-radius:50px" href="{{ route('myPayments') }}"> {{ __('Payment history') }}</a>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <a class="btn btn-outline-dark" style="border-radius:50px" href="{{ route('MyCommitments') }}">{{ __('Committed Packages ') }}</a>
                                                    </div>
                                                </div>

                                            </div>
                                            {{-- <div class="row gutters">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <div class="text-right">
                                                        <button type="button" id="submit" name="submit" class="btn btn-secondary">Cancel</button>
                                                        <button type="button" id="submit" name="submit" class="btn btn-primary">Update</button>
                                                    </div>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
</section>
@endsection
