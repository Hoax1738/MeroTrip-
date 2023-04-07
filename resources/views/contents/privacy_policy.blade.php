@extends('layouts.frontend.app')
@section('title') Privacy Policy @endsection
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
                        <span class="subheading">{{ __('Privacy Policy') }}</span>
                    </div>
                </div>
                <div class="text-justify">
                    TripKhata is committed to ensuring that your private information remains private. We have created this on-line privacy policy so that you can understand our continuing commitment to ensuring that your information remains secure and private.

                    These guidelines have been developed with the recognition that Internet technologies and legislation are rapidly evolving, and that underlying business models are still not established. Accordingly, guidelines are subject to change. Any such changes will be posted on this page.<br><br>

                    {{-- <h5 class="pt-4">What information does TripKhata collect from me?</h5> --}}

                    <div class="text-jusitfy">i) We collect information in several ways. When making information requests, we ask you for your name, email address, phone number, address and other relevant information needed to make vacation and travel plans.</div><br>

                    {{-- <h5 class="pt-4">How does TripKhata use my information?</h5> --}}

                    <div class="text-jusitfy">ii) In the case of requesting personal information, we will identify the purpose of use thereof and obtain such information only to the extent necessary for conducting business and through a lawful and reasonable manner and will use and/or provide such information only within the limits of the stated purposes.</div><br>

                    {{-- <h5 class="pt-4">With whom does TripKhata share my information?</h5> --}}

                    <div class="text-justify">iii) At TripKhata, when you provide your personal information including name, address, phone number or email address, this information is kept secured and is not divulged to any outside company for use in marketing or solicitation. TripKhata will not sell or rent your personally identifiable information at any time to any one.</div><br>

                    {{-- <h5 class="pt-4">What are the security policies of linked third-party sites?</h5> --}}

                    <div class="text-justify">iv) This web site may contain links to other web sites. Please note that if you click on one of these links, you are moving to a third-party web site. We encourage you to read the privacy statements of these linked sites as their privacy policy may differ from ours. This privacy statement applies solely to information collected by this web site.</div><br>

                    {{-- <h5 class="pt-4">What else should I know about internet security?</h5> --}}

                    <div class="text-justify">v) Unfortunately, no data transmission over the Internet can be guaranteed to be 100% secure. We strive to protect your personal information. TripKhata, however, cannot ensure or warrant the security of any information you transmit to us and any information you submit on-line is done voluntarily and at your own risk. Once we receive your transmission, we make our best effort to ensure its security on our systems.  No personal information is stored on our website to further secure your personal information.</div><br>

                    {{-- <h5 class="pt-4">What is a cookie?</h5>

                    <div class="text-justify">A cookie is a small data file that is stored locally on your computer that allows specific information to be saved and retrieved when the site requires it. Our web site does not employ cookies.</div> --}}

                    {{-- <h5 class="pt-4">How do I contact TripKhata?</h5> --}}

                    <div class="text-justify">vi) Should you have other questions or concerns about this privacy policy or your electronic records maintained by TripKhata, please<a href="/contact" style="text-decoration:underline"> (contact us )</a></div>
                </div>
        </div>
    </section>

</section>


@endsection
