@extends('layouts.frontend.app')
@section('title') Frequently Asked Questions @endsection
@section('content')
<section class="content">
    <section class="ftco-section">
        <div class="container">
            @if (Auth::check())
            @include('contents.emiAlert')
            @endif
            <div>
                <div class="row justify-content-center pb-4">
                    <div class="col-md-12 heading-section text-center ftco-animate">
                        <span class="subheading">{{ __('Frequently Asked Questions') }}</span>
                    </div>
                </div>
                <div id="accordion" role="tablist">
                    <div class="card">
                        <div class="card-header" role="tab" id="header-1">
                            <h5 class="mb-0">
                                <a data-toggle="collapse" href="#collapse-1" aria-expanded="true" aria-controls="collapse-1">
                                    If I book a Tour / Destination / Holiday Package and subsequently want to change to an alternate destination, is it possible?
                                </a>
                            </h5>
                        </div>
                        <div id="collapse-1" class="collapse show" role="tabpanel" aria-labelledby="header-1" data-parent="#accordion">
                            <div class="card-body">
                                Answer: Yes, you can change the tour after the booking 60 days prior to departure date which will again be subject to availability .
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" role="tab" id="header-2">
                            <h5 class="mb-0">
                                <a class="collapsed" data-toggle="collapse" href="#collapse-2" aria-expanded="false" aria-controls="collapseTwo">
                                    Will the Tour / Holiday Package be a Group Tour or Free Independent Travel ?
                                </a>
                            </h5>
                        </div>
                        <div id="collapse-2" class="collapse" role="tabpanel" aria-labelledby="header-2" data-parent="#accordion">
                            <div class="card-body">
                                Answer: We will provide you both the options of choosing to Travel with a Group or as an Individual Family.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" role="tab" id="header-3">
                            <h5 class="mb-0">
                                <a class="collapsed" data-toggle="collapse" href="#collapse-3" aria-expanded="false" aria-controls="collapse-3">
                                    Will you be having fixed departure dates ?
                                </a>
                            </h5>
                        </div>
                        <div id="collapse-3" class="collapse" role="tabpanel" aria-labelledby="header-3" data-parent="#accordion">
                            <div class="card-body">
                                Answer: Yes we will have fixed departure dates. You are free to choose either option of travelling with a Group or as an Individual Family.
                            </div>
                        </div>
                    </div>
                    {{-- <div class="card">
                        <div class="card-header" role="tab" id="header-4">
                            <h5 class="mb-0">
                                <a class="collapsed" data-toggle="collapse" href="#collapse-4" aria-expanded="false" aria-controls="collapse-4">
                                    If I have booked a date one year in advance and if due to some genuine reason I cannot travel on that date – what are the consequences? Will I lose my money ? Will you give us alternate dates at the same cost ?                </a>
                            </h5>
                        </div>
                        <div id="collapse-4" class="collapse" role="tabpanel" aria-labelledby="header-4" data-parent="#accordion">
                            <div class="card-body">
                                Answer: Yes, an alternate date will be provided if your amendment of date comes 60 days prior to your booking date. If you cancel the booking, the booking deposit will be forfeited.
                            </div>
                        </div>
                    </div> --}}


                    <div class="card">
                        <div class="card-header" role="tab" id="header-5">
                            <h5 class="mb-0">
                                <a class="collapsed" data-toggle="collapse" href="#collapse-5" aria-expanded="false" aria-controls="collapse-5">
                                    Are these packages all inclusive cost and there will be no additional charge at the time of Travel?
                                </h5>
                        </div>
                        <div id="collapse-5" class="collapse" role="tabpanel" aria-labelledby="header-5" data-parent="#accordion">
                            <div class="card-body">
                                Answer: Yes, cost will be as per itinerary and the inclusions. Foreign Exchange Rates applicable as on the date of travel. Any change in the tax structure through the Government of Nepal will have to be borne by the customer.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" role="tab" id="header-6">
                            <h5 class="mb-0">
                                <a class="collapsed" data-toggle="collapse" href="#collapse-6" aria-expanded="false" aria-controls="collapse-6">
                                    Can additional persons travel with us on the same departure by paying separately?

                                </h5>
                        </div>
                        <div id="collapse-6" class="collapse" role="tabpanel" aria-labelledby="header-6" data-parent="#accordion">
                            <div class="card-body">
                                Answer: Yes. Subject to availability.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" role="tab" id="header-7">
                            <h5 class="mb-0">
                                <a class="collapsed" data-toggle="collapse" href="#collapse-7" aria-expanded="false" aria-controls="collapse-7">
                                    Will you be having fixed departure dates?
                                </h5>
                        </div>
                        <div id="collapse-7" class="collapse" role="tabpanel" aria-labelledby="header-7" data-parent="#accordion">
                            <div class="card-body">
                                Answer: Yes, departure dates are fixed. However there can be some unavoidable circumstances where we may have to change it. We will inform you as soon as possible about the changes made.
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header" role="tab" id="header-8">
                            <h5 class="mb-0">
                                <a class="collapsed" data-toggle="collapse" href="#collapse-8" aria-expanded="false" aria-controls="collapse-8">
                                    Can my friend join in on the trip by paying all the trip money at once?
                                </h5>
                        </div>
                        <div id="collapse-8" class="collapse" role="tabpanel" aria-labelledby="header-8" data-parent="#accordion">
                            <div class="card-body">
                                Answer:Yes but it is subject to availability.
                            </div>
                        </div>
                    </div>
                </div>
                <p><a href="{{url('/packages')}}" class="btn btn-primary mt-3 py-2 px-4 mb-4">View Trips</a></p>
            </div>
    </section>
</section>
@endsection
