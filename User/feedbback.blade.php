@extends('User.lay')

@section('title' , __(''))

@section('style')
    <style>
        td ,th{
            text-align: center;
            border: 1px #000000 solid;
            padding: 6px 11px;
        }
    </style>

@endsection

@section('content')
    <div class="nk-block nk-block-middle nk-auth-body  wide-xs" >

        <div class="card card-bordered">
            <div class="card-inner card-inner-lg">
                <div class="nk-block-head">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title text-center">Hotel Feedback Form</h3>
                        <div class="nk-block-des">
                            <br><br>
                            <span><b>Name</b> : {{ $reservation->first_name }} {{ $reservation->last_name }} </span><br>
                            <span><b>Email</b> : {{ $reservation->email }} </span><br>
                            <span><b>Room</b> : {{ implode(', ', $reservation->reservation_rooms->pluck('room.room_number')->toArray()) }} </span><br>
                            <p>{{--Access the Dashlite panel using your email and passcode.--}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 pb-5">
                    <form>
                        <div class="form-group row">
                            <div class="form-label-group">
                                <h5>Overall experience at the hotel</h5>
                            </div>
                            <div class="form-control-wrap col-md-12 mb-1">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="overall-experience-excellent" name="overall-experience" value="Excellent" onclick="handleCheckboxChange('overall-experience', 'overall-experience-excellent')">
                                    <label class="custom-control-label" for="overall-experience-excellent">Excellent</label>
                                </div>
                            </div>
                            <div class="form-control-wrap  col-md-12 mb-1">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="overall-experience-good" name="overall-experience" value="Good" onclick="handleCheckboxChange('overall-experience', 'overall-experience-good')">
                                    <label class="custom-control-label" for="overall-experience-good">Good</label>
                                </div>
                            </div>
                            <div class="form-control-wrap  col-md-12 mb-1">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="overall-experience-average" name="overall-experience" value="Average" onclick="handleCheckboxChange('overall-experience', 'overall-experience-average')">
                                    <label class="custom-control-label" for="overall-experience-average">Average</label>
                                </div>
                            </div>
                            <div class="form-control-wrap  col-md-12 mb-1">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="overall-experience-poor" name="overall-experience" value="Poor" onclick="handleCheckboxChange('overall-experience', 'overall-experience-poor')">
                                    <label class="custom-control-label" for="overall-experience-poor">Poor</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="form-label-group">
                                <h5>Cleanliness of your room</h5>
                            </div>
                            <div class="form-control-wrap col-md-12 mb-1">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="cleanliness-excellent" name="cleanliness" value="Excellent" onclick="handleCheckboxChange('cleanliness', 'cleanliness-excellent')">
                                    <label class="custom-control-label" for="cleanliness-excellent">Excellent</label>
                                </div>
                            </div>
                            <div class="form-control-wrap  col-md-12 mb-1">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="cleanliness-good" name="cleanliness" value="Good" onclick="handleCheckboxChange('cleanliness', 'cleanliness-good')">
                                    <label class="custom-control-label" for="cleanliness-good">Good</label>
                                </div>
                            </div>
                            <div class="form-control-wrap  col-md-12 mb-1">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="cleanliness-average" name="cleanliness" value="Average" onclick="handleCheckboxChange('cleanliness', 'cleanliness-average')">
                                    <label class="custom-control-label" for="cleanliness-average">Average</label>
                                </div>
                            </div>
                            <div class="form-control-wrap  col-md-12 mb-1">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="cleanliness-poor" name="cleanliness" value="Poor" onclick="handleCheckboxChange('cleanliness', 'cleanliness-poor')">
                                    <label class="custom-control-label" for="cleanliness-poor">Poor</label>
                                </div>
                            </div>
                        </div>

                        <!-- Friendliness of the staff row -->
                        <div class="form-group row">
                            <div class="form-label-group">
                                <h5>Friendliness of the staff</h5>
                            </div>
                            <div class="form-control-wrap col-md-12 mb-1">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="staff-friendliness-excellent" name="staff-friendliness" value="Excellent" onclick="handleCheckboxChange('staff-friendliness', 'staff-friendliness-excellent')">
                                    <label class="custom-control-label" for="staff-friendliness-excellent">Excellent</label>
                                </div>
                            </div>
                            <div class="form-control-wrap  col-md-12 mb-1">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="staff-friendliness-good" name="staff-friendliness" value="Good" onclick="handleCheckboxChange('staff-friendliness', 'staff-friendliness-good')">
                                    <label class="custom-control-label" for="staff-friendliness-good">Good</label>
                                </div>
                            </div>
                            <div class="form-control-wrap  col-md-12 mb-1">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="staff-friendliness-average" name="staff-friendliness" value="Average" onclick="handleCheckboxChange('staff-friendliness', 'staff-friendliness-average')">
                                    <label class="custom-control-label" for="staff-friendliness-average">Average</label>
                                </div>
                            </div>
                            <div class="form-control-wrap  col-md-12 mb-1">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="staff-friendliness-poor" name="staff-friendliness" value="Poor" onclick="handleCheckboxChange('staff-friendliness', 'staff-friendliness-poor')">
                                    <label class="custom-control-label" for="staff-friendliness-poor">Poor</label>
                                </div>
                            </div>
                        </div>

                        <!-- Value for money row -->
                        <div class="form-group row">
                            <div class="form-label-group">
                                <h5>Value for money</h5>
                            </div>
                            <div class="form-control-wrap col-md-12 mb-1">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="value-excellent" name="value-for-money" value="Excellent" onclick="handleCheckboxChange('value-for-money', 'value-excellent')">
                                    <label class="custom-control-label" for="value-excellent">Excellent</label>
                                </div>
                            </div>
                            <div class="form-control-wrap  col-md-12 mb-1">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="value-good" name="value-for-money" value="Good" onclick="handleCheckboxChange('value-for-money', 'value-good')">
                                    <label class="custom-control-label" for="value-good">Good</label>
                                </div>
                            </div>
                            <div class="form-control-wrap col-md-12 mb-1">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="value-average" name="value-for-money" value="Average" onclick="handleCheckboxChange('value-for-money', 'value-average')">
                                    <label class="custom-control-label" for="value-average">Average</label>
                                </div>
                            </div>
                            <div class="form-control-wrap  col-md-12 mb-1">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="value-poor" name="value-for-money" value="Poor" onclick="handleCheckboxChange('value-for-money', 'value-poor')">
                                    <label class="custom-control-label" for="value-poor">Poor</label>
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <button type="submit" id="submit-btn" class="btn btn-lg btn-primary btn-block">Submit</button>
                        </div>

                    </form>
                        <script>
                            function handleCheckboxChange(groupName, checkboxName) {
                                const checkboxes = document.getElementsByName(groupName);
                                checkboxes.forEach((checkbox) => {
                                    if (checkbox.id !== checkboxName) {
                                        checkbox.checked = false;
                                    }
                                });
                            }
                        </script>


                </div>
            </div>
        </div>

        @endsection
        @section('script')
            <script>
                $(document).ready(function(){
                    // Listen for input changes in the search input field
                    $('#search-input').on('input', function() {
                        // Get the search query
                        var query = $(this).val().toLowerCase();

                        // Loop through each card and hide/show based on the search query
                        $('.menu_item_list').each(function() {
                            var item_name = $(this).data('item_name').toLowerCase();
                            if (item_name.indexOf(query) === -1) {
                                $(this).hide();
                            } else {
                                $(this).show();
                            }
                        });
                    });
                });
            </script>
@endsection
