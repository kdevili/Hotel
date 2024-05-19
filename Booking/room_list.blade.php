@extends('Booking.lay')

@section('title' , __(''))
@section('style')
@endsection

@section('content')
    <section class="about-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <form action="{{route('booking/check_availability/next',[$hotel_id])}}" method="post" class="search-form">
                        @csrf
                        <input type="hidden" name="hotel_id" value="{{$hotel_id}}">
                        <div class="form-container fix">
                            <div class="box-select">
                                <div class="select date">
                                    <input type="date" name="arrive" value="{{$checkinDate}}" />
                                </div>
                                <div class="select date">
                                    <input type="date" name="departure" value="{{$checkoutDate}}" />
                                </div>
                                <div class="select arrow">
                                    <select name="adults" id="adults">
                                        <option value="">ADULTS</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                    </select>
                                </div>
                                <div class="select arrow">
                                    <select name="children" id="children">
                                        <option value="">CHILDREN</option>
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="search default-btn"> Check Availability</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>

    <section class="room-area pt-90">
        <div class="container">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="section-title text-center">
                        <h3>our atr rooms</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellente sque vel volutpat felis, eu condimentum massa. Pellentesque mollis eros vel mattis tempor. Aliquam </p>
                    </div>
                </div>
            </div>
        </div>
    <section class="room-details pt-90">
        <div class="container">
            <div class="row">
                <div class="col-xl-9 col-lg-8 col-12">
                    @foreach($availableRoomCounts as $availableRoomCount)
                        <div class="room-list">
                            <div class="row">
                                <div class="col-lg-5 col-md-6">
                                    <a href="room-details.html" class="post-img"><img src="{{asset("storage")}}/{{$availableRoomCount['category']->image}}" alt=""></a>
                                </div>
                                <div class="col-lg-7 col-md-6 align-self-center">
                                    <div class="room-list-text">
                                        <h3><a href="room-details.html">{{$availableRoomCount['category']->category}}</a></h3>
                                        <p>{{$availableRoomCount['category']->note}}</p>
                                        <h4>Room Facility</h4>
                                        <div class="room-service">
                                            <p>Breakfast Include, Free Wi-Fi, Private Balcony, Free Newspaper, Full AC, Beach View, Swimming Pool</p>
                                            <div class="col-lg-5 col-md-6">
                                            <div class="form-group mt-1 mb-2">
                                                <label class="form-label"><h5>Select Rooms</h5></label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select js-select2" data-placeholder="Select multiple options" name="package" id="available_room_count" data-category-id="{{$availableRoomCount['category']->id}}">
                                                        @for ($i = 0; $i <= $availableRoomCount['available_count']; $i++)
                                                            <option value="{{$i}}" >{{$i}}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>
                                            </div>
                                            <div class="p-amount">
                                                <span>{{$availableRoomCount['category']->price}}</span>
                                                <span class="count">Per Night</span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="col-xl-3 col-lg-4 col-12">
                    <div class="sidebar-widget">
                        <h3 class="room-details-title">your reservation</h3>
                        <form action="{{route('booking/add_booking/next_step',[$hotel_id])}}" method="post" class="search-form" id="get_booking_details">
                            @csrf
                            <!-- Room count input field -->
                                <!-- Room category ID input field -->
                                @foreach($availableRoomCounts as $availableRoomCount)
                                    <input type="hidden" name="room_category_ids[{{$availableRoomCount['category']->id}}]" class="room-category-id" value="">
                                @endforeach
                            <div class="form-container fix">
                                <div class="box-select">
                                    <div class="select date">
                                        <input type="date" name="arrive" value="{{$checkinDate}}">
                                    </div>
                                    <div class="select date">
                                        <input type="date" name="departure" value="{{$checkoutDate}}">
                                    </div>
                                    <div class="select arrow">
                                        <select name="r_adults" id="r_adults">
                                            <option>ADULTS</option>
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                            <option>6</option>
                                        </select>
                                    </div>
                                    <div class="select arrow">
                                        <select name="r_children" id="r_children">
                                            <option>CHILDREN</option>
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                            <option>6</option>
                                        </select>
                                    </div>
                                </div>

                                <div id="booked_details">
                                    <h3 class="room-details-title" id="select-rooms-title">Please Select Rooms</h3>
                                    <div class="form-group" id="room-details-group" style="display: none;">
                                        <label class="form-label" for="last-name">Rooms</label>
                                        <input type="text" class="form-control" id="room_count" name="room_count" placeholder="Price">
                                    </div>
                                    <div class="form-group" id="price-group" style="display: none;">
                                        <label class="form-label" for="last-name">Price</label>
                                        <input type="text" class="form-control" id="price" name="price" placeholder="Price">
                                    </div>
                                    <button type="submit" class="search default-btn" id="submit-button" style="display: none;">Book Now</button>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="sidebar-widget">
                        <div class="c-info-text">
                            <p>If you have any question please don't hesitate to contact us</p>
                        </div>
                        <div class="c-info">
                            <span><i class="zmdi zmdi-phone"></i></span>
                            <span>0123456789<br>0123456789</span>
                        </div>
                        <div class="c-info">
                            <span><i class="zmdi zmdi-email"></i></span>
                            <span>demo@example.com<br>demo@example.com</span>
                        </div>
                    </div>
                    <div class="sidebar-widget">
                        <h3 class="room-details-title">popular posts</h3>
                        <div class="post-content">
                            <div class="post-img">
                                <a href="#" class="block"><img src="img/sidebar/1.jpg" alt=""></a>
                            </div>
                            <div class="post-text">
                                <h4><a href="#">post demo title</a></h4>
                                <span>22 Dec, 2019</span>
                            </div>
                        </div>
                        <div class="post-content">
                            <div class="post-img">
                                <a href="#" class="block"><img src="img/sidebar/2.jpg" alt=""></a>
                            </div>
                            <div class="post-text">
                                <h4><a href="#">post demo title</a></h4>
                                <span>10 Feb, 2019</span>
                            </div>
                        </div>
                        <div class="post-content">
                            <div class="post-img">
                                <a href="#" class="block"><img src="img/sidebar/3.jpg" alt=""></a>
                            </div>
                            <div class="post-text">
                                <h4><a href="#">post demo title</a></h4>
                                <span>06 Mar, 2019</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('script')
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const availableRoomCountSelects = document.querySelectorAll('.room-list select.js-select2');
                    const roomCountInput = document.getElementById('room_count');
                    const priceInput = document.getElementById('price');

                    availableRoomCountSelects.forEach(function (select) {
                        select.addEventListener('change', function () {
                            let totalSelectedRoomCount = 0;
                            let totalSelectedPrice = 0;

                            availableRoomCountSelects.forEach(function (select) {
                                const selectedRoomCount = parseInt(select.value);
                                const roomPrice = parseFloat(select.closest('.room-list').querySelector('.p-amount span').textContent);
                                const totalPrice = selectedRoomCount * roomPrice;

                                totalSelectedRoomCount += selectedRoomCount;
                                totalSelectedPrice += totalPrice;
                            });

                            roomCountInput.value = totalSelectedRoomCount;
                            priceInput.value = totalSelectedPrice.toFixed(2);
                        });
                    });

                    // Update room category ID values on selection change
                    $(document).ready(function() {
                        $('.js-select2').on('change', function() {
                            var selectedCategory = $(this).data('category-id');
                            var selectedCount = $(this).val();
                            $('input[name="room_category_ids[' + selectedCategory + ']"]').val(selectedCount !== "" ? selectedCount : null);
                        });
                        $('#select-rooms-title').show();

                        $('select').on('change', function() {
                            var selectedRooms = $(this).val();

                            if (selectedRooms !== '') {
                                $('#select-rooms-title').hide();
                                $('#room-details-group').show();
                                $('#price-group').show();
                                $('#submit-button').show();
                            } else {
                                $('#room-details-group').hide();
                                $('#price-group').hide();
                                $('#submit-button').hide();
                            }
                        });
                    });


                });
            </script>

            <script>



        $('#children').val('{{$children}}').prop('selected',true);
        $('#adults').val('{{$adults}}').prop('selected',true);
        $('#r_adults').val('{{$adults}}').prop('selected',true);
        $('#r_children').val('{{$children}}').prop('selected',true);
    </script>
@endsection
