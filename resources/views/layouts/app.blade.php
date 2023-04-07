@section('breadcrumb')
<div class="hero-wrap" style="background-image: url('{{ url('images/bg_1.jpg') }}');">
	<div class="hero-wrap__shadow"></div>
	<div class="container">
		<div class="row no-gutters slider-text align-items-center justify-content-center" data-scrollax-parent="true" style="height:460px;">
			<div class="col-md-9 ftco-animate text-center" data-scrollax=" properties: { translateY: '70%' }">
				<p class="breadcrumbs" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">
					<span class="mr-2"><a href="{{ url('/') }}">Home</a></span> <span>Tour</span>
				</p>
				<h1 class="mb-3 bread" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">Page Name</h1>
			</div>
		</div>
	</div>
</div>
@endsection
<!DOCTYPE html>
<html lang="en">

<head>
	<title>{{ config('app.name', 'Trippify') }} - Save for your next big trip</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Alex+Brush" rel="stylesheet">
	<link rel="stylesheet" href="{{ url('css/open-iconic-bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ url('css/animate.css') }}">
	<link rel="stylesheet" href="{{ url('css/owl.carousel.min.css') }}">
	<link rel="stylesheet" href="{{ url('css/owl.theme.default.min.css') }}">
	<link rel="stylesheet" href="{{ url('css/magnific-popup.css') }}">
	<link rel="stylesheet" href="{{ url('css/aos.css') }}">
	<link rel="stylesheet" href="{{ url('css/ionicons.min.css') }}">
	<link rel="stylesheet" href="{{ url('css/bootstrap-datepicker.css') }}">
	<link rel="stylesheet" href="{{ url('css/jquery.timepicker.css') }}">
	<link rel="stylesheet" href="{{ url('css/flaticon.css') }}">
	<link rel="stylesheet" href="{{ url('css/icomoon.css') }}">
	<link rel="stylesheet" href="{{ url('css/style.css') }}">

</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
		<div class="container">
			<a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', 'Mero Trip') }}.</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
				aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="oi oi-menu"></span> Menu
			</button>

			<div class="collapse navbar	" id="ftco-nav">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item"><a href="{{ url('/') }}" class="nav-link">Home</a></li>
					@guest
					<li class="nav-item"><a href="about.html" class="nav-link">About</a></li>
					<li class="nav-item active"><a href="tour.html" class="nav-link">Tour</a></li>
					<li class="nav-item"><a href="contact.html" class="nav-link">Contact</a></li>
					<li class="nav-item"><a href="{{ route('login') }}" class="nav-link"><span>Login</span></a></li>
					<li class="nav-item cta"><a href="{{ route('register') }}" class="nav-link"><span>Register</span></a></li>
					@else
					<li class="nav-item"><a href="{{ route('packages') }}" class="nav-link">Packages</a></li>
					<li class="nav-item"><a href="{{ route('MyCommitments') }}" class="nav-link">My Commitments</a></li>
					<li class="nav-item active"><a href="{{ url('/account') }}" class="nav-link">My Account</a></li>
					<li class="nav-item"><a href="{{ url('/pay') }}" class="nav-link">Make a Payment</a></li>
					<li class="nav-item cta"><a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><span>Logout</span></a></li>
					<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
						@csrf
					</form>
					@endguest
				</ul>
			</div>
		</div>
	</nav>

	@yield('breadcrumb')
	@yield('content')

	<footer class="ftco-footer ftco-bg-dark ftco-section">
		<div class="container">
			<div class="row mb-5">
				<div class="col-md">
					<div class="ftco-footer-widget mb-4">
						<h2 class="ftco-heading-2">{{ config('app.name', 'Mero Trip') }}</h2>
						<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia,
							there live the
							blind texts.</p>
						<ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">
							<li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
							<li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
							<li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
						</ul>
					</div>
				</div>
				<div class="col-md">
					<div class="ftco-footer-widget mb-4 ml-md-5">
						<h2 class="ftco-heading-2">Information</h2>
						<ul class="list-unstyled">
							<li><a href="#" class="py-2 d-block">About</a></li>
							<li><a href="#" class="py-2 d-block">Service</a></li>
							<li><a href="#" class="py-2 d-block">Terms and Conditions</a></li>
							<li><a href="#" class="py-2 d-block">Become a partner</a></li>
							<li><a href="#" class="py-2 d-block">Best Price Guarantee</a></li>
							<li><a href="#" class="py-2 d-block">Privacy and Policy</a></li>
						</ul>
					</div>
				</div>
				<div class="col-md">
					<div class="ftco-footer-widget mb-4">
						<h2 class="ftco-heading-2">Customer Support</h2>
						<ul class="list-unstyled">
							<li><a href="#" class="py-2 d-block">FAQ</a></li>
							<li><a href="#" class="py-2 d-block">Payment Option</a></li>
							<li><a href="#" class="py-2 d-block">Booking Tips</a></li>
							<li><a href="#" class="py-2 d-block">How it works</a></li>
							<li><a href="#" class="py-2 d-block">Contact Us</a></li>
						</ul>
					</div>
				</div>
				<div class="col-md">
					<div class="ftco-footer-widget mb-4">
						<h2 class="ftco-heading-2">Have a Questions?</h2>
						<div class="block-23 mb-3">
							<ul>
								<li><span class="icon icon-map-marker"></span><span class="text">203 Fake St. Mountain
										View, San
										Francisco, California, USA</span></li>
								<li><a href="#"><span class="icon icon-phone"></span><span class="text">+2 392 3929
											210</span></a></li>
								<li><a href="#"><span class="icon icon-envelope"></span><span
											class="text">info@yourdomain.com</span></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer>



	<!-- loader -->
	<div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
			<circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
			<circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10"
				stroke="#F96D00" /></svg></div>
	<script src="{{ url('js/jquery.min.js') }}"></script>
	<script src="{{ url('js/jquery-migrate-3.0.1.min.js') }}"></script>
	<script src="{{ url('js/popper.min.js') }}"></script>
	<script src="{{ url('js/bootstrap.min.js') }}"></script>
	<script src="{{ url('js/jquery.easing.1.3.js') }}"></script>
	<script src="{{ url('js/jquery.waypoints.min.js') }}"></script>
	<script src="{{ url('js/jquery.stellar.min.js') }}"></script>
	<script src="{{ url('js/owl.carousel.min.js') }}"></script>
	<script src="{{ url('js/jquery.magnific-popup.min.js') }}"></script>
	<script src="{{ url('js/aos.js') }}"></script>
	<script src="{{ url('js/jquery.animateNumber.min.js') }}"></script>
	<script src="{{ url('js/bootstrap-datepicker.js') }}"></script>
	<script src="{{ url('js/scrollax.min.js') }}"></script>
	<script src="{{ url('js/main.js') }}"></script>
</body>
</html>
