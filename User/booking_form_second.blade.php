@extends('User.lay')

@section('title' , __(''))

@section('style')
    <script>
        window.history.forward();


    </script>
    <style>
        .date_range{display: block;
            width: 100%;
            padding: 0.4375rem 1rem;
            font-size: 0.8125rem;
            font-weight: 400;
            line-height: 1.25rem;
            color: #3c4d62;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #dbdfea;
            appearance: none;
            border-radius: 4px;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
    </style>
@endsection

@section('content')
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
                            <h6 class="text-center mt-3 text-success">Your Booking ID -  {{$booking_detail->booking_code}}</h6>
                            <p class="text-center">Please review your previously filled form!</p>
                        </div>
                    </div>
                </div>

                <form id="edit_pending_booking_save" method="POST" action="{{ route('hotel/booking/edit_pending_booking_save_outside') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group" id="room_booking_counts">
                    </div>
                    <input type="hidden" name="ep_booking_id" id="ep_booking_id" value="{{$booking_detail->id}}">
                    <input type="hidden" id="ep_check_in_date" name="ep_check_in_date" value="{{$booking_detail->checking_date}}">
                    <input type="hidden" id="ep_check_out_date" name="ep_check_out_date" value="{{$booking_detail->checkout_date}}">
                    <div class="form-group">
                        <div class="form-label-group">
                            <label for="daterange" class="form-label">Select Date Range</label>
                        </div>
                        <div class="form-control-wrap">
                            <input type="text" id="daterange" name="daterange" value="" class="date_range"/>
                        </div>
                    </div>

                    <div class="" id="show_booking_area" style="">
                        <div class="form-group row">
                            <div class="form-label-group">
                                <label for="country" class="form-label">Room Type</label>
                            </div>
                            <div class="team" id="room_details">
                               <ul class="team-info">
                            @foreach($booking_detail->booking_room_count as $room_category)
                              <li><span>{{$room_category->room_categories->category}}</span>
                                       <span class="mb-2"><select class="form-select js-select2" data-placeholder="" name="available_room_count-{{$room_category->room_category_id}}"  data-category-id="{{$room_category->room_category_id}}">
                                @for ($i = 0; $i <= $room_category->room_count; $i++)
                                                   <option value="{{$i}}" selected>{{$i}}</option>
                                               @endfor
                           </select>
                                       </span>
                              </li>
                                   @endforeach
                                   </ul>

                            </div><!-- .team -->
                        </div>

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
                        <div class="form-group">
                            <div class="form-label-group">
                                <label for="ep_advanced_payment" class="form-label">Advance Payment</label>
                            </div>
                            <div class="form-control-wrap">
                                <input type="number" id="ep_advanced_payment" name="ep_advanced_payment" value="{{$booking_detail->advance_payment}}" class="form-control" required>
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
                        <div class="col-lg-12" id="pending-booking-edit-attachment">
                            <div class="form-group">
                                <label class="form-label" for="full-name-12">Upload Attachment</label>
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
                                    <br>
                                    <button type="button" class="waves-effect waves-light btn btn-dark btn-xs btn-block mb-5" onclick="pending_booking_attachment_change()"><i class="fa fa-trash"></i> Change</button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <button type="submit" id="submit-btn" class="btn btn-lg btn-primary btn-block">Book Now</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('script')

    <script>

        $(function() {
            $('input[name="daterange"]').on('apply.daterangepicker', function(event, picker) {
                console.log(picker);
                var start = picker.startDate;
                var end = picker.endDate;
                var checking_date = start.format('YYYY-MM-DD');
                var checkout_date = end.format('YYYY-MM-DD');

                $('#ep_check_in_date').val(checking_date);
                $('#ep_check_out_date').val(checkout_date);
                $.ajax({
                    type: 'POST',
                    url: '{{ route('hotel/booking/get_available_rooms_details_for_edit_pending_booking') }}',
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    },
                    data: {
                        'checking_date': checking_date,
                        'checkout_date': checkout_date,
                    },
                    success: function(data) {
                        var room_counts = '';
                        room_counts += '<ul class="team-info">';
                        $.each(data.availableRoomCounts, function(key2, val2) {
                            room_counts += '<li><span>' + val2.category.category + '</span>';
                            room_counts += '<span><select class="form-select js-select2 mb-1" data-placeholder="" name="available_room_count-' + val2.category.id + '" id="available_room_count" data-category-id="' + val2.category.id + '">\n';
                            console.log(val2.category.id);
                            for (var i = 0; i <= val2.available_count; i++) {
                                room_counts += '<option value="' + i + '">' + i + '</option>\n';
                            }
                            room_counts += '</select></span></li>';
                        });
                        room_counts += '</ul>';

                        $('#room_details').empty();
                        $('#room_details').append(room_counts);
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            })
        });

        var checkin = moment('{{$booking_detail->checking_date}}').format('DD/MM/YYYY');
        var checkout = moment('{{$booking_detail->checkout_date}}').format('DD/MM/YYYY');

        $('#daterange').daterangepicker({
            minDate: moment().startOf('day'),// Set minimum date to today
            startDate: checkin,
            endDate: checkout,
            opens: 'left',
            locale: {
                format: 'DD/MM/YYYY',
                separator: ' - ',
                applyLabel: 'Apply',
                cancelLabel: 'Cancel',
                fromLabel: 'From',
                toLabel: 'To',
                customRangeLabel: 'Custom',
                daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                monthNames: [
                    'January',
                    'February',
                    'March',
                    'April',
                    'May',
                    'June',
                    'July',
                    'August',
                    'September',
                    'October',
                    'November',
                    'December'
                ],
                firstDay: 0
            }
        });
        function pending_booking_attachment_change(){
            $('#pending-booking-edit-attachment').html('');

            var image_change =
                '                            <div class="form-group">\n' +
                '                                <label class="form-label" for="email-address-12">Upload Attachment</label>\n' +
                '                                <div class="form-control-wrap">\n' +
                '                                    <input type="file" class="form-control" id="ep_image" name="ep_image">\n' +
                '                                </div>\n' +

                '                        </div>';

            $('#pending-booking-edit-attachment').html(image_change);
        }

        $('#ep_note').val('{{$booking_detail->note}}');
        $('#ep_country').val('{{$booking_detail->country}}').prop('selected',true);
    </script>
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

            $(document).ready(function(){
                var myForm = $('#edit_pending_booking_save');
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

        });
    </script>
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
        }
    </script>

    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
@endsection
