<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @yield('metadata')


    <!-- StyleSheets  -->
    <link rel="stylesheet" href="{{ asset('assets/css/dashlite.css?ver=3.0.3') }}">
    <link id="skin-default" rel="stylesheet" href="{{ asset('assets/css/theme.css?ver=3.0.3') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <link rel="icon" href="https://ravantangalle.com/wp-content/uploads/2022/04/cropped-cropped-download__5_-removebg-preview-1-32x32.png" sizes="32x32" />
    <link rel="icon" href="https://ravantangalle.com/wp-content/uploads/2022/04/cropped-cropped-download__5_-removebg-preview-1-192x192.png" sizes="192x192" />
    <link rel="apple-touch-icon" href="https://ravantangalle.com/wp-content/uploads/2022/04/cropped-cropped-download__5_-removebg-preview-1-180x180.png" />
    <script src="{{ asset('snow/snowfall.js') }}"></script>
    @yield('style')
    <style>
        body {
            background-image: url('https://ravantangalle.com/wp-content/uploads/2022/06/LS_B2_Main-landing-page_1920x700.jpeg');
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
        }
    </style>
    <style>
        /* Styles for the dark overlay */
        .loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8); /* Adjust the opacity as needed */
            z-index: 9998;
        }

        /* Styles for the loader */
        .loader {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
        }

        /* Styles for the spinner animation */
        .loader::after {
            content: '';
            display: block;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>

<body class="nk-body bg-white npc-general pg-auth">
<div class="loading-overlay" id="loading-overlay"></div>
<div class="loader" id="loader"></div>


<div class="nk-app-root">
    <!-- main @s -->

    <div class="nk-main ">
        <!-- wrap @s -->
        <div class="nk-wrap nk-wrap-nosidebar">
            <!-- content @s -->
            <div class="nk-content ">
                @yield('content')
                <div class="nk-footer nk-auth-footer-full">
                    <div class="container wide-lg">
                        <div class="row g-3">
                            <div class="col-lg-6 order-lg-last">
                                <ul class="nav nav-sm justify-content-center justify-content-lg-end">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Terms & Condition</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Privacy Policy</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Help</a>
                                    </li>
                                    <li class="nav-item dropup">
                                        <a class="dropdown-toggle dropdown-indicator has-indicator nav-link" data-bs-toggle="dropdown" data-offset="0,10"><span>English</span></a>
                                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                            <ul class="language-list">
                                                <li>
                                                    <a href="#" class="language-item">
                                                        <img src="./images/flags/english.png" alt="" class="language-flag">
                                                        <span class="language-name">English</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="language-item">
                                                        <img src="./images/flags/spanish.png" alt="" class="language-flag">
                                                        <span class="language-name">Español</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="language-item">
                                                        <img src="./images/flags/french.png" alt="" class="language-flag">
                                                        <span class="language-name">Français</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="language-item">
                                                        <img src="./images/flags/turkey.png" alt="" class="language-flag">
                                                        <span class="language-name">Türkçe</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-6">
                                <div class="nk-block-content text-center text-lg-start">
                                    <p class="text-soft">&copy; 2023 HMS. All Rights Reserved.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- wrap @e -->
        </div>
        <!-- content @e -->
    </div>
    <!-- main @e -->
</div>
<!-- app-root @e -->
<!-- JavaScript -->
</body>
<script src="{{ asset('assets/js/bundle.js?ver=3.0.3') }}"></script>
<script src="{{ asset('assets/js/scripts.js?ver=3.0.3') }}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
@yield('script')
<script>
    function showLoading() {
        document.getElementById("loading-overlay").style.display = "block";
        document.getElementById("loader").style.display = "block";
    }

    function hideLoading() {
        document.getElementById("loading-overlay").style.display = "none";
        document.getElementById("loader").style.display = "none";
    }
</script>
</html>
