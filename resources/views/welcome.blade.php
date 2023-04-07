@extends('layouts.app')
@section('breadcrumb')
<div class="hero-wrap js-fullheight" style="background-image: url('images/bg_1.jpg');">
	<div class="hero-wrap__shadow js-fullheight"></div>
	<div class="overlay"></div>
	<div class="container">
		<div class="row no-gutters slider-text js-fullheight align-items-center justify-content-start"
			data-scrollax-parent="true">
			<div class="col-md-9 ftco-animate" data-scrollax=" properties: { translateY: '70%' }">
				<h1 class="mb-4" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }"><strong>Plan Your Next Big<br></strong>
					Trip In Installments</h1>
				<p data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">Find great places to Travel, Experiences To Remember</p>
				<div class="block-17 my-4">
					<form action="" method="post" class="d-block d-flex">
						<div class="fields d-block d-flex">
							<div class="textfield-search" style="width:100%">
								<input type="text" class="form-control" placeholder="Ex: Gosaikunda, Tilicho">
							</div>
						</div>
						<input type="submit" class="search-submit btn btn-primary" value="Search">
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('content')

	<section class="ftco-section services-section bg-light">
		<div class="container">
			<div class="row d-flex mt-4">
				<div class="col-12 col-md-4 d-flex align-self-stretch ftco-animate">
					<div class="media block-6 services d-block text-center">
						<div class="d-flex justify-content-center">
							<div class="icon"><i class="icon-compass"></i></div>
						</div>
						<div class="media-body p-2 mt-2">
							<h3 class="heading mb-2">Choose a Destination</h3>
							<p>A small river named Duden flows by their place and supplies.</p>
						</div>
					</div>
				</div>
				<div class="col-12 col-md-4 d-flex align-self-stretch ftco-animate">
					<div class="media block-6 services d-block text-center">
						<div class="d-flex justify-content-center">
							<div class="icon"><i class="icon-credit-card"></i></div>
						</div>
						<div class="media-body p-2 mt-2">
							<h3 class="heading mb-2">Pay in Installments</h3>
							<p>A small river named Duden flows by their place and supplies.</p>
						</div>
					</div>
				</div>
				<div class="col-12 col-md-4 d-flex align-self-stretch ftco-animate">
					<div class="media block-6 services d-block text-center">
						<div class="d-flex justify-content-center">
							<div class="icon"><i class="icon-plane"></i></div>
						</div>
						<div class="media-body p-2 mt-2">
							<h3 class="heading mb-2">Travel</h3>
							<p>A small river named Duden flows by their place and supplies.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		</div>
	</section>
	@if(count($featured)>0)
	<section class="ftco-section ftco-destination">
		<div class="container">
			<div class="row justify-content-start mt-3 pb-3">
				<div class="col-md-7 heading-section ftco-animate">
					<h2 class="mb-4"><strong>Featured</strong> Destination</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="destination-slider owl-carousel ftco-animate">
						@foreach($featured as $ft)
						<div class="item">
							<div class="destination">
								<a href="{{route('singlePackage',['slug'=>$ft['slug']])}}" class="img d-flex justify-content-center align-items-center"
									style="background-image: url({{$ft['images']}});">
									<div class="icon d-flex justify-content-center align-items-center">
										<span class="icon-search2"></span>
									</div>
								</a>
								<div class="text p-3">
									<h3><a href="{{route('singlePackage',['slug'=>$ft['slug']])}}">{{$ft['title']}}</a></h3>
									<span class="listing">{{$ft['duration']}} Days</span>
								</div>
							</div>
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</section>
	@endif
	@if(count($top)>0)
	<section class="ftco-section bg-light">
		<div class="container">
			<div class="row justify-content-start mt-3 pb-3">
				<div class="col-md-7 heading-section ftco-animate">
					<h2 class="mb-4"><strong>Top</strong> Tour Packages</h2>
				</div>
			</div>
		</div>
		<div class="container-fluid">
			<div class="row">
				@foreach ($top as $package)
				<div class="col-sm col-md-6 col-lg ftco-animate">
					<div class="destination">
						<a href="{{route('singlePackage',['slug'=>$package['slug']])}}" class="img img-2 d-flex justify-content-center align-items-center" style="background-image: url({{$package['images']}});">
							<div class="icon d-flex justify-content-center align-items-center">
								<span class="icon-search2"></span>
							</div>
						</a>
						<div class="text p-3">
							<div class="d-flex">
								<div class="one">
									<h3><a href="{{route('singlePackage',['slug'=>$package['slug']])}}">{{$package['title']}}</a></h3>
								</div>
							</div>
							<p>{{$package['description']}}</p>
							<p class="days"><span>{{$package['duration']}} days</span></p>
							<hr>
							<p class="bottom-area d-flex">
								<span><i class="icon-map-o"></i> {{$package['destination']}}</span>
								<span class="ml-auto"><a href="{{route('singlePackage',['slug'=>$package['slug']])}}">Discover</a></span>
							</p>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</section>
	@endif
	<section class="ftco-section ftco-counter img" id="section-counter" style="background-image: url(images/bg_1.jpg);">
		<div class="container">
			<div class="row justify-content-center mb-5 pb-3">
				<div class="col-md-7 text-center heading-section heading-section-white ftco-animate">
					<h2 class="mb-4">Some fun facts</h2>
					<span class="subheading">More than 100,000 websites hosted</span>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-10">
					<div class="row">
						<div class="col-md-3 d-flex justify-content-center counter-wrap ftco-animate">
							<div class="block-18 text-center">
								<div class="text">
									<strong class="number" data-number="100000">0</strong>
									<span>Happy Customers</span>
								</div>
							</div>
						</div>
						<div class="col-md-3 d-flex justify-content-center counter-wrap ftco-animate">
							<div class="block-18 text-center">
								<div class="text">
									<strong class="number" data-number="40000">0</strong>
									<span>Destination Places</span>
								</div>
							</div>
						</div>
						<div class="col-md-3 d-flex justify-content-center counter-wrap ftco-animate">
							<div class="block-18 text-center">
								<div class="text">
									<strong class="number" data-number="87000">0</strong>
									<span>Hotels</span>
								</div>
							</div>
						</div>
						<div class="col-md-3 d-flex justify-content-center counter-wrap ftco-animate">
							<div class="block-18 text-center">
								<div class="text">
									<strong class="number" data-number="56400">0</strong>
									<span>Restaurant</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	@if(count($special_offers)>0)
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-start mt-3 pb-3">
				<div class="col-md-7 heading-section ftco-animate">
					<h2 class="mb-4"><strong>Special Offers</strong></h2>
				</div>
			</div>
		</div>
		<div class="container-fluid">
			<div class="row">
				@foreach ($special_offers as $package)
				<div class="col-sm col-md-6 col-lg ftco-animate">
					<div class="destination">
						<a href="{{route('singlePackage',['slug'=>$package['slug']])}}" class="img img-2 d-flex justify-content-center align-items-center" style="background-image: url({{$package['images']}});">
							<div class="icon d-flex justify-content-center align-items-center">
								<span class="icon-search2"></span>
							</div>
						</a>
						<div class="text p-3">
							<div class="d-flex">
								<div class="one">
									<h3><a href="{{route('singlePackage',['slug'=>$package['slug']])}}">{{$package['title']}}</a></h3>
								</div>
							</div>
							<p>{{$package['description']}}</p>
							<p class="days"><span>{{$package['duration']}} days</span></p>
							<hr>
							<p class="bottom-area d-flex">
								<span><i class="icon-map-o"></i> {{$package['destination']}}</span>
								<span class="ml-auto"><a href="{{route('singlePackage',['slug'=>$package['slug']])}}">Discover</a></span>
							</p>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</section>
	@endif
@endsection
