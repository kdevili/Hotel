@extends('User.lay')

@section('title' , __(''))

@section('style')


@endsection

@section('content')
    <div class="nk-block nk-block-middle nk-auth-body  wide-xs">

        <div class="card card-bordered">
            <div class="card-inner card-inner-lg">
                <div class="nk-block-head">
                    <div class="nk-block-head-content">
                        <h4 class="nk-block-title text-center" style="color: #b78600;">Hotel Booking</h4>
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
                    <h5>Hi {{$booking_detail->first_name}} {{$booking_detail->last_name}}!</h5>
                    <h6 style="color: #016d01;">Thank you for your booking!</h6>
                    <h6>Your booking ID is <span class="text-warning">{{$booking_detail->id}}</span>.</h6><p>We have received your booking request and will process it shortly. Once approved, you will receive an email confirmation at
    <span class="text-warning">{{$booking_detail->email}}</span>. For any further assistance, please contact us. We look forward to welcoming you!</p>
                    <p class="mt-3"><a href="{{ route('booking_view_new_outside',$booking_detail->hotel_id) }}" id="submit-btn" class="btn btn-md btn-primary btn-block">Go Back Booking!</a></p>
                    {{--                    <button class="btn btn-primary">Back Home</button>--}}
                </div>
                <br>
                <br>
                <div class="text-center">



                </div>

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
