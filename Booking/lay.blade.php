<!DOCTYPE html>
<html class="no-js" lang="en">

<!-- Mirrored from htmldemo.net/oestin/oestin/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 30 May 2023 10:09:12 GMT -->
<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Oestin - Hotel & Resort HTML Template</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Favicon Icon -->
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico" />

    <!-- All css here -->
    <script src="js/vendor/modernizr-2.8.3.min.js"></script>
    <link rel="stylesheet" href="{{ asset('booking_s/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('booking_s/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('booking_s/css/shortcode/shortcodes.css') }}">
    <link rel="stylesheet" href="{{ asset('booking_s/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('booking_s/css/responsive.css') }}">
    <script src="{{ asset('booking_s/js/vendor/modernizr-2.8.3.min.js') }}"></script>
    <script src="{{ asset('snow/snowfall.js') }}"></script>
    @yield('style')
</head>

<body>
<!--[if lt IE 8]>
<p class="browserupgrade">
    You are using an <strong>outdated</strong> browser. Please
    <a href="https://browsehappy.com/">upgrade your browser</a> to improve
    your experience.
</p>
<![endif]-->

<!-- Header Area Start -->
<header class="header-area fixed header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-xl-5 col-lg-4 col-sm-4 col-12">
                <div class="logo">
                    <a href="index.html"
                    ><img src="{{ asset('booking_s/img/logo/logo.png')}}" alt="Oestin"
                        /></a>
                </div>
            </div>
            <div class="col-xl-7 col-lg-8 col-sm-8 col-12">
                <div class="header-top fix">
                    <div class="header-contact">
                        <span class="text-theme">Contact:</span>
                        <span>0123456789</span>
                    </div>
                    <div class="header-links">
                        <a href="https://www.facebook.com/"
                        ><i class="zmdi zmdi-facebook"></i
                            ></a>
                        <a href="https://twitter.com/"
                        ><i class="zmdi zmdi-twitter"></i
                            ></a>
                        <a href="https://plus.google.com/"
                        ><i class="zmdi zmdi-google-plus"></i
                            ></a>
                        <a href="https://www.instagram.com/"
                        ><i class="zmdi zmdi-instagram"></i
                            ></a>
                        <a href="https://www.pinterest.com/"
                        ><i class="zmdi zmdi-pinterest"></i
                            ></a>
                    </div>
                </div>
                <!-- Mainmenu Start -->
                <div class="main-menu d-none d-lg-block">
                    <nav>
                        <ul>
{{--                            <li><a href="index.html">HOME</a></li>--}}
{{--                            <li>--}}
{{--                                <a href="room-grid.html">ROOMS</a>--}}
{{--                                <ul class="submenu">--}}
{{--                                    <li><a href="room-list.html">ROOM LIST</a></li>--}}
{{--                                    <li><a href="room-details.html">ROOM DETAILS</a></li>--}}
{{--                                </ul>--}}
{{--                            </li>--}}
{{--                            <li>--}}
{{--                                <a href="#">ACTIVITIES</a>--}}
{{--                                <ul class="submenu megamenu">--}}
{{--                                    <li>--}}
{{--                                        <a href="#">Megamenu List</a>--}}
{{--                                        <ul>--}}
{{--                                            <li><a href="location.html">Location</a></li>--}}
{{--                                            <li><a href="room-grid.html">Room Grid</a></li>--}}
{{--                                            <li><a href="room-list.html">Room List</a></li>--}}
{{--                                            <li><a href="room-details.html">Room Details</a></li>--}}
{{--                                            <li><a href="#">Mega menu</a></li>--}}
{{--                                        </ul>--}}
{{--                                    </li>--}}
{{--                                    <li>--}}
{{--                                        <a href="#">Megamenu List</a>--}}
{{--                                        <ul>--}}
{{--                                            <li><a href="event.html">Event</a></li>--}}
{{--                                            <li><a href="#">Mega menu</a></li>--}}
{{--                                            <li><a href="contact.html">Contact</a></li>--}}
{{--                                            <li><a href="team.html">Team</a></li>--}}
{{--                                            <li><a href="#">Mega menu</a></li>--}}
{{--                                        </ul>--}}
{{--                                    </li>--}}
{{--                                    <li>--}}
{{--                                        <a href="#">Megamenu List</a>--}}
{{--                                        <ul>--}}
{{--                                            <li><a href="room-list.html">Room List</a></li>--}}
{{--                                            <li><a href="#">Mega menu</a></li>--}}
{{--                                            <li><a href="room-grid.html">Room Grid</a></li>--}}
{{--                                            <li><a href="room-details.html">Room Details</a></li>--}}
{{--                                            <li><a href="#">Mega menu</a></li>--}}
{{--                                        </ul>--}}
{{--                                    </li>--}}
{{--                                </ul>--}}
{{--                            </li>--}}
{{--                            <li><a href="location.html">LOCATION</a></li>--}}
{{--                            <li><a href="event.html">EVENT</a></li>--}}
{{--                            <li><a href="team.html">TEAM</a></li>--}}
{{--                            <li><a href="contact.html">CONTACT</a></li>--}}
                        </ul>
                    </nav>
                </div>
                <!-- Mainmenu End -->
            </div>
        </div>
    </div>
    <!-- Mobile Menu Area start -->
    <div class="mobile-menu-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="mobile-menu">
                        <nav id="dropdown">
                            <ul>
{{--                                <li><a href="index.html">HOME</a></li>--}}
{{--                                <li>--}}
{{--                                    <a href="room-grid.html">ROOMS</a>--}}
{{--                                    <ul class="submenu">--}}
{{--                                        <li><a href="room-list.html">ROOM LIST</a></li>--}}
{{--                                        <li><a href="room-details.html">ROOM DETAILS</a></li>--}}
{{--                                    </ul>--}}
{{--                                </li>--}}
{{--                                <li><a href="location.html">LOCATION</a></li>--}}
{{--                                <li><a href="event.html">EVENT</a></li>--}}
{{--                                <li><a href="team.html">TEAM</a></li>--}}
{{--                                <li><a href="contact.html">CONTACT</a></li>--}}
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Mobile Menu Area end -->
</header>
<!-- Header Area End -->
<!-- Background Area Start -->
<section class="slider-area">
    <div class="slider-wrapper">
        <div class="single-slide"style="background-image: url({{ asset('booking_s/img/slider/home.jpeg') }})">
            <div class="banner-content overlay">
                <div class="container">
                    <div class="row">
                        <div class="col-md-10 mx-auto">
                            <div class="text-content-wrapper">
                                <div class="text-content text-center">
                                    <h1 class="pt-180">Book Today</h1>
                                    <p>
                                       HOT WEEKEND OFFER
                                    </p>
{{--                                    <div class="banner-btn">--}}
{{--                                        <a class="default-btn" href="room-grid.html">explore</a>--}}
{{--                                    </div>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="single-slide" style="background-image: url({{ asset('booking_s/img/slider/2.jpg') }}">
            <div class="banner-content overlay">
                <div class="container">
                    <div class="row">
                        <div class="col-md-10 mx-auto">
                            <div class="text-content-wrapper slide-two">
                                <div class="text-content text-center">
                                    <h1 class="pt-180">Book Today</h1>
                                    <p>
                                        HOT WEEKEND OFFER
                                    </p>
{{--                                    <div class="banner-btn">--}}
{{--                                        <a class="default-btn" href="room-grid.html">explore</a>--}}
{{--                                    </div>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Background Area End -->
@yield('content')
<!-- Footer Area Start -->
<footer class="footer-area">
    <!-- Footer Widget Start -->
    <div class="footer-widget-area bg-dark">
        <div class="container">
            <div class="row mb-n60">
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-60">
                    <div class="single-footer-widget">
                        <div class="footer-logo">
                            <a href="index.html"
                            ><img src="{{ asset('booking_s/img/logo/ravanlogo.png')}}" alt="Oestin"
                                /></a>
                        </div>
                        <p>
                            Spend your holiday at Ravan Tangalle

                            The Ravan Resort offers delicious meals to your liking as requested.
                            A healthy touch to your stay.

                            Spend your day living your best moments, choose The Ravan Resort for your stay.
                        </p>
                        <div class="social-icons">
                            <a href="#/"><i class="zmdi zmdi-facebook"></i></a>
                            <a href="#/"><i class="zmdi zmdi-instagram"></i></a>
                            <a href="#/"><i class="zmdi zmdi-rss"></i></a>
                            <a href="#/"><i class="zmdi zmdi-twitter"></i></a>
                            <a href="#/"><i class="zmdi zmdi-pinterest"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 offset-lg-1 col-lg-4  col-md-6 col-sm-6 col-12 mb-60">
                    <div class="single-footer-widget">
                        <h3>contact us</h3>
                        <div class="c-info">
                            <span><i class="zmdi zmdi-pin"></i></span>
                            <span>Your address <br />goes here</span>
                        </div>
                        <div class="c-info">
                            <span><i class="zmdi zmdi-email"></i></span>
                            <span>demo@example.com<br />demo@example.com</span>
                        </div>
                        <div class="c-info">
                            <span><i class="zmdi zmdi-phone"></i></span>
                            <span>0123456789<br />0123456789</span>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-12 mb-60">
                    <div class="single-footer-widget">
                        <h3>quick links</h3>
                        <ul class="footer-list">
                            <li><a href="index.html">Home</a></li>
{{--                            <li><a href="team.html">Stuffs</a></li>--}}
{{--                            <li><a href="room-grid.html">Suits &amp; Rooms</a></li>--}}
{{--                            <li><a href="event.html">Event</a></li>--}}
{{--                            <li><a href="location.html">Location</a></li>--}}
{{--                            <li><a href="contact.html">Contact</a></li>--}}
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-60">
                    <div class="single-footer-widget">
                        <h3>collections</h3>
                        <div class="instagram-image">
                            <div class="footer-img">
                                <a href="room-grid.html"
                                ><img src="{{ asset('booking_s/img/footer/1.jpg')}}" alt=""
                                    /></a>
                            </div>
                            <div class="footer-img">
                                <a href="room-grid.html"
                                ><img src="{{ asset('booking_s/img/footer/2.jpg')}}" alt=""
                                    /></a>
                            </div>
                            <div class="footer-img">
                                <a href="room-grid.html"
                                ><img src="{{ asset('booking_s/img/footer/3.jpg')}}" alt=""
                                    /></a>
                            </div>
                            <div class="footer-img">
                                <a href="room-grid.html"
                                ><img src="{{ asset('booking_s/img/footer/4.jpg')}}" alt=""
                                    /></a>
                            </div>
                            <div class="footer-img">
                                <a href="room-grid.html"
                                ><img src="{{ asset('booking_s/img/footer/5.jpg')}}" alt=""
                                    /></a>
                            </div>
                            <div class="footer-img">
                                <a href="room-grid.html"
                                ><img src="{{ asset('booking_s/img/footer/6.jpg')}}" alt=""
                                    /></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Widget End -->
    <!-- Footer Bottom Area Start -->
    <div class="footer-bottom-area bg-black">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-auto">
                    <div class="footer-text text-center">
{{--                <span>© 2021 <b class="text-white">Oestin</b> Made with <i class="fa fa-heart text-danger"></i> by <a href="https://hasthemes.com/"><b>HasThemes</b></a><span>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Bottom Area End -->
</footer>
<!-- Footer Area End -->

<!-- All js here -->
<script src="{{ asset('booking_s/js/vendor/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('booking_s/js/vendor/jquery-migrate-3.3.2.min.js') }}"></script>
<script src="{{ asset('booking_s/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('booking_s/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('booking_s/js/ajax-mail.js') }}"></script>
<script src="{{ asset('booking_s/js/jquery.ajaxchimp.min.js') }}"></script>
<script src="{{ asset('booking_s/js/jquery.meanmenu.js') }}"></script>
<script src="{{ asset('booking_s/js/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('booking_s/js/waypoints.min.js') }}"></script>
<script src="{{ asset('booking_s/js/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('booking_s/js/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ asset('booking_s/js/jquery.magnific-popup.js') }}"></script>
<script src="{{ asset('booking_s/js/plugins.js') }}"></script>
<script src="{{ asset('booking_s/js/main.js') }}"></script>
@yield('script')
</body>

<!-- Mirrored from htmldemo.net/oestin/oestin/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 30 May 2023 10:09:20 GMT -->
</html>
