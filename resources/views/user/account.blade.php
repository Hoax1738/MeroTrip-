@extends('layouts.app')
@section('content')
<style type="text/css">
    .enableditor input[readonly]{
        border:none;
        width:100%;
        margin-bottom:5px;
    }
    .enableditor input[type=text]{
        padding:5px;
        margin-bottom:5px;
        width:100%;
    }
    .enableditor .info{
        color:#0062cc;
        font-size:14px;
        margin-bottom:10px;
    }
</style>
<section class="ftco-section enableditor">
    <div class="container emp-profile">
        <div class="card center-xs p-3">
            <form method="post">
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-img">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS52y5aInsxSm31CvHOFHWujqUx_wWTS9iM6s7BAm21oEN_RiGoog" alt="">
                            <a href="https://gravatar.com" target="_blank" class="file btn btn-sm btn-primary">Change Photo</a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="profile-head">
                        <input type="text" name="name" value="Atish Shakya" style="font-size:28px;" readonly/>
                        <input type="text" name="address" value="Minbhawan, Kathmandu" style="font-size:15px;" readonly/>
                            <h5></h5><br/><br/>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">About</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <input type="button" class="btn btn-primary" id="enableedit" value="Edit">
                        <input type="submit" class="btn btn-success" id="enableeditsubmit" style="display:none" value="Save">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-2 pb-3">
                        <div class="profile-work">
                            <p class="font-weight-bold">Commitments</p>
                            <div class="row">
                                <div class="col-12 py-1 col-md-12"><a class="btn btn-info" href="{{ route('myPayments') }}">Payment history</a></div>
                                <div class="col-12 py-1 col-md-12"><a class="btn btn-info" href="{{ route('MyCommitments') }}">Committed Packages</a></div>
                                <div class="col-12 py-1 col-md-12"><a class="btn btn-info" href="#">Change Password</a></div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="tab-content profile-tab" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>User Id</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="info">1233</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Email</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="info">kshitighelani@gmail.com</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Phone</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="info" name="phone" value="9851161530" style="font-size:14px;" readonly/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Profession</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="info">Web Developer and Designer</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
