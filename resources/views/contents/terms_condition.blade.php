@extends('layouts.frontend.app')
@section('title') Terms and condition @endsection
@section('content')
<section class="content">
    <section class="ftco-section">
        <div class="container">
            @if (Auth::check())
            @include('contents.emiAlert')
            @else
            @endif
            <div>
                <div class="row justify-content-center pb-4">
                    <div class="col-md-12 heading-section text-center ftco-animate">
                        <span class="subheading">{{ __('Terms and condition') }}</span>
                    </div>
                </div>
                <p class="text-justify">
                    <h4 class="font-weight-bold">Cancellation by the clients</h4>
                    <div class="text-justify font-weight-light">
                        Free cancellation before 45 days of the commencement of the package.
                        Only charges deductible would be charges we pay to companies and are non refundable, All such bills shall be submitted to the clients at the time of refund.<br>
                    </div>

                    <h4 class="mt-4 font-weight-bold">Cancellation by the Company</h4>
                    <div class="text-justify font-weight-light">
                        We reserve the right to cancel the contract between us for any reason prior to your payment of the full price of the trip. In this case, we will refund in full any amount that you have already paid us. After you have paid in full, we will only cancel the contract if circumstances beyond our control make it unavoidable. Such circumstances include, but are not limited to, civil or political unrest, terrorism, natural disaster, or other force majeure circumstance. In the unlikely event that such circumstances arise, we will contact you immediately and offer you the choice of equivalent services or a full refund of all monies paid. No additional compensation will be paid over and above the total sum received from you.<br>
                    </div>

                    <h4 class="mt-4 font-weight-bold">Alteration of Itineraries</h4>
                    <div class="text-justify font-weight-light">
                        It is unlikely that the Company will have to make changes to your tour. However, we may occasionally have to make changes either before or after you have booked. Most changes will be minor, and the Company will advise you of them as soon as possible. The Company reserves the right to alter the itinerary after departure, without paying compensation, if it is in your interest to do so. Furthermore, the Company will not pay compensation if it is forced to cancel or in any way change the tour due to force majeure, such as war, riots, civil strike, industrial dispute, terrorist activity, natural or nuclear disaster, fire, adverse weather conditions, or other material external circumstances beyond the Company’s control.
                    </div>    
                </p>
        </div>
    </section>

</section>


@endsection
