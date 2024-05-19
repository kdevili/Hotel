@extends('Booking.lay')

@section('title' , __(''))
@section('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--single {
            background: #f1f1f1 none repeat scroll 0 0;
            border: 0 none;
            color: #444444;
            font-size: 14px;
            height: 48px;
            margin-bottom: 20px;
            padding: 0px 15px;
            width: 100%;
        }
        .contact-form-area input {
             background: #f1f1f1 none repeat scroll 0 0;
            border: 0 none;
            color: #444444;
            font-size: 14px;
            height: 48px;
            margin-bottom: 20px;
            padding: 0px 15px;
            width: 100%;
        }
        .form-control:disabled, .form-control[readonly] {
            background-color: #ffffff;
            opacity: 1;
        }
    </style>
@endsection

@section('content')



<!-- Contact Form Area Start -->
<section class="contact-form-area pt-90">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h4 class="contact-title">Booking info</h4>
                <div class="sidebar-widget">
                    <h3 class="room-details-title">your reservation</h3>
                    <form action="" method="post" class="search-form" id="get_booking_details">
                    <!-- Room count input field -->
                        <!-- Room category ID input field -->
{{--                        @foreach($availableRoomCounts as $availableRoomCount)--}}
{{--                            <input type="hidden" name="room_category_ids[{{$availableRoomCount['category']->id}}]" class="room-category-id" value="">--}}
{{--                        @endforeach--}}
                        <div class="form-container fix">
                            <div class="box-select">
                                <div class="form-group" id="price-group" style="">
                                    <label class="form-label" for="last-name">Checking Date</label>
                                    <input type="text" class="form-control" id="" name="" value="{{$checkinDate}}" readonly>
                                </div>
                                <div class="form-group" id="price-group" style="">
                                    <label class="form-label" for="last-name">Checkout Date</label>
                                    <input type="text" class="form-control" id="" name="" value="{{$checkoutDate}}" readonly>
                                </div>
                                <div class="form-group" id="price-group" style="">
                                    <label class="form-label" for="last-name">Adults</label>
                                    <input type="text" class="form-control" id="" name="" value="{{$adults}}" readonly>
                                </div>
                                <div class="form-group" id="price-group" style="">
                                    <label class="form-label" for="last-name">Children</label>
                                    <input type="text" class="form-control" id="" name="" value="{{$children}}" readonly>
                                </div>
                                </div>
                            </div>

                            <div id="booked_details">
                                <h3 class="room-details-title" id="select-rooms-title">Room Details</h3>
                                <div class="form-group" id="room-details-group" style="">
                                    <label class="form-label" for="last-name">Rooms</label>
                                    <input type="text" class="form-control" id="room_count" name="room_count" value="{{$room_count}}" readonly>
                                </div>
                                <div class="form-group" id="price-group" style="">
                                    <label class="form-label" for="last-name">Price</label>
                                    <input type="text" class="form-control" id="price" name="price" value="{{$total_price}}" readonly>
                                </div>
                            </div>

                    </form>
                </div>
            </div>
            <div class="col-md-8">
                <h4 class="contact-title">Add Your Booking !</h4>
                <form id="" action="{{route('booking/add_booking/save_booking',[$hotel_id])}}" method="post">
                    @csrf
                    <input type="hidden" name="category_details" value="{{$roomCategoryIds}}">
                    <input type="hidden" name="n_adult" value="{{$adults}}">
                    <input type="hidden" name="n_children" value="{{$children}}">
                    <input type="hidden" name="n_checking" value="{{$checkinDate}}">
                    <input type="hidden" name="n_checkout" value="{{$checkoutDate}}">
                    <input type="hidden" name="n_price" value="{{$total_price}}">
                    <input type="hidden" name="n_room_count" value="{{$room_count}}">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" name="f_name" placeholder="First Name" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="l_name" placeholder="Last Name">
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="p_number" placeholder="Enter Phone No" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="w_number" placeholder="Enter Whatsapp No" required>
                        </div>
                        <div class="col-md-6">
                            <input type="email" name="email" placeholder="Enter Email" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="address" placeholder="Address">
                        </div>
                        <div class="col-md-6">
                            <select id="mySelect" name="country" class="form-control js-select2" data-search="on" required>
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
                        <div class="col-md-12">
                            <textarea name="message" cols="30" rows="10" placeholder="Note here"></textarea>
                            <button type="submit" class="search default-btn">SUBMIT</button>
                        </div>
                    </div>
                </form>
                <p class="form-messege"></p>
            </div>
        </div>
    </div>
</section>
<!-- Contact Form Area End -->

@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {

            $('#mySelect').select2({
                width: '100%',
                placeholder: 'Select an option',
            });
        });

        $('#r_adults').val('{{$adults}}').prop('selected',true);
        $('#r_children').val('{{$children}}').prop('selected',true);

    </script>

@endsection
