@extends('User.lay')

@section('title' , __(''))

@section('style')
    <style>
        /* Style the image preview container */
        #imagePreview {
            width: 200px;
            height: 200px;
            border: 1px solid #ccc;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            border-radius: 120px;
            position: relative;
        }

        /* Style the image preview itself */
        #imagePreview img {
            max-width: 100%;
            max-height: 100%;

        }

        /* Style the hidden file input */
        #dpfileInput {
            display: none;
        }

        #job_dp_image {
            width: 100%; /* Make the image fill the container horizontally */
            height: 100%; /* Make the image fill the container vertically */
            object-fit: cover; /* Scale the image to cover the entire container while maintaining aspect ratio */
            border-radius: 120px;
        }

        .image-alt {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            /* Your styles for the alternative text go here */
        }

        .dropzone {

            border: 1px dashed #000 !important;

        }

        /* Define a CSS class to hide the textarea */
        .hidden-textarea {
            display: none;
        }

    </style>

@endsection

@section('content')
    <div class="nk-block nk-block-middle nk-auth-body  wide-xs">

        <div class="card card-bordered">
            <div class="card-inner card-inner-lg">


                <div class="row">
                    <div class="col-8">
                        <div id="google_translate_element"></div>
                    </div>

                </div>
                <br>
                <div class="row justify-content-center">

                    <div class="col-4 ">
                        <img class="img" src="{{ asset('images/ravanlogo.jpg') }}"  alt="logo">
                    </div>
                </div>
                <br>

                <div class="nk-block-head">
                    <div class="nk-block-head-content">
                        <h4 class="nk-block-title text-center">Apply for Job</h4>
                        <div class="nk-block-des">
                            <p>{{--Access the Dashlite panel using your email and passcode.--}}</p>
                        </div>
                    </div>
                </div>
                <form id="reservation-form" enctype="multipart/form-data" method="POST" action="{{ route('job_application/save') }}">
                    @csrf

                    <input type="hidden" name="hotel_id" value="{{ $hotel_id }}">
                    <input type="hidden" name="uniq_id" value="{{$uniq_id}}">
{{--                    <input type="hidden" name="hotel_id" value="1">--}}



                    <div class="form-group">
                        <div class="form-label-group">
                            <label for="full-name" class="form-label">Upload Your Image</label>
                        </div>
                        <div class="form-control-wrap">
<center>
                            <label for="dpfileInput" id="imagePreview">
                                <img id="job_dp_image"  alt="">
                                <span class="image-alt">+</span>
                            </label>
                            <!-- Hidden file input (triggered by the image click) -->
                            <input type="file" name="job_dp_image" id="dpfileInput" accept="image/*" required>
</center>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Date</label>
                        <div class="form-control-wrap">
                            <div class="form-icon form-icon-left">
                                <em class="icon ni ni-calendar"></em>
                            </div>
                            <input type="text" class="form-control date-picker" data-date-format="yyyy-mm-dd" id="date" name="date" readonly value="{{date('Y-m-d')}}" required>
                        </div>
                        {{--                                <div class="form-note">Date format <code>yyyy-mm-dd</code></div>--}}
                    </div>

                    <div class="form-group">
                        <div class="form-label-group">
                            <label for="full-name" class="form-label">First Name</label>
                        </div>
                        <div class="form-control-wrap">
                            <input type="text" id="first-name" name="first_name" class="form-control" placeholder="Enter your first name" required autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <label for="full-name" class="form-label">Last Name</label>
                        </div>
                        <div class="form-control-wrap">
                            <input type="text" id="last-name" name="last_name" class="form-control" placeholder="Enter your last name" required>
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
                            <label for="address" class="form-label">City</label>
                        </div>
                        <div class="form-control-wrap">
                            <input type="text" id="city" name="city" class="form-control" placeholder="Enter your city">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-label-group">
                            <label for="address" class="form-label">Address</label>
                        </div>
                        <div class="form-control-wrap">
                            <input type="text" id="address" name="address" class="form-control" placeholder="Enter your address" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-label-group">
                            <label for="birthday" class="form-label">Birthday</label>
                        </div>
                        <div class="form-control-wrap">
                            <input type="date" id="birthday" name="birthday" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-label-group">
                            <label for="gender" class="form-label">Gender</label>
                        </div>
                        <div class="form-control-wrap">
                            <select id="gender" name="gender" class="form-control" required>

                                <option value="Male">Male</option>
                                <option value="Female">Female</option>

                            </select>
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
                            <input type="number" id="phone" name="phone" class="form-control" placeholder="Enter your telephone number" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <label for="whatsapp-number" class="form-label">WhatsApp Number</label>
                        </div>
                        <div class="form-control-wrap">
                            <input type="number" id="whatsapp-number" name="whatsapp_number" class="form-control" placeholder="Enter your WhatsApp number (include country code)" required>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="form-label-group">
                            <label for="check-in-date" class="form-label">Experience</label>
                        </div>
                        <div class="form-control-wrap">
                            <textarea id="experience" name="experience" class="form-control" placeholder="Enter your experience" required></textarea>

{{--                            <input type="text" id="experience" name="experience" class="form-control" required>--}}
                        </div>
                    </div>


                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label for="position" class="form-label">Position</label>
                                            </div>
                                            <div class="form-control-wrap">


                                                <select class="form-select js-select2" multiple="multiple" data-search="on" id="position" name="position[]" required>



                                                    @foreach($job_position_category as $job_position_categories)
                                                        @if($job_position_categories->hotel_id and $job_position_categories->status != 'Block')
                                                            <option value="{{$job_position_categories->id}}">{{$job_position_categories->job_position_category_name}}</option>
                                                        @endif
                                                    @endforeach


                                                </select>

                                            </div>
                                        </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <label for="english_level" class="form-label">English Knowledge</label>
                        </div>
                        <div class="form-control-wrap">
                            <select id="english_level" name="english_level" class="form-select js-select2" required>
                                <option value="">Select your knowledge level</option>
                                <option value="Basic">Basic</option>
                                <option value="Conversational">Conversational</option>
                                <option value="Fluent">Fluent</option>
                                <option value="Native">Native</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-label-group">
                            <label for="guests" class="form-label">Minimum Salary Expectation</label>
                        </div>
                        <div class="form-control-wrap">
                            <input type="number" id="salary" name="salary" class="form-control" required>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="form-label" for="email-address-1">Upload your CV</label>
                        <div class="form-control-wrap">
                            <input type="file" class="form-control" id="cv" name="cv" placeholder="max file size 5MB" required>
                        </div>
                    </div>


                    <div class="form-group">

                    </div>



                </form>
                <div class="form-control-wrap">
                    <label class="form-label" for="email-address-1">Upload your work</label>
                    <div class="upload-zone">
                        <div class="dz-message" data-dz-message>
                            <span class="dz-message-text">Drag and drop file</span>
                            <span class="dz-message-or">or</span>
                            <button class="btn btn-primary">SELECT</button>
                        </div>
                    </div>

                </div>

                <div class="form-group">
                    <div class="form-label-group">
                        <label for="special-note" class="form-label hidden-textarea">Special Note</label>
                    </div>
                    <div class="form-control-wrap">
                        <!-- Add the "hidden-textarea" class to the textarea element -->
                        <textarea id="special_note" name="special_note" class="form-control hidden-textarea" placeholder="Enter any special requests, such as dietary restrictions (vegan, gluten-free), preferred breakfast time, or beverage preferences (tea, coffee)"></textarea>
                    </div>
                </div>




                <div class="form-group mt-3">
                    <button onclick="$('#reservation-form').submit();" type="button" class="btn btn-lg btn-primary btn-block">Submit</button>
                </div>

            </div>
        </div>
    </div>

@endsection
@section('script')

<script>
    NioApp.Dropzone('.upload-zone', {
        maxFilesize: 10,
        renameFile: function(file) {
            var dt = new Date();
            var time = dt.getTime();
            return time+file.name;
        },
        acceptedFiles: ".jpeg,.jpg,.png,.gif,application/pdf",
        addRemoveLinks: true,
        timeout: 60000,
        headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
        url:'/job_application/save-images/dropzone',
        params: {
            // Additional data to send
            uniq_id: '{{$uniq_id}}',

            // Add more fields as needed
        },

        removedfile: function(file)
        {
            //console.log(this);
            //console.log(this.element.getAttribute("data-deleteaction"));
            var server_file = $(file.previewTemplate).children('.server_file').text();

            var name = file.upload.filename;
            $.ajax({
                headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                type: 'POST',
                url: '/job_application/dropzone/delete',
                data: {filename: name,
                    server_file : server_file
                },
                success: function (data){
                    console.log("File has been successfully removed!!");
                },
                error: function(e) {
                    console.log(e);
                }});
            var fileRef;
            return (fileRef = file.previewElement) != null ?
                fileRef.parentNode.removeChild(file.previewElement) : void 0;
        },

        success: function(file, response)
        {
            $(file.previewTemplate).append('<span class="server_file" style="display: none;">'+response.success+'</span>');

            //console.log(response);
        },
        error: function(file, response)
        {
            return false;
        }


    });

</script>

<script>
    // JavaScript to preview the selected image
    document.getElementById("dpfileInput").addEventListener("change", function () {
        const fileInput = this;
        const imagePreview = document.getElementById("job_dp_image");

        if (fileInput.files && fileInput.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                imagePreview.src = e.target.result;
            };

            reader.readAsDataURL(fileInput.files[0]);
        }
    });

    // Trigger file input when clicking on the image preview container
    document.getElementById("imagePreview").addEventListener("click", function () {
        document.getElementById("fileInput").click();
    });
</script>


    <script>
    $(document).ready(function () {
        var myForm = $('#reservation-form');
        var loadingOverlay = $('#loading-overlay');

        // Add an event listener for the form submission
        myForm.submit(function (event) {
            // Check if the first-name input is empty
            var firstNameInput = $('#first-name');
            if (firstNameInput.val() === '') {
                alert('First name is required.');
                event.preventDefault(); // Prevent form submission
                return;
            }

            var lastNameInput = $('#last-name');
            if (lastNameInput.val() === '') {
                alert('Last name is required.');
                event.preventDefault(); // Prevent form submission
                return;
            }

            var country = $('#country');
            if (country.val() === '') {
                alert('Country is required.');
                event.preventDefault(); // Prevent form submission
                return;
            }

            var city = $('#city');
            if (city.val() === '') {
                alert('City is required.');
                event.preventDefault(); // Prevent form submission
                return;
            }

            var address = $('#address');
            if (address.val() === '') {
                alert('Address is required.');
                event.preventDefault(); // Prevent form submission
                return;
            }

            var birthday = $('#birthday');
            if (birthday.val() === '') {
                alert('Birthday is required.');
                event.preventDefault(); // Prevent form submission
                return;
            }

            var gender = $('#gender');
            if (gender.val() === '') {
                alert('Gender is required.');
                event.preventDefault(); // Prevent form submission
                return;
            }

            var email = $('#email');
            if (email.val() === '') {
                alert('Email is required.');
                event.preventDefault(); // Prevent form submission
                return;
            }

            var phone = $('#phone');
            if (phone.val() === '') {
                alert('Phone is required.');
                event.preventDefault(); // Prevent form submission
                return;
            }

            var whatsappnumber = $('#whatsapp-number');
            if (whatsappnumber.val() === '') {
                alert('Whatsapp Number is required.');
                event.preventDefault(); // Prevent form submission
                return;
            }

            var experience = $('#experience');
            if (experience.val() === '') {
                alert('Experience is required.');
                event.preventDefault(); // Prevent form submission
                return;
            }

            var english_level = $('#english_level');
            if (english_level.val() === '') {
                alert('English_level is required.');
                event.preventDefault(); // Prevent form submission
                return;
            }

            var salary = $('#salary');
            if (salary.val() === '') {
                alert('Salary is required.');
                event.preventDefault(); // Prevent form submission
                return;
            }

            var selectedOptions = $('#position').val();
            if (selectedOptions === null || selectedOptions.length === 0) {
                alert('Please select at least one job position.');
                event.preventDefault(); // Prevent form submission
                return;
            }
            var cv = $('#cv');
            if (cv.val() === '') {
                alert('CV is required.');
                event.preventDefault(); // Prevent form submission
                return;
            }

            var imagedp = $('#dpfileInput');
            if (imagedp.val() === '') {
                alert('Upload your photo.');
                event.preventDefault(); // Prevent form submission
                return;
            }



            // Show the dark overlay and loading icon
            loadingOverlay.show();
            showLoading();
        });

        // Add an event listener for the window onload event
        window.onload = function () {
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
