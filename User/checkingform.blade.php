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
                        <h4 class="nk-block-title text-center">Hotel Reservation</h4>
                        <div class="nk-block-des">
                            <p>{{--Access the Dashlite panel using your email and passcode.--}}</p>
                        </div>
                    </div>
                </div>
                <form id="reservation-form" method="POST" action="{{ route('checkin/save') }}">
                    @csrf
                    <div class="row justify-content-center">
                        <div class="col-4">
                            <img class="img" src="{{ asset('images/ravanlogo.jpg') }}"  alt="logo">
                        </div>
                    </div>
                    <input type="hidden" name="hotel_id" value="1">
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
                            <label for="booking-method" class="form-label">Booking Method</label>
                        </div>
                        <div class="form-control-wrap">
                            <select id="booking-method" name="booking-method" class="form-control" required>
                                <option value="">Select a booking method</option>
                                <option value="Online">Online</option>
                                <option value="Phone">Phone</option>
                                <option value="Walk-in">Walk-in</option>

                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-label-group">
                            <label for="country" class="form-label">Country</label>
                        </div>
                        <div class="form-control-wrap">
                            <select id="country" name="country" class="form-control js-select2" data-search="on" required>
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
                            <label for="passport-number" class="form-label">Passport Number</label>
                        </div>
                        <div class="form-control-wrap">
                            <input type="text" id="passport-number" name="passport-number" class="form-control" placeholder="Enter your passport number">
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
                            <label for="phone" class="form-label">Telephone Number</label>
                        </div>
                        <div class="form-control-wrap">
                            <input type="tel" id="phone" name="phone" class="form-control" placeholder="Enter your telephone number" required>
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
                        <div class="form-label-group">
                            <label for="nights" class="form-label">Number of Nights</label>
                        </div>
                        <div class="form-control-wrap">
                            <input type="number" id="nights" name="nights" class="form-control" placeholder="How many nights are you planning to stay?">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-label-group">
                            <label for="check-in-date" class="form-label">Check-in Date</label>
                        </div>
                        <div class="form-control-wrap">
                            <input type="date" id="check-in-date" name="check-in-date" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-label-group">
                            <label for="check-out-date" class="form-label">Check-out Date</label>
                        </div>
                        <div class="form-control-wrap">
                            <input type="date" id="check-out-date" name="check-out-date" class="form-control" required>
                        </div>
                    </div>

{{--                    <div class="form-group">--}}
{{--                        <div class="form-label-group">--}}
{{--                            <label for="room-type" class="form-label">Room Type</label>--}}
{{--                        </div>--}}
{{--                        <div class="form-control-wrap">--}}
{{--                            <select id="room-type" name="room-type" class="form-control" required>--}}
{{--                                <option value="">Select a room type</option>--}}
{{--                                <option value="Cabana">Cabana</option>--}}
{{--                                <option value="Deluxe Double">Deluxe Double</option>--}}
{{--                                <option value="Deluxe Triple">Deluxe Triple</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <div class="form-group row">
                        <div class="form-label-group">
                            <label for="country" class="form-label">Room Type</label>
                        </div>
                        <div class="form-control-wrap col-md-12 mb-1">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck1" name="room-type1" value="Booked">
                                <label class="custom-control-label" for="customCheck1">Cabana</label>
                            </div>
                        </div>
                        <div class="form-control-wrap  col-md-12 mb-1">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck2" name="room-type2" value="Booked">
                                <label class="custom-control-label" for="customCheck2">Deluxe Double</label>
                            </div>
                        </div>
                        <div class="form-control-wrap  col-md-12 mb-1">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck3" name="room-type3" value="Booked">
                                <label class="custom-control-label" for="customCheck3">Deluxe Triple</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <label for="guests" class="form-label">Number of Guests</label>
                        </div>
                        <div class="form-control-wrap">
                            <input type="number" id="guests" name="guests" class="form-control" min="1" max="10" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="form-label-group">
                            <label for="country" class="form-label">Breakfast</label>
                        </div>
                        <div class="form-control-wrap col-md-6 mb-1">
                            <div class="custom-control custom-radio checked">
                                <input type="radio" id="customRadio3" name="Breakfast" class="custom-control-input" value="No Breakfast" checked>
                                <label class="custom-control-label" for="customRadio3">No Breakfast</label>
                            </div>
                        </div>
                        <div class="form-control-wrap col-md-6 mb-1">
                            <div class="custom-control custom-radio">
                                <input type="radio" id="customRadio1" name="Breakfast" class="custom-control-input" value="English Breakfast">
                                <label class="custom-control-label" for="customRadio1">English Breakfast</label>
                            </div>
                        </div>
                        <div class="form-control-wrap  col-md-6 mb-1">
                            <div class="custom-control custom-radio">
                                <input type="radio" id="customRadio2" name="Breakfast" class="custom-control-input" value="Vegan Breakfast" >
                                <label class="custom-control-label" for="customRadio2">Vegan Breakfast</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <label for="special-note" class="form-label">Special Note</label>
                        </div>
                        <div class="form-control-wrap">
                            <textarea id="special-note" name="special-note" class="form-control" placeholder="Enter any special requests, such as dietary restrictions (vegan, gluten-free), preferred breakfast time, or beverage preferences (tea, coffee)"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" id="submit-btn" class="btn btn-lg btn-primary btn-block">Submit</button>
                    </div>

                </form>
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


            var myForm = $('#reservation-form');
            var submitBtn = $('#submit-btn');

// Add an event listener for the form submission
            myForm.submit(function(event) {
                // Prevent the default form submission
                // event.preventDefault();

                // Add the loading icon to the submit button
                submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Submitting...');

                // Submit the form
                // myForm.submit();
            });

// Add an event listener for the form submission complete
            myForm.on('submit-complete', function(event) {
                // Remove the loading icon from the submit button
                submitBtn.html('Submit');
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
