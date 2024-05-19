@extends('User.lay')

@section('title' , __(''))

@section('style')

    <script>
        // window.history.forward();


    </script>
@endsection

@section('content')
    <div class="nk-block nk-block-middle nk-auth-body  wide-xs">

        <div class="card card-bordered">
            <div class="card-inner card-inner-lg">
                <div class="nk-block-head">
                    <div class="nk-block-head-content">
                        <h4 class="nk-block-title text-center" style="color: #b78600;">Hotel Table Ordering</h4>
                        <div class="nk-block-des">
                            <p>{{--Access the Dashlite panel using your email and passcode.--}}</p>
                        </div>
                    </div>
                </div>


                <form id="reservation-form" method="POST" action="{{ route('resturent/table/order',[$table->id]) }}">
                    @csrf
                    <div class="row justify-content-center">
                        <div class="col-4">
                            <img class="img" src="{{ asset('images/ravanlogo.jpg') }}"  alt="logo">
                        </div>
                    </div>
                    <input type="hidden" name="hotel_id" value="{{$table->hotel_id}}">
                    <input type="hidden" name="table_id" value="{{$table->id}}">


                    <div class="form-group">
                        <div class="form-label-group">
                            <label for="full-name" class="form-label">First Name</label>
                        </div>
                        <div class="form-control-wrap">
                            <input type="text" id="first-name" name="first-name" class="form-control" placeholder="Enter your first name" required autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <label for="full-name" class="form-label">Last Name</label>
                        </div>
                        <div class="form-control-wrap">
                            <input type="text" id="last-name" name="last-name" class="form-control" placeholder="Enter your last name" required>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="form-label-group">
                            <label for="email" class="form-label">Email Address</label>
                        </div>
                        <div class="form-control-wrap">
                            <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email address" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <label for="whatsapp-number" class="form-label">WhatsApp Number</label>
                        </div>
                        <div class="form-control-wrap">
                            <input type="tel" id="whatsapp-number" name="whatsapp-number" class="form-control" placeholder="Enter your WhatsApp number (include country code)" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" id="submit-btn" class="btn btn-lg btn-primary btn-block">Submit</button>
                    </div>

                </form>

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
