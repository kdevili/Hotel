@extends('User.lay')

@section('title' , __(''))

@section('style')

    <script>
        window.history.forward();


    </script>
@endsection

@section('content')
    <div class="nk-block nk-block-middle nk-auth-body  wide-xs">

        <div class="card card-bordered">
            <div class="card-inner card-inner-lg">
                <div class="nk-block-head">
                    <div class="nk-block-head-content">
                        <h4 class="nk-block-title text-center" style="color: #b78600;">Hotel Reservation</h4>
                        <div class="nk-block-des">
                            <p>{{--Access the Dashlite panel using your email and passcode.--}}</p>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-4">
                        <img class="img" src="{{ asset('images/ravanlogo.jpg') }}"  alt="logo">
                    </div>
                </div>
                <br>
                <br>
                <div class="text-center">
                    <h3 style="color: #016d01;">Thank you for your registration !</h3>
                    <p class="mt-3">Following Wi-Fi passcode has been sent to your email <span style="color: #b78600;">{{$reservation->email}}</span> </p>
{{--                    <button class="btn btn-primary">Back Home</button>--}}
                </div>
                <br>
                <br>
                <div class="text-center">


                </div>
                <div class="row">
                    @if($reservation->room_type1 == 'Booked')
                    <div class="col-12 text-center">
                        <h6 class="nk-block-title text-center" style="color: #b78600;">Cabana room wifi Passcode</h6>
                        <img class="img w-50" src="{{ asset('images/Ravan Cabana.png') }}"  alt="logo">
                        <p class="pb-0 text-black">Wifi Network : Ravan Cabana <br> Password : ravan@2023cb</p>
                    </div>
                    @endif
                        @if($reservation->room_type3 == 'Booked' or $reservation->room_type2 == 'Booked' )

                        <a class="p-5"></a>
                    <div class="col-12 text-center">
                        <h6 class="nk-block-title text-center" style="color: #b78600;">Deluxe room wifi Passcode</h6>
                        <img class="img w-50" src="{{ asset('images/Ravan Delux.png') }}"  alt="logo">
                        <p class="pb-0 text-black">Wifi Network : Ravan Deluxe <br> Password : ravan@2023ul1</p>
                    </div>
                        @endif

                </div>
{{--                <div class="form-note-s2 text-center pt-4">Already on our platform? <a href="{{ route('login') }}">Login</a>--}}
{{--                </div>--}}
{{--                <div class="text-center pt-4 pb-3">--}}
{{--                    <h6 class="overline-title overline-title-sap"><span>OR</span></h6>--}}
{{--                </div>--}}
{{--                <ul class="nav justify-center gx-4">--}}
{{--                    <li class="nav-item"><a class="nav-link" href="#">Facebook</a></li>--}}
{{--                    <li class="nav-item"><a class="nav-link" href="#">Google</a></li>--}}
{{--                </ul>--}}
            </div>
        </div>
    </div>

@endsection
@section('script')

    <script>
        $(document).ready(function(){
            // set default value for checking date input field
            var today = new Date().toISOString().substr(0, 10);
            $("#check-in-date").val(today);

            // handle changes to the country select field
            $("#country").on("change", function(){
                var selectedCountry = $(this).val();
                if (selectedCountry === "Sri Lanka") {
                    // hide passport number input field
                    $("#passport-number").prop('required',false);
                } else {
                    // show passport number input field
                    $("#passport-number").prop('required',true);

                }
            });
        });
    </script>
@endsection
