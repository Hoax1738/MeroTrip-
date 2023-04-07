@if(Auth::check())
    <div class="modal fade" id="ReferModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div id="reviewMsg" class="" style="display: none"></div>
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-user-plus mr-3 p-3" style="color:white; background:#00AF87; border-radius:50%"></i>Share with your friends</h5>
                    <button type="button" id="refClose" class="close text-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="referForm" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="email" class="form-control" id="referEmail" aria-describedby="emailHelp" placeholder="Your Friend's Email Address" name="referEmail">
                            <input type="hidden" name="refId" id="refId" value="{{ Auth::user()->id }}">
                        </div>
                    </form>
                    <hr>
                    {{-- <div class="model-header"><h5 class="modal-title"><i class="fa fa-link mr-3 p-3" style="color:white; background:#bbc5ce; border-radius:50%"></i>Get Link</h5></div>
                    <div class="d-flex flex-row justify-content-between mt-2">
                        <div class="p-2"><span class="text text-dark">Copy the link and paste in the url </span></div>
                         <div class="p-2"><span id="copyLink" onclick="copyURL(this.id,0)" style="color: rgb(68, 94, 199); cursor:pointer">Copy Link</span></div>
                    </div> --}}

                    <div class="p-2"><span class="text text-dark">Copy the link and paste in the url </span></div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="refUrl0" value="{{url('/')}}?ref={{ Auth::user()->id }}">
                        <div class="input-group-append">
                            <span class="input-group-text"><span id="copyLink" onclick="copyURL(this.id,0)" style="color: rgb(68, 94, 199); cursor:pointer">Copy Link</span></span>
                        </div>
                    </div>

                    

                </div>
                <div class="modal-footer">
                    <div class="d-flex justify-content-start"><button type="button" class="btn btn-primary" id="referButton">Send</button></div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function copyURL(cp,number) {
            var copyText = document.getElementById("refUrl"+number);
            copyText.select();
            document.execCommand("copy");
            document.getElementById(cp).innerHTML="Copied!";
            setTimeout(function(){document.getElementById(cp).innerHTML="Copy Link"; }, 2000);
        }
    </script>
@endif

<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light scrolled " id="ftco-navbar">
    <div class="container">
        <a href="{{ url('/') }}" class="navbar-brand"><div style="display: flex;align-items: center;user-select: none;color: black;"><i class="fas fa-dove" style="background: #35E1A1;padding: 10px;margin-right: 5px;border-radius: 50% !important;"></i><div>Mero Trip®</div></div> </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> <i class="fa fa-bars"></i>
        </button>
        @if(Route::current()->getName() != 'homePage')
        <form action="{{ route('search.package') }}" method="POST" id="searchMainForm" class="flex-grow-1 mt-3 mx-5">
            @csrf
            <div class="input-group pb-4">
                <style>
                    .searchMain{
                        background:white;
                    }
                    .form-control{
                        height: 38px !important;
                    }
                </style>
                <input type="text" class="border-right-0 form-control" id="search-main-field" placeholder="Search" style="font-size:14px;" autocomplete="off" name="title">
                <div class="input-group-append">
                    <script>
                        $(document).ready(function(){
                            $('#search-main-field').click(function(){
                                $(".searchMain").css("border", "1px solid black");
                            });

                            $("#search-main-field").focusout(function(){
                                $(".searchMain").css("border",'');
                            });
                        });
                    </script>
                  <a class="input-group-text border-left-0 searchMain" onclick="event.preventDefault();document.getElementById('searchMainForm').submit();"><i class="fas fa-search"></i></a>
                </div>
            </div>
        </form>
        @endif

        <div class="collapse navbar-collapse flex-grow-0" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item {{ request()->is('packages*') ? 'active' : '' }}" ><a href="{{ route('packages') }}" class="nav-link" id="btn1">Packages</a></li>
                @guest
                <li class="nav-item {{ request()->is('register*') ? 'active' : '' }}"><a href="{{ route('register') }}" class="nav-link">Register</a></li>
                <li class="nav-item cta {{ request()->is('login*') ? 'active' : '' }}"><a href="{{ route('login') }}" class="nav-link">Login</a></li>

                @else
                @if(Auth::user()->hasrole('customer'))
                <li class="nav-item {{ request()->is('commitments*') ? 'active' : '' }}"><a href="{{ route('MyCommitments') }}" class="nav-link" id="btn2">Commitments</a></li>
                {{-- <li class="nav-item"><a class="nav-link" data-toggle="modal" data-target="#ReferModal" style="cursor: pointer">Refer a Freind</a></li> --}}

                @endif
                {{-- <li class="nav-item {{ request()->is('pay*') ? 'active' : '' }}"><a href="{{ url('/pay') }}" class="nav-link" id="btn3">Make a Payment</a></li> --}}
                {{-- <li class="nav-item {{ request()->is('account*') ? 'active' : '' }}"><a href="{{ url('/account') }}" class="nav-link">Account</a></li>
                <li class="nav-item {{ request()->is('wishlist*') ? 'active' : '' }}"><a href="{{ url('/wishlist') }}" class="nav-link">My Wishlist</a></li>
                <li class="nav-item {{ request()->is('review*') ? 'active' : '' }}"><a href="{{ url('/review') }}" class="nav-link">Review</a></li> --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php $username= Auth::user()->name; $firstname= explode(' ',trim($username)) ?>
                        @if(Auth::user()->profile_image!=NULL)
                            @php $images=\App\Image::find(auth()->user()->profile_image);@endphp
                            <img @if($images->drive_id==NULL) src="{{url("$images->directory/$images->local_filename")}}" @else src="https://drive.google.com/uc?export=view&id={{$images->drive_id}}" @endif alt="Profile" class="rounded-circle" width="30" height="30" id="pp">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&color=7F9CF5&background=EBF4FF&size=30" alt="Profile" class="rounded-circle"   id="pp">
                        @endif

                        <span class="ml-2">{{ ucfirst($firstname[0])}}</span>
                    </a>

                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @if(Auth::user()->hasrole('customer'))
                            <a href="{{ url('/account') }}" class="dropdown-item" >My Profile</a>
                            <a href="{{ url('/wishlist') }}" class="dropdown-item">My Wishlist</a>
                            <a href="{{ url('/payments') }}" class="dropdown-item">Payment History</a>
                            <a href="{{ url('/review') }}" class="dropdown-item">Review Package</a>
                            <a href="{{ url('/refer') }}" class="dropdown-item">Refer a friend</a>
                            @else
                            <a href="{{ url('/croom') }}" class="dropdown-item">Croom</a>
                         @endif
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    </div>
                </li>
                @endguest
            </ul>
        </div>
    </div>

    <?php
        if(Auth::check()){
            $id=Auth::user()->user_guide;
            $verified=Auth::user()->email_verified_at;
            $type=Auth::user()->hasrole('customer');

        }else{
            $id=1;
            $verified=null;
            $type=null;
        }
    ?>

    <script>
        var isNew='<?php echo $id;?>'
        var isVerified='<?php echo $verified;?>'
        var isCustomer='<?php echo $type;?>'
        $(function(){
            $(this).scrollTop(0);
            if(isNew==0 && isVerified!="" && isCustomer==true){
                if(window.matchMedia("(max-width: 767px)").matches){
                    return false;
                } else{
                Tour.run([
                    {
                    element: $('#btn1'),
                    content: 'All the packages are displayed here and you can easily access by clicking on it.',
                    position: 'bottom',
                    title: 'Packages',
                    },

                    {
                    element: $('#btn2'),
                    content: 'All the active packages are shown in my commitments.',
                    position: 'bottom',
                    title: 'Commitments'

                    },

                    // {
                    // element: $('#btn3'),
                    // content: 'You can make payment from here easily through esewa and khalti.',
                    // position: 'bottom',
                    // title: 'Payments'

                    // },
                ]);

                }
            }else{
                return false;
            }
        });
    </script>

    <script>
        $(document).ready(function(){
            var loggedIn = {{ auth()->check() ? 'true' : 'false' }};
            if(loggedIn==true){
                $( "#referButton" ).click(function( event ) {
                var refId=$('#refId').val();
                var email=$('#referEmail').val();
                var refUrl=$('#refUrl0').val();
                    $.ajax({
                        url:"{{ url('referFriend') }}",
                        method:'POST',
                        data:{
                            _token: "{{ csrf_token() }}",
                            email:email,
                            refId:refId,
                            refUrl:refUrl
                        },
                        success:function(data){
                            if(data.errors){
                                jQuery('#reviewMsg').html('');
                                $("#reviewMsg").attr("class", "");
                                $("#reviewMsg").attr("class", "alert alert-danger");
                                jQuery.each(data.errors, function(key, value){
                                    jQuery('#reviewMsg').show();
                                    jQuery('#reviewMsg').append('<li>'+value+'</li>');
                                });
                            }else{
                                jQuery('#reviewMsg').html('');
                                $("#reviewMsg").attr("class", "");
                                $("#reviewMsg").attr("class", "alert alert-success");
                                jQuery('#reviewMsg').show();
                                $('#referEmail').val('');
                                jQuery('#reviewMsg').append('<li>'+data.success+'</li>');
                            }
                        }
                    });
                });
            }

             $('#refClose').click(function() {
                jQuery('#reviewMsg').hide();
                $('#referEmail').val('');
             });

        });
    </script>
</nav>
