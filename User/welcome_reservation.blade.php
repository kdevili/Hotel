@extends('User.lay')

@section('title' , __(''))

@section('style')


@endsection

@section('content')

    <div class="nk-block nk-block-middle nk-auth-body  wide-xs">

        <div class="card card-bordered">
            <div class="card-inner card-inner-lg">
                <div id="google_translate_element"></div>
                <div class="nk-block-head">
                    <div class="nk-block-head-content">
                        <h4 class="nk-block-title text-center">Welcome Ravan Resort!</h4>
                        <div class="nk-block-des">
                            <div class="row justify-content-center">
                                <div class="col-4">
                                    <img class="img" src="{{ asset('images/ravanlogo.jpg') }}"  alt="logo">
                                </div>
                            </div>
                        </div>
                        <h6 class="nk-block-title mt-2">Do you have already booking?</h6>
                        <form id="welcome_reservation_form" method="POST" action="{{ route('welcome/reservation/search_booking') }}">
                        @csrf
                            <input type="hidden" name="hotel_id" value="{{$hotel_id}}">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label for="number" class="form-label"><span class="text-success">Please Enter Your Booking ID</span></label>
                                </div>
                                <div class="form-control-wrap">
                                    <input type="text" id="booking_id" name="booking_id" class="form-control" placeholder="Enter your booking id" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" id="submit-btn" class="btn btn-lg btn-primary btn-block">Search</button>
                            </div>
                        </form>
                        <div class="form-group">
                        <h6 class="nk-block-title mt-3">Is this your first time staying with us?</h6>
                        <a href="{{ route('welcome/checkin/reservation') }}" class="btn btn-lg btn-primary btn-block mt-1">Checkin</a>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')

    <script>
        $(document).ready(function(){
            var myForm = $('#welcome_reservation_form');
            var submitBtn = $('#submit-btn');
            var loadingOverlay = $('#loading-overlay');

            // Add an event listener for the form submission
            myForm.submit(function(event) {
                // Show the dark overlay and loading icon
                loadingOverlay.show();
                showLoading();
            });

            // Add an event listener for the window onload event
            window.onload = function() {
                // Hide the dark overlay and loading icon after all resources have loaded
                hideLoading();
                loadingOverlay.hide();
            };
        });


    </script>
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
        }
    </script>

    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
@endsection
