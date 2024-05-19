@extends('management.lay')


@section('title' , __(''))

@section('style')

@endsection

@section('content')
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Hotels</h3>
                <div class="nk-block-des text-soft">
                    <p>You have total {{count($hotels)}} Hotels.</p>
                </div>
            </div><!-- .nk-block-head-content -->
            <div class="nk-block-head-content">
                <div class="toggle-wrap nk-block-tools-toggle">
                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                    <div class="toggle-expand-content" data-content="pageMenu">
                        <ul class="nk-block-tools g-3">
                        </ul>
                    </div>
                </div><!-- .toggle-wrap -->
            </div><!-- .nk-block-head-content -->
        </div><!-- .nk-block-between -->
    </div>


    <div class="nk-block">
        <div class="card card-bordered card-preview">
            <div class="card-inner">
                <table class="datatable-init-export nowrap table" data-export-title="Export" id="hotel-table">
                    <thead>
                    <tr>
                        <th>Hotel Name</th>
                        <th>Country</th>
                        <th>Location / City</th>
                        <th>Address</th>
                        <th>Email</th>
                        <th>Telephone</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($hotels as $hotel)
                        <tr>
                            <td><a href="{{ route('switch_hotels',['hotel_id'=>$hotel->id,'hotel_chain_id'=>$hotel->hotel_chain->id]) }}">{{$hotel->hotel_name}}</a></td>
                            <td>{{$hotel->country}}</td>
                            <td>{{$hotel->city}}</td>
                            <td>{{$hotel->address}}</td>
                            <td>{{$hotel->email}}</td>
                            <td>{{$hotel->number}}</td>
                            <td class="nk-tb-col nk-tb-col-tools">
                                <a class="btn btn-trigger btn-icon updateRecordButton" data-hotelid="{{$hotel->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Hotel"><em class="icon ni ni-pen2"></em></a>
                                <a class="btn btn-trigger btn-icon deleteRecordButton" data-hotelid="{{$hotel->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Hotel"><em class="icon ni ni-sign-xrp-new-alt"></em></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Modal Content Code -->
    <div class="modal fade" tabindex="-1" id="modal-edit-hotel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title">Edit Hotel</h5>
                </div>
                <div class="modal-body">
                    <form action="{{route('management/edit-hotel')}}" method="post" id="edit-hotel">
                        @csrf
                        <input type="hidden" id="hotel_id" name="hotel_id">
                        <div class="form-group">
                            <label class="form-label" for="full-name">Name Of Hotel</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="e_hotel_name" name="e_hotel_name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="full-name">Change Hotel Chain</label>
                            <div class="form-control-wrap">
                                <select name="hotel_chain_ids" id="hotel_chain_ids" class="form-control pl-15" required>
                                    @foreach($hotel_chains as $hotel_chain)
                                        <option value="{{$hotel_chain->id}}">{{$hotel_chain->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="full-name">Country</label>
                                    <div class="form-control-wrap">
                                        <select name="e_country" id="e_country" class="form-control pl-15" required>
                                            <option value="">--Select Your Country</option>
                                            <option value="Afganistan">Afghanistan</option>
                                            <option value="Albania">Albania</option>
                                            <option value="Algeria">Algeria</option>
                                            <option value="American Samoa">American Samoa</option>
                                            <option value="Andorra">Andorra</option>
                                            <option value="Angola">Angola</option>
                                            <option value="Anguilla">Anguilla</option>
                                            <option value="Antigua & Barbuda">Antigua & Barbuda</option>
                                            <option value="Argentina">Argentina</option>
                                            <option value="Armenia">Armenia</option>
                                            <option value="Aruba">Aruba</option>
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
                                            <option value="Bermuda">Bermuda</option>
                                            <option value="Bhutan">Bhutan</option>
                                            <option value="Bolivia">Bolivia</option>
                                            <option value="Bonaire">Bonaire</option>
                                            <option value="Bosnia & Herzegovina">Bosnia & Herzegovina</option>
                                            <option value="Botswana">Botswana</option>
                                            <option value="Brazil">Brazil</option>
                                            <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                                            <option value="Brunei">Brunei</option>
                                            <option value="Bulgaria">Bulgaria</option>
                                            <option value="Burkina Faso">Burkina Faso</option>
                                            <option value="Burundi">Burundi</option>
                                            <option value="Cambodia">Cambodia</option>
                                            <option value="Cameroon">Cameroon</option>
                                            <option value="Canada">Canada</option>
                                            <option value="Canary Islands">Canary Islands</option>
                                            <option value="Cape Verde">Cape Verde</option>
                                            <option value="Cayman Islands">Cayman Islands</option>
                                            <option value="Central African Republic">Central African Republic</option>
                                            <option value="Chad">Chad</option>
                                            <option value="Channel Islands">Channel Islands</option>
                                            <option value="Chile">Chile</option>
                                            <option value="China">China</option>
                                            <option value="Christmas Island">Christmas Island</option>
                                            <option value="Cocos Island">Cocos Island</option>
                                            <option value="Colombia">Colombia</option>
                                            <option value="Comoros">Comoros</option>
                                            <option value="Congo">Congo</option>
                                            <option value="Cook Islands">Cook Islands</option>
                                            <option value="Costa Rica">Costa Rica</option>
                                            <option value="Cote DIvoire">Cote DIvoire</option>
                                            <option value="Croatia">Croatia</option>
                                            <option value="Cuba">Cuba</option>
                                            <option value="Curaco">Curacao</option>
                                            <option value="Cyprus">Cyprus</option>
                                            <option value="Czech Republic">Czech Republic</option>
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
                                            <option value="Falkland Islands">Falkland Islands</option>
                                            <option value="Faroe Islands">Faroe Islands</option>
                                            <option value="Fiji">Fiji</option>
                                            <option value="Finland">Finland</option>
                                            <option value="France">France</option>
                                            <option value="French Guiana">French Guiana</option>
                                            <option value="French Polynesia">French Polynesia</option>
                                            <option value="French Southern Ter">French Southern Ter</option>
                                            <option value="Gabon">Gabon</option>
                                            <option value="Gambia">Gambia</option>
                                            <option value="Georgia">Georgia</option>
                                            <option value="Germany">Germany</option>
                                            <option value="Ghana">Ghana</option>
                                            <option value="Gibraltar">Gibraltar</option>
                                            <option value="Great Britain">Great Britain</option>
                                            <option value="Greece">Greece</option>
                                            <option value="Greenland">Greenland</option>
                                            <option value="Grenada">Grenada</option>
                                            <option value="Guadeloupe">Guadeloupe</option>
                                            <option value="Guam">Guam</option>
                                            <option value="Guatemala">Guatemala</option>
                                            <option value="Guinea">Guinea</option>
                                            <option value="Guyana">Guyana</option>
                                            <option value="Haiti">Haiti</option>
                                            <option value="Hawaii">Hawaii</option>
                                            <option value="Honduras">Honduras</option>
                                            <option value="Hong Kong">Hong Kong</option>
                                            <option value="Hungary">Hungary</option>
                                            <option value="Iceland">Iceland</option>
                                            <option value="Indonesia">Indonesia</option>
                                            <option value="India">India</option>
                                            <option value="Iran">Iran</option>
                                            <option value="Iraq">Iraq</option>
                                            <option value="Ireland">Ireland</option>
                                            <option value="Isle of Man">Isle of Man</option>
                                            <option value="Israel">Israel</option>
                                            <option value="Italy">Italy</option>
                                            <option value="Jamaica">Jamaica</option>
                                            <option value="Japan">Japan</option>
                                            <option value="Jordan">Jordan</option>
                                            <option value="Kazakhstan">Kazakhstan</option>
                                            <option value="Kenya">Kenya</option>
                                            <option value="Kiribati">Kiribati</option>
                                            <option value="Korea North">Korea North</option>
                                            <option value="Korea Sout">Korea South</option>
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
                                            <option value="Macau">Macau</option>
                                            <option value="Macedonia">Macedonia</option>
                                            <option value="Madagascar">Madagascar</option>
                                            <option value="Malaysia">Malaysia</option>
                                            <option value="Malawi">Malawi</option>
                                            <option value="Maldives">Maldives</option>
                                            <option value="Mali">Mali</option>
                                            <option value="Malta">Malta</option>
                                            <option value="Marshall Islands">Marshall Islands</option>
                                            <option value="Martinique">Martinique</option>
                                            <option value="Mauritania">Mauritania</option>
                                            <option value="Mauritius">Mauritius</option>
                                            <option value="Mayotte">Mayotte</option>
                                            <option value="Mexico">Mexico</option>
                                            <option value="Midway Islands">Midway Islands</option>
                                            <option value="Moldova">Moldova</option>
                                            <option value="Monaco">Monaco</option>
                                            <option value="Mongolia">Mongolia</option>
                                            <option value="Montserrat">Montserrat</option>
                                            <option value="Morocco">Morocco</option>
                                            <option value="Mozambique">Mozambique</option>
                                            <option value="Myanmar">Myanmar</option>
                                            <option value="Nambia">Nambia</option>
                                            <option value="Nauru">Nauru</option>
                                            <option value="Nepal">Nepal</option>
                                            <option value="Netherland Antilles">Netherland Antilles</option>
                                            <option value="Netherlands">Netherlands (Holland, Europe)</option>
                                            <option value="Nevis">Nevis</option>
                                            <option value="New Caledonia">New Caledonia</option>
                                            <option value="New Zealand">New Zealand</option>
                                            <option value="Nicaragua">Nicaragua</option>
                                            <option value="Niger">Niger</option>
                                            <option value="Nigeria">Nigeria</option>
                                            <option value="Niue">Niue</option>
                                            <option value="Norfolk Island">Norfolk Island</option>
                                            <option value="Norway">Norway</option>
                                            <option value="Oman">Oman</option>
                                            <option value="Pakistan">Pakistan</option>
                                            <option value="Palau Island">Palau Island</option>
                                            <option value="Palestine">Palestine</option>
                                            <option value="Panama">Panama</option>
                                            <option value="Papua New Guinea">Papua New Guinea</option>
                                            <option value="Paraguay">Paraguay</option>
                                            <option value="Peru">Peru</option>
                                            <option value="Phillipines">Philippines</option>
                                            <option value="Pitcairn Island">Pitcairn Island</option>
                                            <option value="Poland">Poland</option>
                                            <option value="Portugal">Portugal</option>
                                            <option value="Puerto Rico">Puerto Rico</option>
                                            <option value="Qatar">Qatar</option>
                                            <option value="Republic of Montenegro">Republic of Montenegro</option>
                                            <option value="Republic of Serbia">Republic of Serbia</option>
                                            <option value="Reunion">Reunion</option>
                                            <option value="Romania">Romania</option>
                                            <option value="Russia">Russia</option>
                                            <option value="Rwanda">Rwanda</option>
                                            <option value="St Barthelemy">St Barthelemy</option>
                                            <option value="St Eustatius">St Eustatius</option>
                                            <option value="St Helena">St Helena</option>
                                            <option value="St Kitts-Nevis">St Kitts-Nevis</option>
                                            <option value="St Lucia">St Lucia</option>
                                            <option value="St Maarten">St Maarten</option>
                                            <option value="St Pierre & Miquelon">St Pierre & Miquelon</option>
                                            <option value="St Vincent & Grenadines">St Vincent & Grenadines</option>
                                            <option value="Saipan">Saipan</option>
                                            <option value="Samoa">Samoa</option>
                                            <option value="Samoa American">Samoa American</option>
                                            <option value="San Marino">San Marino</option>
                                            <option value="Sao Tome & Principe">Sao Tome & Principe</option>
                                            <option value="Saudi Arabia">Saudi Arabia</option>
                                            <option value="Senegal">Senegal</option>
                                            <option value="Seychelles">Seychelles</option>
                                            <option value="Sierra Leone">Sierra Leone</option>
                                            <option value="Singapore">Singapore</option>
                                            <option value="Slovakia">Slovakia</option>
                                            <option value="Slovenia">Slovenia</option>
                                            <option value="Solomon Islands">Solomon Islands</option>
                                            <option value="Somalia">Somalia</option>
                                            <option value="South Africa">South Africa</option>
                                            <option value="Spain">Spain</option>
                                            <option value="Sri Lanka">Sri Lanka</option>
                                            <option value="Sudan">Sudan</option>
                                            <option value="Suriname">Suriname</option>
                                            <option value="Swaziland">Swaziland</option>
                                            <option value="Sweden">Sweden</option>
                                            <option value="Switzerland">Switzerland</option>
                                            <option value="Syria">Syria</option>
                                            <option value="Tahiti">Tahiti</option>
                                            <option value="Taiwan">Taiwan</option>
                                            <option value="Tajikistan">Tajikistan</option>
                                            <option value="Tanzania">Tanzania</option>
                                            <option value="Thailand">Thailand</option>
                                            <option value="Togo">Togo</option>
                                            <option value="Tokelau">Tokelau</option>
                                            <option value="Tonga">Tonga</option>
                                            <option value="Trinidad & Tobago">Trinidad & Tobago</option>
                                            <option value="Tunisia">Tunisia</option>
                                            <option value="Turkey">Turkey</option>
                                            <option value="Turkmenistan">Turkmenistan</option>
                                            <option value="Turks & Caicos Is">Turks & Caicos Is</option>
                                            <option value="Tuvalu">Tuvalu</option>
                                            <option value="Uganda">Uganda</option>
                                            <option value="United Kingdom">United Kingdom</option>
                                            <option value="Ukraine">Ukraine</option>
                                            <option value="United Arab Erimates">United Arab Emirates</option>
                                            <option value="United States of America">United States of America</option>
                                            <option value="Uraguay">Uruguay</option>
                                            <option value="Uzbekistan">Uzbekistan</option>
                                            <option value="Vanuatu">Vanuatu</option>
                                            <option value="Vatican City State">Vatican City State</option>
                                            <option value="Venezuela">Venezuela</option>
                                            <option value="Vietnam">Vietnam</option>
                                            <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                                            <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                                            <option value="Wake Island">Wake Island</option>
                                            <option value="Wallis & Futana Is">Wallis & Futana Is</option>
                                            <option value="Yemen">Yemen</option>
                                            <option value="Zaire">Zaire</option>
                                            <option value="Zambia">Zambia</option>
                                            <option value="Zimbabwe">Zimbabwe</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="full-name">Location / City</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="e_city" name="e_city">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="full-name">Address of Hotel</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="e_address" name="e_address">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="unit_price">Official Email</label>
                            <div class="form-control-wrap">
                                <input type="email" class="form-control" id="e_email" value="" name="e_email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="unit_price">Telephone</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="e_mobile_number" value="" name="e_mobile_number">
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer bg-light">
                    <div class="form-group">
                        <button type="button" class="btn btn-danger btn-lg" data-bs-dismiss="modal">Close</button>
                        <button type="button" onclick="$('#edit-hotel').submit();" class="btn btn-lg btn-primary">Save Changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

    <script>
        let global_theRowObject;

        $(document).ready( function () {
            var export_title = $('#hotel-table').data('export-title') ? $('#hotel-table').data('export-title') : 'Export';
            var attr =  {"responsive":{"details":true},"autoWidth":false,"dom":"<\"row justify-between g-2 with-export\"<\"col-7 col-sm-4 text-start\"f><\"col-5 col-sm-8 text-end\"<\"datatable-filter\"<\"d-flex justify-content-end g-2\"<\"dt-export-buttons d-flex align-center\"<\"dt-export-title d-none d-md-inline-block\">B>l>>>><\"datatable-wrap my-3\"t><\"row align-items-center\"<\"col-7 col-sm-12 col-md-9\"p><\"col-5 col-sm-12 col-md-3 text-start text-md-end\"i>>","language":{"search":"","searchPlaceholder":"Type in to Search","infoEmpty":"0","infoFiltered":"( Total MAX  )","paginate":{"first":"First","last":"Last","next":"Next","previous":"Prev"}},"buttons":["copy","excel","csv","pdf","colvis"]};
            NioApp.DataTable = $('#hotel-table').DataTable(attr);
            $.fn.DataTable.ext.pager.numbers_length = 7;
            $('.dt-export-title').text(export_title);

        });

        $("#edit-hotel").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            var form = $(this);
            var url = form.attr('action');
            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(), // serializes the form's elements.
                success: function (data) {
                    // show response from the php script.
                    var action_buton ='<a class="btn btn-trigger btn-icon updateRecordButton" data-hotelid="'+data.get_hotel.id+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Hotel"><em class="icon ni ni-pen2"></em></a>\n' +
                        '<a class="btn btn-trigger btn-icon deleteRecordButton" data-hotelid="'+data.get_hotel.id+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Hotel"><em class="icon ni ni-sign-xrp-new-alt"></em></a>';

                    var table_data= [data.get_hotel.hotel_name,data.get_hotel.country,data.get_hotel.city,data.get_hotel.address,data.get_hotel.email,data.get_hotel.number,action_buton];
                    console.log(table_data);
                    NioApp.DataTable.row(global_theRowObject).data(table_data).draw(false);
                    $('#modal-edit-hotel').modal('hide');
                    NioApp.Toast('Successfully Edit Hotel', 'success',{position: 'top-right'});
                }
            });
        });
        $('#hotel-table tbody').on('click',
            'a',
            function () {
                if ( $(this).hasClass('updateRecordButton') ) {
                    var data = NioApp.DataTable.row($(this).parents('tr')).data(); //Retrieve row data
                    var tr = $(this).closest('tr'); //Find DataTables table row
                    var theRowObject = NioApp.DataTable.row(tr); //Get DataTables row object
                    var hotel_id = $(this).data('hotelid');
                    global_theRowObject=theRowObject;
                    console.log(data);
                    $.ajax({
                        type:'POST',
                        url:'{{ route('management/hotel/get_hotel_details') }}',
                        headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                        data: {
                            'hotel_id' : hotel_id,
                        },
                        success:function(data){
                            $('#hotel_id').val(data.hotel.id);
                            $('#e_hotel_name').val(data.hotel.hotel_name);
                            $('#hotel_chain_ids').val(data.hotel.hotel_chain_id).prop('selected');
                            $('#e_country').val(data.hotel.country);
                            $('#e_city').val(data.hotel.city);
                            $('#e_address').val(data.hotel.address);
                            $('#e_email').val(data.hotel.email);
                            $('#e_mobile_number').val(data.hotel.number);
                            $('#modal-edit-hotel').modal('show');
                        }

                    });

                }
                if ( $(this).hasClass('deleteRecordButton') ) {
                    var data = NioApp.DataTable.row($(this).parents('tr')).data(); //Retrieve row data
                    var tr = $(this).closest('tr'); //Find DataTables table row
                    var theRowObject = NioApp.DataTable.row(tr); //Get DataTables row object
                    var hotel_id = $(this).data('hotelid');
                    // global_theRowObject2=theRowObject;
                    $.ajax({
                        type:'POST',
                        url:'{{ route('management/hotel/hotel_delete') }}',
                        headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                        data: {
                            'hotel_id' : hotel_id,
                        },
                        success:function(data){
                            if(data.success){
                                NioApp.Toast('Successfully Deleted Hotel', 'success',{position: 'top-right'});
                                NioApp.DataTable.row(theRowObject).remove().draw();
                            }else{
                                NioApp.Toast(data.error, 'warning',{position: 'top-right'});
                            }
                        }

                    });

                }
            });


    </script>
@endsection
