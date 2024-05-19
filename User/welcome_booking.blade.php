@extends('User.lay')

@section('title' , __(''))

@section('style')

@endsection

@section('content')
    <div class="loading-overlay" id="loading-overlay"></div>
    <div class="loader" id="loader"></div>
    <div class="nk-block nk-block-middle nk-auth-body  wide-xs">

        <div class="card card-bordered">
            <div class="card-inner card-inner-lg">
                <div id="google_translate_element"></div>
                <div class="nk-block-head">
                    <div class="nk-block-head-content">
                        {{--                        <h4 class="nk-block-title text-center">Hotel Booking</h4>--}}
                        <div class="nk-block-des">
                            <div class="row justify-content-center">
                                <div class="col-4">
                                    <img class="img" src="{{ asset('images/ravanlogo.jpg') }}"  alt="logo">
                                </div>
                            </div>
                            <h5 class="text-center mt-3">Hi {{$booking_detail->first_name}} {{$booking_detail->last_name}}</h5>
                            <h6 class="text-center mt-3 text-success">Your Booking ID -  00{{$booking_detail->id}}</h6>
                            <p class="text-center">Please review your Booking!</p>
                        </div>
                    </div>
                </div>

                <form id="welcome_booking" method="POST" action="{{ route('welcome/booking/link_to_reservation_save') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="ep_booking_id" id="ep_booking_id" value="{{$booking_detail->id}}">
                    <input type="hidden" name="ep_checking_date" id="ep_checking_date" value="{{$booking_detail->checking_date}}">
                    <input type="hidden" name="ep_checkout_date" id="ep_checkout_date" value="{{$booking_detail->checkout_date}}">
                    <input type="hidden" name="ep_advance_payment" id="ep_advance_payment" value="{{$booking_detail->advance_payment}}">
                    <input type="hidden" name="ep_total_amount" id="ep_total_amount" value="{{$booking_detail->total_amount}}">
                    <input type="hidden" name="ep_balance" id="ep_balance" value="{{$booking_detail->balance}}">
                    <input type="hidden" name="ep_hotel_id" id="ep_hotel_id" value="{{$booking_detail->hotel_id}}">

                    <h4 class="text-center">General Details</h4>

                        <div class="form-group">
                            <div class="form-label-group">
                                <label for="full-name" class="form-label">First Name</label>
                            </div>
                            <div class="form-control-wrap">
                                <input type="text" id="ep_f_name" name="ep_f_name" class="form-control" value="{{$booking_detail->first_name}}" placeholder="Enter your first name" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-label-group">
                                <label for="full-name" class="form-label">Last Name</label>
                            </div>
                            <div class="form-control-wrap">
                                <input type="text" id="ep_l_name" name="ep_l_name" class="form-control" value="{{$booking_detail->last_name}}" placeholder="Enter your last name" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-label-group">
                                <label for="ep_booking-method" class="form-label">Booking Method</label>
                            </div>
                            <div class="form-control-wrap">
                                <select id="ep_booking_method" name="ep_booking_method" class="form-control" required>
                                    <option value="Online" {{$booking_detail->booking_method == 'Online'?? 'selected'}}>Online</option>
                                    <option value="Phone" {{$booking_detail->booking_method == 'Phone'?? 'selected'}}>Phone</option>
                                    <option value="Walk-in" {{$booking_detail->booking_method == 'Walk-in'?? 'selected'}}>Walk-in</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-label-group">
                                <label for="ep_country" class="form-label">Country</label>
                            </div>
                            <div class="form-control-wrap">
                                <select id="ep_country" name="ep_country" class="form-control js-select2" data-search="on" required>
                                    <option value="Afghanistan">Afghanistan</option>
                                    <option value="Albania">Albania</option>
                                    <option value="Algeria">Algeria</option>
                                    <option value="Andorra">Andorra</option>
                                    <option value="Angola">Angola</option>
                                    <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                    <option value="Argentina">Argentina</option>
                                    <option value="Armenia">Armenia</option>
                                    <option value="Australia">Australia</option>
                                    <option value="Austria">Austria</option>
                                    <option value="Azerbaijan">Azerbaijan</option>
                                    <option value="Bahamas">Bahamas</option>
                                    <option value="Bahrain">Bahrain</option>
                                    <option value="Bangladesh">Bangladesh</option>
                                    <option value="Barbados">Barbados</option>
                                    <option value="Belarus">Belarus</option>
                                    <option value="Belgium">Belgium</option>
                                    <option value="Belize">Belize</option>
                                    <option value="Benin">Benin</option>
                                    <option value="Bhutan">Bhutan</option>
                                    <option value="Bolivia">Bolivia</option>
                                    <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                    <option value="Botswana">Botswana</option>
                                    <option value="Brazil">Brazil</option>
                                    <option value="Brunei">Brunei</option>
                                    <option value="Bulgaria">Bulgaria</option>
                                    <option value="Burkina Faso">Burkina Faso</option>
                                    <option value="Burundi">Burundi</option>
                                    <option value="Cambodia">Cambodia</option>
                                    <option value="Cameroon">Cameroon</option>
                                    <option value="Canada">Canada</option>
                                    <option value="Cape Verde">Cape Verde</option>
                                    <option value="Central African Republic">Central African Republic</option>
                                    <option value="Chad">Chad</option>
                                    <option value="Chile">Chile</option>
                                    <option value="China">China</option>
                                    <option value="Colombia">Colombia</option>
                                    <option value="Comoros">Comoros</option>
                                    <option value="Costa Rica">Costa Rica</option>
                                    <option value="Croatia">Croatia</option>
                                    <option value="Cuba">Cuba</option>
                                    <option value="Cyprus">Cyprus</option>
                                    <option value="Czech Republic">Czech Republic</option>
                                    <option value="Democratic Republic of the Congo">Democratic Republic of the Congo</option>
                                    <option value="Denmark">Denmark</option>
                                    <option value="Djibouti">Djibouti</option>
                                    <option value="Dominica">Dominica</option>
                                    <option value="Dominican Republic">Dominican Republic</option>
                                    <option value="East Timor">East Timor</option>
                                    <option value="Ecuador">Ecuador</option>
                                    <option value="Egypt">Egypt</option>
                                    <option value="El Salvador">El Salvador</option>
                                    <option value="Equatorial Guinea">Equatorial Guinea</option>
                                    <option value="Eritrea">Eritrea</option>
                                    <option value="Estonia">Estonia</option>
                                    <option value="Ethiopia">Ethiopia</option>
                                    <option value="Fiji">Fiji</option>
                                    <option value="Finland">Finland</option>
                                    <option value="France">France</option>
                                    <option value="Gabon">Gabon</option>
                                    <option value="Gambia">Gambia</option>
                                    <option value="Georgia">Georgia</option>
                                    <option value="Germany">Germany</option>
                                    <option value="Ghana">Ghana</option>
                                    <option value="Greece">Greece</option>
                                    <option value="Grenada">Grenada</option>
                                    <option value="Guatemala">Guatemala</option>
                                    <option value="Guinea">Guinea</option>
                                    <option value="Guinea-Bissau">Guinea-Bissau</option>
                                    <option value="Guyana">Guyana</option>
                                    <option value="Haiti">Haiti</option>
                                    <option value="Honduras">Honduras</option>
                                    <option value="Hungary">Hungary</option>
                                    <option value="Iceland">Iceland</option>
                                    <option value="India">India</option>
                                    <option value="Indonesia">Indonesia</option>
                                    <option value="Iran">Iran</option>
                                    <option value="Iraq">Iraq</option>
                                    <option value="Ireland">Ireland</option>
                                    <option value="Israel">Israel</option>
                                    <option value="Italy">Italy</option>
                                    <option value="Ivory Coast">Ivory Coast</option>
                                    <option value="Jamaica">Jamaica</option>
                                    <option value="Japan">Japan</option>
                                    <option value="Jordan">Jordan</option>
                                    <option value="Kazakhstan">Kazakhstan</option>
                                    <option value="Kenya">Kenya</option>
                                    <option value="Kiribati">Kiribati</option>
                                    <option value="Kosovo">Kosovo</option>
                                    <option value="Kuwait">Kuwait</option>
                                    <option value="Kyrgyzstan">Kyrgyzstan</option>
                                    <option value="Laos">Laos</option>
                                    <option value="Latvia">Latvia</option>
                                    <option value="Lebanon">Lebanon</option>
                                    <option value="Lesotho">Lesotho</option>
                                    <option value="Liberia">Liberia</option>
                                    <option value="Libya">Libya</option>
                                    <option value="Liechtenstein">Liechtenstein</option>
                                    <option value="Lithuania">Lithuania</option>
                                    <option value="Luxembourg">Luxembourg</option>
                                    <option value="Madagascar">Madagascar</option>
                                    <option value="Malawi">Malawi</option>
                                    <option value="Malaysia">Malaysia</option>
                                    <option value="Maldives">Maldives</option>
                                    <option value="Mali">Mali</option>
                                    <option value="Malta">Malta</option>
                                    <option value="Marshall Islands">Marshall Islands</option>
                                    <option value="Mauritania">Mauritania</option>
                                    <option value="Mauritius">Mauritius</option>
                                    <option value="Mexico">Mexico</option>
                                    <option value="Micronesia">Micronesia</option>
                                    <option value="Moldova">Moldova</option>
                                    <option value="Monaco">Monaco</option>
                                    <option value="Mongolia">Mongolia</option>
                                    <option value="Montenegro">Montenegro</option>
                                    <option value="Morocco">Morocco</option>
                                    <option value="Mozambique">Mozambique</option>
                                    <option value="Myanmar (Burma)">Myanmar (Burma)</option>
                                    <option value="Namibia">Namibia</option>
                                    <option value="Nauru">Nauru</option>
                                    <option value="Nepal">Nepal</option>
                                    <option value="Netherlands">Netherlands</option>
                                    <option value="New Zealand">New Zealand</option>
                                    <option value="Nicaragua">Nicaragua</option>
                                    <option value="Niger">Niger</option>
                                    <option value="Nigeria">Nigeria</option>
                                    <option value="North Korea">North Korea</option>
                                    <option value="North Macedonia">North Macedonia</option>
                                    <option value="Norway">Norway</option>
                                    <option value="Oman">Oman</option>
                                    <option value="Pakistan">Pakistan</option>
                                    <option value="Palau">Palau</option>
                                    <option value="Palestine">Palestine</option>
                                    <option value="Panama">Panama</option>
                                    <option value="Papua New Guinea">Papua New Guinea</option>
                                    <option value="Paraguay">Paraguay</option>
                                    <option value="Peru">Peru</option>
                                    <option value="Philippines">Philippines</option>
                                    <option value="Poland">Poland</option>
                                    <option value="Portugal">Portugal</option>
                                    <option value="Qatar">Qatar</option>
                                    <option value="Romania">Romania</option>
                                    <option value="Russia">Russia</option>
                                    <option value="Rwanda">Rwanda</option>
                                    <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                    <option value="Saint Lucia">Saint Lucia</option>
                                    <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
                                    <option value="Samoa">Samoa</option>
                                    <option value="San Marino">San Marino</option>
                                    <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                                    <option value="Saudi Arabia">Saudi Arabia</option>
                                    <option value="Senegal">Senegal</option>
                                    <option value="Serbia">Serbia</option>
                                    <option value="Seychelles">Seychelles</option>
                                    <option value="Sierra Leone">Sierra Leone</option>
                                    <option value="Singapore">Singapore</option>
                                    <option value="Slovakia">Slovakia</option>
                                    <option value="Slovenia">Slovenia</option>
                                    <option value="Solomon Islands">Solomon Islands</option>
                                    <option value="Somalia">Somalia</option>
                                    <option value="South Africa">South Africa</option>
                                    <option value="South Korea">South Korea</option>
                                    <option value="South Sudan">South Sudan</option>
                                    <option value="Spain">Spain</option>
                                    <option value="Sri Lanka" selected>Sri Lanka</option>
                                    <option value="Sudan">Sudan</option>
                                    <option value="Suriname">Suriname</option>
                                    <option value="Sweden">Sweden</option>
                                    <option value="Switzerland">Switzerland</option>
                                    <option value="Syria">Syria</option>
                                    <option value="Taiwan">Taiwan</option>
                                    <option value="Tajikistan">Tajikistan</option>
                                    <option value="Tanzania">Tanzania</option>
                                    <option value="Thailand">Thailand</option>
                                    <option value="Timor-Leste">Timor-Leste</option>
                                    <option value="Togo">Togo</option>
                                    <option value="Tonga">Tonga</option>
                                    <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                    <option value="Tunisia">Tunisia</option>
                                    <option value="Turkey">Turkey</option>
                                    <option value="Turkmenistan">Turkmenistan</option>
                                    <option value="Tuvalu">Tuvalu</option>
                                    <option value="Uganda">Uganda</option>
                                    <option value="Ukraine">Ukraine</option>
                                    <option value="United Arab Emirates">United Arab Emirates</option>
                                    <option value="United Kingdom">United Kingdom</option>
                                    <option value="United States of America">United States of America</option>
                                    <option value="Uruguay">Uruguay</option>
                                    <option value="Uzbekistan">Uzbekistan</option>
                                    <option value="Vanuatu">Vanuatu</option>
                                    <option value="Vatican City (Holy See)">Vatican City (Holy See)</option>
                                    <option value="Venezuela">Venezuela</option>
                                    <option value="Vietnam">Vietnam</option>
                                    <option value="Yemen">Yemen</option>
                                    <option value="Zambia">Zambia</option>
                                    <option value="Zimbabwe">Zimbabwe</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-label-group">
                                <label for="ep_passport-number" class="form-label">Passport Number</label>
                            </div>
                            <div class="form-control-wrap">
                                <input type="text" id="ep_passport_number" name="ep_passport_number" class="form-control" value="{{$booking_detail->passport}}" placeholder="Enter your passport number">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-label-group">
                                <label for="ep_email" class="form-label">Email Address</label>
                            </div>
                            <div class="form-control-wrap">
                                <input type="email" id="ep_email" name="ep_email" value="{{$booking_detail->email}}" class="form-control" placeholder="Enter your email address" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-label-group">
                                <label for="phone" class="form-label">Telephone Number</label>
                            </div>
                            <div class="form-control-wrap">
                                <input type="tel" id="ep_phone" name="ep_phone" class="form-control" value="{{$booking_detail->phone}}" placeholder="Enter your telephone number" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-label-group">
                                <label for="ep_whatsapp-number" class="form-label">WhatsApp Number</label>
                            </div>
                            <div class="form-control-wrap">
                                <input type="tel" id="ep_whatsapp_number" name="ep_whatsapp_number" class="form-control" value="{{$booking_detail->w_number}}" placeholder="Enter your WhatsApp number (include country code)" required>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="form-label-group">
                                <label for="ep_adults" class="form-label">Number of Adults</label>
                            </div>
                            <div class="form-control-wrap">
                                <input type="number" id="ep_adults" name="ep_adults" class="form-control" value="{{$booking_detail->adults}}" min="1" max="100" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-label-group">
                                <label for="ep_children" class="form-label">Number of Children</label>
                            </div>
                            <div class="form-control-wrap">
                                <input type="number" id="ep_children" name="ep_children" class="form-control" value="{{$booking_detail->children}}" min="0" max="100" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="form-label-group">
                                <label for="country" class="form-label">Meal Plan</label>
                            </div>
                            <div class="form-control-wrap col-md-6 mb-1">
                                <div class="custom-control custom-radio checked">
                                    <input type="radio" id="customRadio3" name="ep_Breakfast" class="custom-control-input" value="No Meal" {{$booking_detail->breakfast == 'No Meal'? 'checked' : ''}}>
                                    <label class="custom-control-label" for="customRadio3">No Meal</label>
                                </div>
                            </div>
                            <div class="form-control-wrap col-md-6 mb-1">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio1" name="ep_Breakfast" class="custom-control-input" value="Breakfast" {{$booking_detail->breakfast == 'Breakfast'? 'checked' : ''}}>
                                    <label class="custom-control-label" for="customRadio1">Breakfast</label>
                                </div>
                            </div>
                            <div class="form-control-wrap  col-md-6 mb-1">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio2" name="ep_Breakfast" class="custom-control-input" value="Half Board" {{$booking_detail->breakfast == 'Half Board'? 'checked' : ''}}>
                                    <label class="custom-control-label" for="customRadio2">Half Board</label>
                                </div>
                            </div>
                            <div class="form-control-wrap  col-md-6 mb-1">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio4" name="ep_Breakfast" class="custom-control-input" value="Full Board" {{$booking_detail->breakfast == 'Full Board'? 'checked' : ''}}>
                                    <label class="custom-control-label" for="customRadio4">Full Board</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-label-group">
                                <label for="ep_special-note" class="form-label">Special Note</label>
                            </div>
                            <div class="form-control-wrap">
                                <textarea id="ep_note" name="ep_note" class="form-control"></textarea>
                            </div>
                        </div>
                    <h4 class="card-title title text-center">Room Details</h4>
                    <div class="pricing-body">
                        <ul class="pricing-features">
                            <li><span class="w-50">Total Room Count</span> - <span class="ms-auto text-warning">{{$booking_detail->room_count}}</span></li>
                            @foreach($booking_detail->booking_room_count as $booking_room)
                            <li><span class="w-50">{{$booking_room->room_categories->category}}</span> - <span class="ms-auto text-warning">{{$booking_room->room_count}}</span></li>
                            @endforeach
                        </ul>
                    </div>
                    <h4 class="text-center">Payment Details</h4>
                    <div class="card card-bordered pricing">
                        <div class="pricing-head">
                            <div class="card-text">
                                <div class="row">
                                    <div class="col-4">
                        <span class="h5 fw-500 text-danger">
                        @if($booking_detail->total_amount != null)
                                Rs. {{$booking_detail->total_amount}}
                            @else
                                Rs. 0
                            @endif
                        </span>
                                        <span class="sub-text">Amount</span>
                                    </div>
                                    <div class="col-4">
                        <span class="h5 fw-500 text-danger">
                             @if($booking_detail->advance_payment != null)
                                Rs. {{$booking_detail->advance_payment}}
                            @else
                                Rs. 0
                            @endif
                        </span>
                                        <span class="sub-text">Advance</span>
                                    </div>
                                    <div class="col-4">
                        <span class="h5 fw-500 text-danger">
                             @if($booking_detail->balance != null)
                                Rs. {{$booking_detail->balance}}
                            @else
                                Rs. 0
                            @endif
                        </span>
                                        <span class="sub-text">Due</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12" id="pending-booking-edit-attachment">
                            <div class="form-group">
                                <label class="form-label" for="full-name-12">Payment Attachment</label>
                                <div class="col-sm-12 text-center" id="att-55">
                                    @php
                                        $fileExtension = pathinfo($booking_detail->payment_slip, PATHINFO_EXTENSION);
                                    @endphp
                                    @if ($fileExtension === 'pdf')
                                        <a href="{{ asset('storage') }}/{{$booking_detail->payment_slip}}" target="_blank">
                                            <img src="{{ asset('images/files.png') }}" alt="PDF Icon" style="width:50px;">
                                        </a>
                                    @else
                                        <img src="{{ asset('storage') }}/{{$booking_detail->payment_slip}}" class="img-fluid" alt="">
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-3">
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
            var myForm = $('#welcome_booking');
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


        $(document).ready(function(){

            // handle changes to the country select field
            $("#ep_country").on("change", function(){
                var selectedCountry = $(this).val();
                if (selectedCountry === "Sri Lanka") {
                    // hide passport number input field
                    $("#ep_passport_number").prop('required',false);
                } else {
                    // show passport number input field
                    $("#ep_passport_number").prop('required',true);

                }
            });

        });
    </script>
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
        }
    </script>

    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
@endsection
