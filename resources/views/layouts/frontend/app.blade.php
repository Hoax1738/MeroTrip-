<!DOCTYPE html>
<html lang="en">
<head>
	<title>@hasSection('title') @yield('title') @else Mero Trip  @endif</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="icon" type="image/png" href="{{ asset('icons/tab-icon.png') }}">
	<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Arizonia&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet" type="text/css"/>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="{{asset('css/frontcss/animate.css')}}">
	<link rel="stylesheet" href="{{asset('css/frontcss/material-dashboard.css')}}">
	<link rel="stylesheet" href="{{asset('css/frontcss/owl.carousel.min.css')}}">
	<link rel="stylesheet" href="{{asset('css/frontcss/owl.theme.default.min.css')}}">
	<link rel="stylesheet" href="{{asset('css/frontcss/magnific-popup.css')}}">
	<link rel="stylesheet" href="{{asset('css/frontcss/bootstrap-datepicker.css')}}">
	<link rel="stylesheet" href="{{asset('css/frontcss/jquery.timepicker.css')}}">
	<link rel="stylesheet" href="{{asset('css/frontcss/flaticon.css')}}">
	<link rel="stylesheet" href="{{asset('css/frontcss/style.css')}}">
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.css" />
	<link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials-theme-flat.css" />

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.min.js"></script>
	<script src="{{ asset('usertour/dknotus-tour.js') }}"></script>
	@yield('slider')
    <link rel="stylesheet" href="{{ url('/css/dev.css') }}">
    @include('contents.gtag')

</head>
<body>
	@include('layouts.frontend.navbar')
	@yield('content')
	@include('layouts.frontend.contact_div')
	@include('layouts.frontend.footer')

	<script src="{{asset('js/frontjs/jquery-migrate-3.0.1.min.js')}}"></script>
	<script src="{{asset('js/frontjs/popper.min.js')}}"></script>
	<script src="{{asset('js/frontjs/bootstrap.min.js')}}"></script>
	<script src="{{asset('js/frontjs/jquery.easing.1.3.js')}}"></script>
	<script src="{{asset('js/frontjs/jquery.waypoints.min.js')}}"></script>
	<script src="{{asset('js/frontjs/jquery.stellar.min.js')}}"></script>
	<script src="{{asset('js/frontjs/owl.carousel.min.js')}}"></script>
	<script src="{{asset('js/frontjs/jquery.magnific-popup.min.js')}}"></script>
	<script src="{{asset('js/frontjs/jquery.animateNumber.min.js')}}"></script>
	<script src="{{asset('js/frontjs/bootstrap-datepicker.js')}}"></script>
	<script src="{{asset('js/frontjs/scrollax.min.js')}}"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
	<script src="{{asset('js/frontjs/google-map.js')}}"></script>
	<script src="{{asset('js/frontjs/main.js')}}"></script>
</body>
</html>
