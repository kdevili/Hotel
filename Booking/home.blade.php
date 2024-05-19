@extends('Booking.lay')

@section('title' , __(''))
@section('style')
@endsection

@section('content')

    <!-- About Us Area Start -->
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
                                    <input type="date" name="arrive" required/>
                                </div>
                                <div class="select date">
                                    <input type="date" name="departure" required/>
                                </div>
                                <div class="select arrow">
                                    <select name="adults" required>
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
                                    <select name="children">
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
            <div class="row">
                <div class="col-lg-7">
                    <div class="video-wrapper mt-90">
                        <div class="video-overlay">
                            <img src="{{ asset('booking_s/img/banner/4.jpg')}}" alt="" />
                        </div>
                        <a class="video-popup" href="https://www.youtube.com/watch?v=rXcp6s0VjZk">
                            <i class="zmdi zmdi-play-circle-outline"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="about-text">
                        <div class="section-title">
                            <h3>about us</h3>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed
                                do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                Utjij enim ad minim veniam, quis nostrud exercitation ullamco
                                laboris nisi utjjij aliquip ex ea commodo consequat.
                            </p>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed
                                do eiusmod tempor incididunt ut labore.
                            </p>
                            <p>
                                Fipsum dolor sit amet, consectetur adipisicing elit, sed do
                                eiusmod tempor
                            </p>
                        </div>
                        <div class="about-links">
                            <a href="https://www.facebook.com/"><i class="zmdi zmdi-facebook"></i></a>
                            <a href="https://www.instagram.com/"><i class="zmdi zmdi-instagram"></i></a>
                            <a href="https://www.rss.com/"><i class="zmdi zmdi-rss"></i></a>
                            <a href="https://twitter.com/"><i class="zmdi zmdi-twitter"></i></a>
                            <a href="https://www.pinterest.com/"><i class="zmdi zmdi-pinterest"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Us Area End -->
    <!-- Room Area Start -->
    <section class="room-area pt-90">
        <div class="container">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="section-title text-center">
                        <h3>our favorite rooms</h3>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                            eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
                            enim ad minim veniam
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid overflow-hidden">
            <div class="single-room small">
                <img src="{{ asset('booking_s/img/room/1.jpg')}}" alt="" />
                <div class="room-hover text-center">
                    <div class="hover-text">
                        <h3><a href="room-details.html">Royal Suit</a></h3>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                            eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
                            enim ad minim veniam,
                        </p>
                        <div class="room-btn">
                            <a href="room-details.html" class="default-btn">DETAILS</a>
                        </div>
                    </div>
                    <div class="p-amount">
                        <span>$220</span>
                        <span class="count">Per Night</span>
                    </div>
                </div>
            </div>

            <div class="single-room large">
                <img src="{{ asset('booking_s/img/room/2.jpg')}}" alt="" />
                <div class="room-hover text-center">
                    <div class="hover-text">
                        <h3><a href="room-details.html">Deluxe Suit</a></h3>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                            eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
                            enim ad minim veniam,
                        </p>
                        <div class="room-btn">
                            <a href="room-details.html" class="default-btn">DETAILS</a>
                        </div>
                    </div>
                    <div class="p-amount">
                        <span>$150</span>
                        <span class="count">Per Night</span>
                    </div>
                </div>
            </div>
            <div class="single-room small">
                <img src="{{ asset('booking_s/img/room/3.jpg')}}" alt="" />
                <div class="room-hover text-center">
                    <div class="hover-text">
                        <h3><a href="room-details.html">Single Room</a></h3>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                            eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
                            enim ad minim veniam,
                        </p>
                        <div class="room-btn">
                            <a href="room-details.html" class="default-btn">DETAILS</a>
                        </div>
                    </div>
                    <div class="p-amount">
                        <span>$120</span>
                        <span class="count">Per Night</span>
                    </div>
                </div>
            </div>
            <div class="single-room medium">
                <img src="{{ asset('booking_s/img/room/4.jpg')}}" alt="" />
                <div class="room-hover text-center">
                    <div class="hover-text">
                        <h3><a href="room-details.html">Double Room</a></h3>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                            eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
                            enim ad minim veniam,
                        </p>
                        <div class="room-btn">
                            <a href="room-details.html" class="default-btn">DETAILS</a>
                        </div>
                    </div>
                    <div class="p-amount">
                        <span>$100</span>
                        <span class="count">Per Night</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Room Area End -->
    <!-- Services Area Start -->
    <section class="services-area ptb-90">
        <div class="container">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="section-title text-center">
                        <h3>our awesome services</h3>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                            eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
                            enim ad minim veniam
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5">
                    <ul role="tablist" class="nav nav-tabs">
                        <li class="nav-item" role="presentation">
                            <a
                                class="nav-link active"
                                data-bs-toggle="tab"
                                role="tab"
                                aria-controls="spa"
                                href="#spa"
                                aria-expanded="true"
                            >
                  <span class="image p-img"
                  ><img src="{{ asset('booking_s/img/icon/spa.png')}}" alt=""
                      /></span>
                                <span class="image s-img"
                                ><img src="{{ asset('booking_s/img/icon/spa-hover.png')}}" alt=""
                                    /></span>
                                <span class="title">Spa - Beauty &amp; Health</span>
                                <span class="text"
                                >Lorem ipsum dolor gtsitrty amet, consectetur adipisicing
                    elit, sed do eiusm tempor incidid</span
                                >
                            </a>
                        </li>

                        <li class="nav-item" role="presentation">
                            <a
                                class="nav-link"
                                data-bs-toggle="tab"
                                role="tab"
                                aria-controls="swim"
                                href="#swim"
                                aria-expanded="true"
                            >
                  <span class="image p-img"
                  ><img src="{{ asset('booking_s/img/icon/swim.png')}}" alt=""
                      /></span>
                                <span class="image s-img"
                                ><img src="{{ asset('booking_s/img/icon/swim-hover.png')}}" alt=""
                                    /></span>
                                <span class="title">Swimming Pool</span>
                                <span class="text"
                                >Lorem ipsum dolor rtysittg amet, consectetur adipisicing
                    elit, sed do eiusm tempor incididunt</span
                                >
                            </a>
                        </li>

                        <li class="nav-item" role="presentation">
                            <a
                                class="nav-link"
                                data-bs-toggle="tab"
                                role="tab"
                                aria-controls="restaurant"
                                href="#restaurant"
                                aria-expanded="true"
                            >
                  <span class="image p-img"
                  ><img src="{{ asset('booking_s/img/icon/restaurent.png')}}" alt=""
                      /></span>
                                <span class="image s-img"
                                ><img src="{{ asset('booking_s/img/icon/restaurent-hover.png')}}" alt=""
                                    /></span>
                                <span class="title">Restaurant</span>
                                <span class="text"
                                >Lorem ipsum dolor frsit frtgamet, consectetur adipisicing
                    elit, sed do eiusm tempor doloreut</span
                                >
                            </a>
                        </li>

                        <li class="nav-item" role="presentation">
                            <a
                                class="nav-link"
                                data-bs-toggle="tab"
                                role="tab"
                                aria-controls="conference"
                                href="#conference"
                                aria-expanded="true"
                            >
                  <span class="image p-img"
                  ><img src="{{ asset('booking_s/img/icon/conference.png')}}" alt=""
                      /></span>
                                <span class="image s-img"
                                ><img src="{{ asset('booking_s/img/icon/conference-hover.png')}}" alt=""
                                    /></span>
                                <span class="title">Conference</span>
                                <span class="text"
                                >Lorem ipsum dolor frsit frtramet, consectetur adipisicing
                    elit, sed do eiusm tempordoloreut</span
                                >
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-7">
                    <div class="tab-content">
                        <div id="spa" class="tab-pane active" role="tabpanel">
                            <img src="{{ asset('booking_s/img/banner/1.jpg')}}" alt="" />
                        </div>
                        <div id="swim" class="tab-pane" role="tabpanel">
                            <img src="{{ asset('booking_s/img/banner/2.jpg')}}" alt="" />
                        </div>
                        <div id="restaurant" class="tab-pane" role="tabpanel">
                            <img src="{{ asset('booking_s/img/banner/3.jpg')}}" alt="" />
                        </div>
                        <div id="conference" class="tab-pane" role="tabpanel">
                            <img src="{{ asset('booking_s/img/banner/1.jpg')}}" alt="" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Services Area End -->
    <!-- Fun Factor Area Start -->
    <section class="fun-factor-area bg-1 overlay-dark">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="single-fun-factor text-center">
                        <h1><span class="counter">112</span></h1>
                        <h4>new friendships</h4>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="single-fun-factor text-center">
                        <h1><span class="counter">158</span></h1>
                        <h4>five start ratings</h4>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="single-fun-factor text-center">
                        <h1><span class="counter">430</span></h1>
                        <h4>international guests</h4>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="single-fun-factor text-center">
                        <h1><span class="counter">745</span></h1>
                        <h4>served breakfast</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Fun Factor Area End -->
    <!-- Gallery Area Start -->
    <section class="gallery-area pt-90">
        <div class="container">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="section-title text-center">
                        <h3>our gallery</h3>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            Pellente sque vel volutpat felis, eu condimentum massa.
                            Pellentesque mollis eros vel mattis tempor. Aliquam
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="gallery-container">
            <div class="gallery-filter">
                <button data-filter="*" class="active">All</button>
                <button data-filter=".spa">Spa</button>
                <button data-filter=".restaurent">Restaurent</button>
                <button data-filter=".gym">Gym</button>
                <button data-filter=".hotel">Hotel</button>
            </div>
            <div class="gallery gallery-masonry">
                <div class="gallery-item spa gym">
                    <div class="thumb">
                        <img src="{{ asset('booking_s/img/gallery/1.jpg')}}" alt="" />
                    </div>
                    <div class="gallery-hover">
                        <div class="gallery-icon">
                            <a href="#">
                  <span class="p-img"
                  ><img src="{{ asset('booking_s/img/icon/link.png')}}" alt=""
                      /></span>
                                <span class="s-img"
                                ><img src="{{ asset('booking_s/img/icon/link-hover.png')}}" alt=""
                                    /></span>
                            </a>
                            <a class="image-popup" href="{{ asset('booking_s/img/gallery/1.jpg')}}">
                  <span class="p-img"
                  ><img src="{{ asset('booking_s/img/icon/search.png')}}" alt=""
                      /></span>
                                <span class="s-img"
                                ><img src="{{ asset('booking_s/img/icon/search-hover.png')}}" alt=""
                                    /></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="gallery-item restaurent hotel">
                    <div class="thumb">
                        <img src="{{ asset('booking_s/img/gallery/2.jpg')}}" alt="" />
                    </div>
                    <div class="gallery-hover">
                        <div class="gallery-icon">
                            <a href="#">
                  <span class="p-img"
                  ><img src="{{ asset('booking_s/img/icon/link.png')}}" alt=""
                      /></span>
                                <span class="s-img"
                                ><img src="{{ asset('booking_s/img/icon/link-hover.png')}}" alt=""
                                    /></span>
                            </a>
                            <a class="{{ asset('booking_s/image-popup" href="img/gallery/2.jpg')}}">
                  <span class="p-img"
                  ><img src="{{ asset('booking_s/img/icon/search.png')}}" alt=""
                      /></span>
                                <span class="s-img"
                                ><img src="{{ asset('booking_s/img/icon/search-hover.png')}}" alt=""
                                    /></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="gallery-item spa hotel">
                    <div class="thumb">
                        <img src="{{ asset('booking_s/img/gallery/3.jpg')}}" alt="" />
                    </div>
                    <div class="gallery-hover">
                        <div class="gallery-icon">
                            <a href="#">
                  <span class="p-img"
                  ><img src="{{ asset('booking_s/img/icon/link.png')}}" alt=""
                      /></span>
                                <span class="s-img"
                                ><img src="{{ asset('booking_s/img/icon/link-hover.png')}}" alt=""
                                    /></span>
                            </a>
                            <a class="image-popup" href="{{ asset('booking_s/img/gallery/3.jpg')}}">
                  <span class="p-img"
                  ><img src="{{ asset('booking_s/img/icon/search.png')}}" alt=""
                      /></span>
                                <span class="s-img"
                                ><img src="{{ asset('booking_s/img/icon/search-hover.png')}}" alt=""
                                    /></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="gallery-item restaurent hotel">
                    <div class="thumb">
                        <img src="{{ asset('booking_s/img/gallery/4.jpg')}}" alt="" />
                    </div>
                    <div class="gallery-hover">
                        <div class="gallery-icon">
                            <a href="#">
                  <span class="p-img"
                  ><img src="{{ asset('booking_s/img/icon/link.png')}}" alt=""
                      /></span>
                                <span class="s-img"
                                ><img src="{{ asset('booking_s/img/icon/link-hover.png')}}" alt=""
                                    /></span>
                            </a>
                            <a class="image-popup" href="{{ asset('booking_s/img/gallery/4.jpg')}}">
                  <span class="p-img"
                  ><img src="{{ asset('booking_s/img/icon/search.png')}}" alt=""
                      /></span>
                                <span class="s-img"
                                ><img src="{{ asset('booking_s/img/icon/search-hover.png')}}" alt=""
                                    /></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="gallery-item gym">
                    <div class="thumb">
                        <img src="{{ asset('booking_s/img/gallery/5.jpg')}}" alt="" />
                    </div>
                    <div class="gallery-hover">
                        <div class="gallery-icon">
                            <a href="#">
                  <span class="p-img"
                  ><img src="{{ asset('booking_s/img/icon/link.png')}}" alt=""
                      /></span>
                                <span class="s-img"
                                ><img src="{{ asset('booking_s/img/icon/link-hover.png')}}" alt=""
                                    /></span>
                            </a>
                            <a class="image-popup" href="{{ asset('booking_s/img/gallery/5.jpg')}}">
                  <span class="p-img"
                  ><img src="{{ asset('booking_s/img/icon/search.png')}}" alt=""
                      /></span>
                                <span class="s-img"
                                ><img src="{{ asset('booking_s/img/icon/search-hover.png')}}" alt=""
                                    /></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="gallery-item spa hotel gym">
                    <div class="thumb">
                        <img src="{{ asset('booking_s/img/gallery/6.jpg')}}" alt="" />
                    </div>
                    <div class="gallery-hover">
                        <div class="gallery-icon">
                            <a href="#">
                  <span class="p-img"
                  ><img src="{{ asset('booking_s/img/icon/link.png')}}" alt=""
                      /></span>
                                <span class="s-img"
                                ><img src="{{ asset('booking_s/img/icon/link-hover.png')}}" alt=""
                                    /></span>
                            </a>
                            <a class="image-popup" href="{{ asset('booking_s/img/gallery/6.jpg')}}">
                  <span class="p-img"
                  ><img src="{{ asset('booking_s/img/icon/search.png')}}" alt=""
                      /></span>
                                <span class="s-img"
                                ><img src="{{ asset('booking_s/img/icon/search-hover.png')}}" alt=""
                                    /></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Gallery Area End -->
    <!-- Team Area Start -->
    <section class="team-area ptb-90">
        <div class="container">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="section-title text-center">
                        <h3>our special staff</h3>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            Pellente sque vel volutpat felis, eu condimentum massa.
                            Pellentesque mollis eros vel mattis tempor. Aliquam
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="single-team">
                        <div class="team-image"><img src="{{ asset('booking_s/img/team/1.jpg')}}" alt="" /></div>
                        <div class="team-hover">
                            <h4>Kathy Luis</h4>
                            <span class="block">( Officer )</span>
                            <p>
                                Lorem ipsupm dolor sit amet, conse ctetur adipisicing elit,
                                sed do eiumthgtipsupm dolor sit amet conse
                            </p>
                            <div class="team-links">
                                <a href="https://www.facebook.com/"
                                ><i class="zmdi zmdi-facebook"></i
                                    ></a>
                                <a href="https://twitter.com/"
                                ><i class="zmdi zmdi-twitter"></i
                                    ></a>
                                <a href="https://www.pinterest.com/"
                                ><i class="zmdi zmdi-pinterest"></i
                                    ></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="single-team">
                        <div class="team-image"><img src="{{ asset('booking_s/img/team/2.jpg')}}" alt="" /></div>
                        <div class="team-hover">
                            <h4>Them Jonse</h4>
                            <span class="block">( Manager )</span>
                            <p>
                                Lorem ipsupm dolor sit amet, conse ctetur adipisicing elit,
                                sed do eiumthgtipsupm dolor sit amet conse
                            </p>
                            <div class="team-links">
                                <a href="https://www.facebook.com/"
                                ><i class="zmdi zmdi-facebook"></i
                                    ></a>
                                <a href="https://twitter.com/"
                                ><i class="zmdi zmdi-twitter"></i
                                    ></a>
                                <a href="https://www.pinterest.com/"
                                ><i class="zmdi zmdi-pinterest"></i
                                    ></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="single-team">
                        <div class="team-image"><img src="{{ asset('booking_s/img/team/3.jpg')}}" alt="" /></div>
                        <div class="team-hover">
                            <h4>Marry Gomej</h4>
                            <span class="block">( Leader )</span>
                            <p>
                                Lorem ipsupm dolor sit amet, conse ctetur adipisicing elit,
                                sed do eiumthgtipsupm dolor sit amet conse
                            </p>
                            <div class="team-links">
                                <a href="https://www.facebook.com/"
                                ><i class="zmdi zmdi-facebook"></i
                                    ></a>
                                <a href="https://twitter.com/"
                                ><i class="zmdi zmdi-twitter"></i
                                    ></a>
                                <a href="https://www.pinterest.com/"
                                ><i class="zmdi zmdi-pinterest"></i
                                    ></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Team Area End -->
    <!-- Advertise Area Start -->
    <section class="advertise-area bg-2 overlay-dark">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="advertise-text">
                        <h1>get <span>15% off</span> on any other events...</h1>
                        <a href="#" class="default-btn">Book Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Advertise Area End -->
    <!-- Pricing Area Start -->
    <section class="pricing-area ptb-90">
        <div class="container">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="section-title text-center">
                        <h3>Our Pricing</h3>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            Pellente sque vel volutpat felis, eu condimentum massa.
                            Pellentesque mollis eros vel mattis tempor. Aliquam
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="single-pricing">
                        <div class="package-name">
                            <h3>Silver Pack</h3>
                            <h1>
                                <span class="currency">$</span>150
                                <span class="count">/per night</span>
                            </h1>
                        </div>
                        <div class="package-offer">
                            <span>Flight Ticket</span>
                            <span>Music Concert (30% Off)</span>
                            <span>Restaurant (Lunch)</span>
                            <span class="light">Treatment</span>
                            <span class="light">Face Make</span>
                        </div>
                        <div class="signup-btn">
                            <a href="#" class="default-btn">SIGN UP</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="single-pricing best-offer">
                        <div class="package-name">
                            <h3>Gold Pack</h3>
                            <h1>
                                <span class="currency">$</span>140
                                <span class="count">/per night</span>
                            </h1>
                        </div>
                        <div class="package-offer">
                            <span>Flight Ticket</span>
                            <span>Music Concert (30% Off)</span>
                            <span>Restaurant (Lunch)</span>
                            <span>Treatment</span>
                            <span class="light">Face Make</span>
                        </div>
                        <div class="signup-btn">
                            <a href="#" class="default-btn">SIGN UP</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="single-pricing">
                        <div class="package-name">
                            <h3>Diamond Pack</h3>
                            <h1>
                                <span class="currency">$</span>190
                                <span class="count">/per night</span>
                            </h1>
                        </div>
                        <div class="package-offer">
                            <span>Flight Ticket</span>
                            <span>Music Concert (30% Off)</span>
                            <span>Restaurant (Lunch)</span>
                            <span>Treatment</span>
                            <span>Face Make</span>
                        </div>
                        <div class="signup-btn">
                            <a href="#" class="default-btn">SIGN UP</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Pricing Area End -->
    <!-- Blog Area Start -->
    <section class="blog-area">
        <div class="container">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="section-title text-center">
                        <h3>our blog</h3>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                            eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
                            enim ad minim exercitation ullamco laboris nisi.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="blog-carousel">
                    <div class="col-12">
                        <div class="single-blog-wrapper">
                            <div class="single-blog">
                                <div class="blog-image">
                                    <img src="{{ asset('booking_s/img/blog/1.jpg')}}" alt="" />
                                </div>
                                <div class="blog-text">
                    <span class="time"
                    ><i class="zmdi zmdi-time"></i>Jun 25, 2019</span
                    >
                                    <h3>Blog Post Dumy Title</h3>
                                </div>
                            </div>
                            <div class="blog-hover">
                                <span><i class="zmdi zmdi-time"></i>Jun 25, 2019</span>
                                <h3><a href="#">Blog Post Dummy Title</a></h3>
                                <p>
                                    Adipisicing elit, sed cddsz do eiusmod tempor incididunt
                                    adipisicing elit, sed do eiusmod tempor incididunt dolore
                                    enim
                                </p>
                                <div class="post-info">
                    <span
                    ><a href="#"
                        ><i class="zmdi zmdi-account"></i>By A Mollik</a
                        ></span
                    >
                                    <span
                                    ><a href="#"
                                        ><i class="zmdi zmdi-favorite"></i>20 Likes</a
                                        ></span
                                    >
                                    <span
                                    ><a href="#"
                                        ><i class="zmdi zmdi-comments"></i>02 Comments</a
                                        ></span
                                    >
                                </div>
                                <a href="#" class="default-btn">Read more</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="single-blog-wrapper">
                            <div class="single-blog">
                                <div class="blog-image">
                                    <img src="{{ asset('booking_s/img/blog/2.jpg')}}" alt="" />
                                </div>
                                <div class="blog-text">
                    <span class="time"
                    ><i class="zmdi zmdi-time"></i>Mar 03, 2019</span
                    >
                                    <h3>Blog Post Dumy Title</h3>
                                </div>
                            </div>
                            <div class="blog-hover">
                                <span><i class="zmdi zmdi-time"></i>Mar 03, 2019</span>
                                <h3><a href="#">Blog Post Dummy Title</a></h3>
                                <p>
                                    Adipisicing elit, sed cddsz do eiusmod tempor incididunt
                                    adipisicing elit, sed do eiusmod tempor incididunt dolore
                                    enim
                                </p>
                                <div class="post-info">
                    <span
                    ><a href="#"
                        ><i class="zmdi zmdi-account"></i>By R James</a
                        ></span
                    >
                                    <span
                                    ><a href="#"
                                        ><i class="zmdi zmdi-favorite"></i>40 Likes</a
                                        ></span
                                    >
                                    <span
                                    ><a href="#"
                                        ><i class="zmdi zmdi-comments"></i>01 Comments</a
                                        ></span
                                    >
                                </div>
                                <a href="#" class="default-btn">Read more</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="single-blog-wrapper">
                            <div class="single-blog">
                                <div class="blog-image">
                                    <img src="{{ asset('booking_s/img/blog/3.jpg')}}" alt="" />
                                </div>
                                <div class="blog-text">
                    <span class="time"
                    ><i class="zmdi zmdi-time"></i>Dec 17, 2019</span
                    >
                                    <h3>Blog Post Dumy Title</h3>
                                </div>
                            </div>
                            <div class="blog-hover">
                                <span><i class="zmdi zmdi-time"></i>Dec 17, 2019</span>
                                <h3><a href="#">Blog Post Dummy Title</a></h3>
                                <p>
                                    Adipisicing elit, sed cddsz do eiusmod tempor incididunt
                                    adipisicing elit, sed do eiusmod tempor incididunt dolore
                                    enim
                                </p>
                                <div class="post-info">
                    <span
                    ><a href="#"
                        ><i class="zmdi zmdi-account"></i>By N Sharif</a
                        ></span
                    >
                                    <span
                                    ><a href="#"
                                        ><i class="zmdi zmdi-favorite"></i>10 Likes</a
                                        ></span
                                    >
                                    <span
                                    ><a href="#"
                                        ><i class="zmdi zmdi-comments"></i>20 Comments</a
                                        ></span
                                    >
                                </div>
                                <a href="#" class="default-btn">Read more</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Area End -->
    <!-- Client Area Start -->
    <div class="client-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="client-carousel">
                        <div class="single-client">
                            <div class="client-image">
                                <a href="#">
                                    <img src="{{ asset('booking_s/img/client/1.png')}}" alt="" class="p-img" />
                                    <img src="{{ asset('booking_s/img/client/1-hover.png')}}" alt="" class="s-img" />
                                </a>
                            </div>
                        </div>
                        <div class="single-client">
                            <div class="client-image">
                                <a href="#">
                                    <img src="{{ asset('booking_s/img/client/2.png')}}" alt="" class="p-img" />
                                    <img src="{{ asset('booking_s/img/client/2-hover.png')}}" alt="" class="s-img" />
                                </a>
                            </div>
                        </div>
                        <div class="single-client">
                            <div class="client-image">
                                <a href="#">
                                    <img src="{{ asset('booking_s/img/client/3.png')}}" alt="" class="p-img" />
                                    <img src="{{ asset('booking_s/img/client/3-hover.png')}}" alt="" class="s-img" />
                                </a>
                            </div>
                        </div>
                        <div class="single-client">
                            <div class="client-image">
                                <a href="#">
                                    <img src="{{ asset('booking_s/img/client/4.png')}}" alt="" class="p-img" />
                                    <img src="{{ asset('booking_s/img/client/4-hover.png')}}" alt="" class="s-img" />
                                </a>
                            </div>
                        </div>
                        <div class="single-client">
                            <div class="client-image">
                                <a href="#">
                                    <img src="{{ asset('booking_s/img/client/5.png')}}" alt="" class="p-img" />
                                    <img src="{{ asset('booking_s/img/client/5-hover.png')}}" alt="" class="s-img" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Client Area End -->
    <!-- Newsletter Area Start -->
    <section class="newsletter-area bg-light">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 mx-auto col-12">
                    <div class="newsletter-container">
                        <h3>NewsLetter Sign-Up</h3>
                        <div class="newsletter-form">
                            <form action="#" id="mc-form" class="mc-form fix">
                                <input id="mc-email" type="email" name="email" placeholder="Enter your E-mail"/>
                                <button id="mc-submit" type="submit" class="default-btn">subcribes</button>
                            </form>
                            <!-- mailchimp-alerts Start -->
                            <div class="mailchimp-alerts">
                                <div class="mailchimp-submitting"></div>
                                <!-- mailchimp-submitting end -->
                                <div class="mailchimp-success"></div>
                                <!-- mailchimp-success end -->
                                <div class="mailchimp-error"></div>
                                <!-- mailchimp-error end -->
                            </div>
                            <!-- mailchimp-alerts end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Newsletter Area End -->

@endsection

@section('script')
@endsection
