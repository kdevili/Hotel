<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="../">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('css/style.css') }}">
    <!-- Page Title  -->
    <title>@yield('title')</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="{{ asset('assets/css/dashlite.css?ver=3.0.3') }}">
    <link id="skin-default" rel="stylesheet" href="{{ asset('assets/css/theme.css?ver=3.0.3') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    @toastr_css
    <script src="{{ asset('snow/snowfall.js') }}"></script>
    @yield('style')
</head>

<body class="nk-body bg-lighter npc-general has-sidebar  {{ auth()->user()->mode }}">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- sidebar @s -->
            <div class="nk-sidebar nk-sidebar-fixed is-light " data-content="sidebarMenu">
                <div class="nk-sidebar-element nk-sidebar-head">
                    <div class="nk-menu-trigger">
                        <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
                        <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
                    </div>
                    <div class="nk-sidebar-brand">
                        <a href="{{route('staff')}}" class="logo-link nk-sidebar-logo">
                            <img class="logo-light logo-img" src="{{ asset('images/logo.png') }}" srcset="{{ asset('images/logo2x.png 2x') }}" alt="logo">
                            <img class="logo-dark logo-img" src="{{ asset('images/logo-dark.png') }}" srcset="{{ asset('images/logo-dark2x.png 2x.png') }}" alt="logo-dark">
                        </a>
                    </div>
                </div><!-- .nk-sidebar-element -->
                <div class="nk-sidebar-element nk-sidebar-body">
                    <div class="nk-sidebar-content">
                        <div class="nk-sidebar-menu" data-simplebar>
                            <ul class="nk-menu">
                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-home"></em></span>
                                        <span class="nk-menu-text">Hotel Management</span>
                                    </a>
                                    @php($hotel_chains = \App\Assigned_hotel::select('hotel_chain_id','user_id')->with('hotel_chain.hotels')->where('user_id',auth()->user()->id)->groupBy('hotel_chain_id','user_id')->get())
                                    <ul class="nk-menu-sub">

                                    @foreach($hotel_chains as $hotel_chain)
                                            <li class="nk-menu-item">
                                                <a href="{{ route('management/view_hotels',$hotel_chain->hotel_chain->id) }}" class="nk-menu-link">
                                                    <span class="nk-menu-text">{{$hotel_chain->hotel_chain->name}}</span>
                                                </a>
                                            </li>
                                        @endforeach
                                        <li class="nk-menu-item">
                                            <a href="{{ route('management/add_hotel_view') }}" class="nk-menu-link">
                                                <span class="nk-menu-text">Add Hotel</span>
                                            </a>
                                        </li>
                                    </ul><!-- .nk-menu-sub -->
                                </li>
                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-users-fill"></em></span>
                                        <span class="nk-menu-text">Users</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        @foreach($hotel_chains as $hotel_chain)
                                        <li class="nk-menu-item">
                                            <a href="#" class="nk-menu-link nk-menu-toggle">
                                                <span class="nk-menu-text">{{$hotel_chain->hotel_chain->name}}</span>
                                            </a>
                                            <ul class="nk-menu-sub">
                                                @foreach($hotel_chain->hotel_chain->hotels as $hotel)
                                                    @if($hotel->status=='Active')
                                                        <li class="nk-menu-item"><a href="{{ route('management/view_users',$hotel->id) }}" class="nk-menu-link"><span class="nk-menu-text">{{$hotel->hotel_name}}</span></a></li>
                                                    @endif
                                                @endforeach
                                            </ul><!-- .nk-menu-sub -->
                                        </li>
                                        @endforeach
                                    </ul><!-- .nk-menu-sub -->
                                </li><!-- .nk-menu-item -->
                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-coffee"></em></span>
                                        <span class="nk-menu-text">Restaurant</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        @foreach($hotel_chains as $hotel_chain)
                                        <li class="nk-menu-item">
                                            <a href="#" class="nk-menu-link nk-menu-toggle">
                                                <span class="nk-menu-text">{{$hotel_chain->hotel_chain->name}}</span>
                                            </a>
                                            <ul class="nk-menu-sub">
                                                @foreach($hotel_chain->hotel_chain->hotels as $hotel)
                                                    @if($hotel->status=='Active')
                                                        <li class="nk-menu-item"><a href="{{ route('management/view_restaurant',$hotel->id) }}" class="nk-menu-link"><span class="nk-menu-text">{{$hotel->hotel_name}}</span></a></li>
                                                    @endif
                                                @endforeach
                                            </ul><!-- .nk-menu-sub -->
                                        </li>
                                        @endforeach
                                    </ul><!-- .nk-menu-sub -->
                                </li><!-- .nk-menu-item -->
                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-user-list-fill"></em></span>
                                        <span class="nk-menu-text">Reservation</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        @foreach($hotel_chains as $hotel_chain)
                                            <li class="nk-menu-item">
                                                <a href="#" class="nk-menu-link nk-menu-toggle">
                                                    <span class="nk-menu-text">{{$hotel_chain->hotel_chain->name}}</span>
                                                </a>
                                                <ul class="nk-menu-sub">
                                                    @foreach($hotel_chain->hotel_chain->hotels as $hotel)
                                                        @if($hotel->status=='Active')
                                                            <li class="nk-menu-item"><a href="{{ route('management/view_reservation',$hotel->id) }}" class="nk-menu-link"><span class="nk-menu-text">{{$hotel->hotel_name}}</span></a></li>
                                                        @endif
                                                    @endforeach
                                                </ul><!-- .nk-menu-sub -->
                                            </li>
                                        @endforeach
                                    </ul><!-- .nk-menu-sub -->
                                </li><!-- .nk-menu-item -->


                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-notes-alt"></em></span>
                                        <span class="nk-menu-text">Housekeeping</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        @foreach($hotel_chains as $hotel_chain)
                                            <li class="nk-menu-item">
                                                <a href="#" class="nk-menu-link nk-menu-toggle">
                                                    <span class="nk-menu-text">{{$hotel_chain->hotel_chain->name}}</span>
                                                </a>
                                                <ul class="nk-menu-sub">
                                                    @foreach($hotel_chain->hotel_chain->hotels as $hotel)
                                                        @if($hotel->status=='Active')
{{--                                                            <li class="nk-menu-item"><a href="{{ route('management/view_housekeeping',$hotel->id) }}" class="nk-menu-link"><span class="nk-menu-text">{{$hotel->hotel_name}}</span></a></li>--}}
                                                            <li class="nk-menu-item"><a href="{{ route('management/view_housekeeping_layout',$hotel->id) }}" class="nk-menu-link"><span class="nk-menu-text">{{$hotel->hotel_name}}</span></a></li>
                                                        @endif
                                                    @endforeach
                                                </ul><!-- .nk-menu-sub -->
                                            </li>
                                        @endforeach
                                    </ul><!-- .nk-menu-sub -->
                                </li><!-- .nk-menu-item -->

                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-houzz"></em></span>
                                        <span class="nk-menu-text">Rooms</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        @foreach($hotel_chains as $hotel_chain)
                                            <li class="nk-menu-item">
                                                <a href="#" class="nk-menu-link nk-menu-toggle">
                                                    <span class="nk-menu-text">{{$hotel_chain->hotel_chain->name}}</span>
                                                </a>
                                                <ul class="nk-menu-sub">
                                                    @foreach($hotel_chain->hotel_chain->hotels as $hotel)
                                                        @if($hotel->status=='Active')
                                                            <li class="nk-menu-item"><a href="{{ route('management/view_rooms',$hotel->id) }}" class="nk-menu-link"><span class="nk-menu-text">{{$hotel->hotel_name}}</span></a></li>
                                                        @endif
                                                    @endforeach
                                                </ul><!-- .nk-menu-sub -->
                                            </li>
                                        @endforeach
                                    </ul><!-- .nk-menu-sub -->
                                </li><!-- .nk-menu-item -->


                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-houzz"></em></span>
                                        <span class="nk-menu-text">Rooms Prices</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        @foreach($hotel_chains as $hotel_chain)
                                            <li class="nk-menu-item">
                                                <a href="#" class="nk-menu-link nk-menu-toggle">
                                                    <span class="nk-menu-text">{{$hotel_chain->hotel_chain->name}}</span>
                                                </a>
                                                <ul class="nk-menu-sub">
                                                    @foreach($hotel_chain->hotel_chain->hotels as $hotel)
                                                        @if($hotel->status=='Active')
                                                            <li class="nk-menu-item"><a href="{{ route('management/view_rooms_prices',$hotel->id) }}" class="nk-menu-link"><span class="nk-menu-text">{{$hotel->hotel_name}}</span></a></li>
                                                        @endif
                                                    @endforeach
                                                </ul><!-- .nk-menu-sub -->
                                            </li>
                                        @endforeach
                                    </ul><!-- .nk-menu-sub -->
                                </li><!-- .nk-menu-item -->


                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-grid-plus-fill"></em></span>
                                        <span class="nk-menu-text">Other Location</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        @foreach($hotel_chains as $hotel_chain)
                                            <li class="nk-menu-item">
                                                <a href="#" class="nk-menu-link nk-menu-toggle">
                                                    <span class="nk-menu-text">{{$hotel_chain->hotel_chain->name}}</span>
                                                </a>
                                                <ul class="nk-menu-sub">
                                                    @foreach($hotel_chain->hotel_chain->hotels as $hotel)
                                                        @if($hotel->status=='Active')
                                                            <li class="nk-menu-item"><a href="{{ route('management/other_location',$hotel->id) }}" class="nk-menu-link"><span class="nk-menu-text">{{$hotel->hotel_name}}</span></a></li>
                                                        @endif
                                                    @endforeach
                                                </ul><!-- .nk-menu-sub -->
                                            </li>
                                        @endforeach
                                    </ul><!-- .nk-menu-sub -->
                                </li><!-- .nk-menu-item -->

                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-setting-alt"></em></span>
                                        <span class="nk-menu-text">Maintenance</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        @foreach($hotel_chains as $hotel_chain)
                                            <li class="nk-menu-item">
                                                <a href="#" class="nk-menu-link nk-menu-toggle">
                                                    <span class="nk-menu-text">{{$hotel_chain->hotel_chain->name}}</span>
                                                </a>
                                                <ul class="nk-menu-sub">
                                                    @foreach($hotel_chain->hotel_chain->hotels as $hotel)
                                                        @if($hotel->status=='Active')
                                                            <li class="nk-menu-item"><a href="{{ route('management/view_maintenance',$hotel->id) }}" class="nk-menu-link"><span class="nk-menu-text">{{$hotel->hotel_name}}</span></a></li>
                                                        @endif
                                                    @endforeach
                                                </ul><!-- .nk-menu-sub -->
                                            </li>
                                        @endforeach
                                    </ul><!-- .nk-menu-sub -->
                                </li><!-- .nk-menu-item -->


                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-bulb"></em></span>
                                        <span class="nk-menu-text">Utility</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        @foreach($hotel_chains as $hotel_chain)
                                            <li class="nk-menu-item">
                                                <a href="#" class="nk-menu-link nk-menu-toggle">
                                                    <span class="nk-menu-text">{{$hotel_chain->hotel_chain->name}}</span>
                                                </a>
                                                <ul class="nk-menu-sub">
                                                    @foreach($hotel_chain->hotel_chain->hotels as $hotel)
                                                        @if($hotel->status=='Active')
                                                            <li class="nk-menu-item"><a href="{{ route('management/view_utility',$hotel->id) }}" class="nk-menu-link"><span class="nk-menu-text">{{$hotel->hotel_name}}</span></a></li>
                                                        @endif
                                                    @endforeach
                                                </ul><!-- .nk-menu-sub -->
                                            </li>
                                        @endforeach
                                    </ul><!-- .nk-menu-sub -->
                                </li><!-- .nk-menu-item -->


                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-note-add"></em></span>
                                        <span class="nk-menu-text">Job Position</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        @foreach($hotel_chains as $hotel_chain)
                                            <li class="nk-menu-item">
                                                <a href="#" class="nk-menu-link nk-menu-toggle">
                                                    <span class="nk-menu-text">{{$hotel_chain->hotel_chain->name}}</span>
                                                </a>
                                                <ul class="nk-menu-sub">
                                                    @foreach($hotel_chain->hotel_chain->hotels as $hotel)
                                                        @if($hotel->status=='Active')
                                                            <li class="nk-menu-item"><a href="{{ route('management/view_job_position',$hotel->id) }}" class="nk-menu-link"><span class="nk-menu-text">{{$hotel->hotel_name}}</span></a></li>
                                                        @endif
                                                    @endforeach
                                                </ul><!-- .nk-menu-sub -->
                                            </li>
                                        @endforeach
                                    </ul><!-- .nk-menu-sub -->
                                </li><!-- .nk-menu-item -->




                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-contact-fill"></em></span>
                                        <span class="nk-menu-text">Expenses</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        @foreach($hotel_chains as $hotel_chain)
                                            <li class="nk-menu-item">
                                                <a href="#" class="nk-menu-link nk-menu-toggle">
                                                    <span class="nk-menu-text">{{$hotel_chain->hotel_chain->name}}</span>
                                                </a>
                                                <ul class="nk-menu-sub">
                                                    @foreach($hotel_chain->hotel_chain->hotels as $hotel)
                                                        @if($hotel->status=='Active')
                                                            <li class="nk-menu-item"><a href="{{ route('management/view_expenses',$hotel->id) }}" class="nk-menu-link"><span class="nk-menu-text">{{$hotel->hotel_name}}</span></a></li>
                                                        @endif
                                                    @endforeach
                                                </ul><!-- .nk-menu-sub -->
                                            </li>
                                        @endforeach
                                    </ul><!-- .nk-menu-sub -->
                                </li><!-- .nk-menu-item -->

                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-menu-circled"></em></span>
                                        <span class="nk-menu-text">Stock</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        @foreach($hotel_chains as $hotel_chain)
                                            <li class="nk-menu-item">
                                                <a href="#" class="nk-menu-link nk-menu-toggle">
                                                    <span class="nk-menu-text">{{$hotel_chain->hotel_chain->name}}</span>
                                                </a>
                                                <ul class="nk-menu-sub">
                                                    @foreach($hotel_chain->hotel_chain->hotels as $hotel)
                                                        @if($hotel->status=='Active')
                                                            <li class="nk-menu-item"><a href="{{ route('management/view_stock',$hotel->id) }}" class="nk-menu-link"><span class="nk-menu-text">{{$hotel->hotel_name}}</span></a></li>
                                                        @endif
                                                    @endforeach
                                                </ul><!-- .nk-menu-sub -->
                                            </li>
                                        @endforeach
                                    </ul><!-- .nk-menu-sub -->
                                </li><!-- .nk-menu-item -->

                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-view-grid-fill"></em></span>
                                        <span class="nk-menu-text">Table</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        @foreach($hotel_chains as $hotel_chain)
                                            <li class="nk-menu-item">
                                                <a href="#" class="nk-menu-link nk-menu-toggle">
                                                    <span class="nk-menu-text">{{$hotel_chain->hotel_chain->name}}</span>
                                                </a>
                                                <ul class="nk-menu-sub">
                                                    @foreach($hotel_chain->hotel_chain->hotels as $hotel)
                                                        @if($hotel->status=='Active')
                                                            <li class="nk-menu-item"><a href="{{ route('management/view_table',$hotel->id) }}" class="nk-menu-link"><span class="nk-menu-text">{{$hotel->hotel_name}}</span></a></li>
                                                        @endif
                                                    @endforeach
                                                </ul><!-- .nk-menu-sub -->
                                            </li>
                                        @endforeach
                                    </ul><!-- .nk-menu-sub -->
                                </li><!-- .nk-menu-item -->

                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-list-thumb-fill"></em></span>
                                        <span class="nk-menu-text">Other Income</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        @foreach($hotel_chains as $hotel_chain)
                                            <li class="nk-menu-item">
                                                <a href="#" class="nk-menu-link nk-menu-toggle">
                                                    <span class="nk-menu-text">{{$hotel_chain->hotel_chain->name}}</span>
                                                </a>
                                                <ul class="nk-menu-sub">
                                                    @foreach($hotel_chain->hotel_chain->hotels as $hotel)
                                                        @if($hotel->status=='Active')
                                                            <li class="nk-menu-item"><a href="{{ route('management/other_income',$hotel->id) }}" class="nk-menu-link"><span class="nk-menu-text">{{$hotel->hotel_name}}</span></a></li>
                                                        @endif
                                                    @endforeach
                                                </ul><!-- .nk-menu-sub -->
                                            </li>
                                        @endforeach
                                    </ul><!-- .nk-menu-sub -->
                                </li><!-- .nk-menu-item -->



                            </ul><!-- .nk-menu -->
                        </div><!-- .nk-sidebar-menu -->
                    </div><!-- .nk-sidebar-content -->
                </div><!-- .nk-sidebar-element -->
            </div>
            <!-- sidebar @e -->
            <!-- wrap @s -->
            <div class="nk-wrap ">
                <!-- main header @s -->
                <div class="nk-header nk-header-fixed is-light">
                    <div class="container-fluid">
                        <div class="nk-header-wrap">
                            <div class="nk-menu-trigger d-xl-none ms-n1">
                                <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
                            </div>
                            <div class="nk-header-brand d-xl-none">
                                <a href="html/index.html" class="logo-link">
                                    <img class="logo-light logo-img" src="{{ asset('images/logo.png') }}" srcset="{{ asset('images/logo2x.png 2x.png') }}" alt="logo">
                                    <img class="logo-dark logo-img" src="{{ asset('images/logo-dark.png') }}" srcset="{{ asset('images/logo-dark2x.png 2x.png') }}" alt="logo-dark">
                                </a>
                            </div><!-- .nk-header-brand -->
                            <div class="nk-header-news">
                                <div class="nk-news-list">
                                            <a class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalDefault_switch_hotel"><em class="icon ni ni-activity-alt"></em><span>Switch Hotel</span></a>
                                </div>
                            </div><!-- .nk-header-news -->
                            <div class="nk-header-tools">
                                <ul class="nk-quick-nav">

                                    {{--                                    <li class="dropdown language-dropdown d-none d-sm-block me-n1">--}}
                                    {{--                                        <a href="#" class="dropdown-toggle nk-quick-nav-icon" data-bs-toggle="dropdown">--}}
                                    {{--                                            <div class="quick-icon border border-light">--}}
                                    {{--                                                <img class="icon" src="{{ asset('images/flags/english-sq.png') }}" alt="">--}}
                                    {{--                                            </div>--}}
                                    {{--                                        </a>--}}
                                    {{--                                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-s1">--}}
                                    {{--                                            <ul class="language-list">--}}
                                    {{--                                                <li>--}}
                                    {{--                                                    <a href="#" class="language-item">--}}
                                    {{--                                                        <img src="{{ asset('images/flags/english.png') }}" alt="" class="language-flag">--}}
                                    {{--                                                        <span class="language-name">English</span>--}}
                                    {{--                                                    </a>--}}
                                    {{--                                                </li>--}}
                                    {{--                                                <li>--}}
                                    {{--                                                    <a href="#" class="language-item">--}}
                                    {{--                                                        <img src="{{ asset('images/flags/spanish.png') }}" alt="" class="language-flag">--}}
                                    {{--                                                        <span class="language-name">Español</span>--}}
                                    {{--                                                    </a>--}}
                                    {{--                                                </li>--}}
                                    {{--                                                <li>--}}
                                    {{--                                                    <a href="#" class="language-item">--}}
                                    {{--                                                        <img src="{{ asset('images/flags/french.png') }}" alt="" class="language-flag">--}}
                                    {{--                                                        <span class="language-name">Français</span>--}}
                                    {{--                                                    </a>--}}
                                    {{--                                                </li>--}}
                                    {{--                                                <li>--}}
                                    {{--                                                    <a href="#" class="language-item">--}}
                                    {{--                                                        <img src="{{ asset('images/flags/turkey.png') }}" alt="" class="language-flag">--}}
                                    {{--                                                        <span class="language-name">Türkçe</span>--}}
                                    {{--                                                    </a>--}}
                                    {{--                                                </li>--}}
                                    {{--                                            </ul>--}}
                                    {{--                                        </div>--}}
                                    {{--                                    </li><!-- .dropdown -->--}}
                                    <li class="dropdown user-dropdown">
                                        <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                                            <div class="user-toggle">
                                                <div class="user-avatar sm">
                                                    <em class="icon ni ni-user-alt"></em>
                                                </div>
                                                <div class="user-info d-none d-md-block">
                                                    <div class="user-status">Administrator</div>
                                                    <div class="user-name dropdown-indicator">{{ auth()->user()->name }} {{ auth()->user()->lname }}</div>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-end dropdown-menu-s1">
                                            <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                                <div class="user-card">
                                                    <div class="user-avatar">
                                                        <span>AB</span>
                                                    </div>
                                                    <div class="user-info">
                                                        <span class="lead-text">{{ auth()->user()->name }} {{ auth()->user()->lname }}</span>
                                                        <span class="sub-text">{{ auth()->user()->email }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="dropdown-inner">
                                                <ul class="link-list">
                                                    {{--                                                    <li><a href="html/user-profile-regular.html"><em class="icon ni ni-user-alt"></em><span>View Profile</span></a></li>--}}
                                                    {{--                                                    <li><a href="html/user-profile-setting.html"><em class="icon ni ni-setting-alt"></em><span>Account Setting</span></a></li>--}}
                                                    <li><a class="dark-switch" href="#" onclick="dark_switch()"><em class="icon ni ni-moon"></em><span>Dark Mode</span></a></li>
                                                    <li><a href="" data-bs-toggle="modal" data-bs-target="#modalDefault_switch_hotel"><em class="icon ni ni-activity-alt"></em><span>Switch Hotel</span></a></li>

                                                </ul>
                                            </div>
                                            <div class="dropdown-inner">
                                                <ul class="link-list">
                                                    <li>
                                                        <a href="{{ route('logout') }}"
                                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                            <em class="icon ni ni-signout"></em><span>Sign out</span>
                                                        </a>

                                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                            @csrf
                                                        </form>

                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li><!-- .dropdown -->
                                    <li class="dropdown notification-dropdown me-n1">
                                        <a href="#" class="dropdown nk-quick-nav-icon" data-bs-toggle="">
                                            <div class="icon-status icon-status-info"><em class="icon ni ni-bell"></em></div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end dropdown-menu-s1">
                                            <div class="dropdown-head">
                                                <span class="sub-title nk-dropdown-title">Notifications</span>
                                                <a href="#">Mark All as Read</a>
                                            </div>
                                            <div class="dropdown-body">
                                                <div class="nk-notification">
                                                    <div class="nk-notification-item dropdown-inner">
                                                        <div class="nk-notification-icon">
                                                            <em class="icon icon-circle bg-warning-dim ni ni-curve-down-right"></em>
                                                        </div>
                                                        <div class="nk-notification-content">
                                                            <div class="nk-notification-text">You have requested to <span>Widthdrawl</span></div>
                                                            <div class="nk-notification-time">2 hrs ago</div>
                                                        </div>
                                                    </div>
                                                    <div class="nk-notification-item dropdown-inner">
                                                        <div class="nk-notification-icon">
                                                            <em class="icon icon-circle bg-success-dim ni ni-curve-down-left"></em>
                                                        </div>
                                                        <div class="nk-notification-content">
                                                            <div class="nk-notification-text">Your <span>Deposit Order</span> is placed</div>
                                                            <div class="nk-notification-time">2 hrs ago</div>
                                                        </div>
                                                    </div>
                                                    <div class="nk-notification-item dropdown-inner">
                                                        <div class="nk-notification-icon">
                                                            <em class="icon icon-circle bg-warning-dim ni ni-curve-down-right"></em>
                                                        </div>
                                                        <div class="nk-notification-content">
                                                            <div class="nk-notification-text">You have requested to <span>Widthdrawl</span></div>
                                                            <div class="nk-notification-time">2 hrs ago</div>
                                                        </div>
                                                    </div>
                                                    <div class="nk-notification-item dropdown-inner">
                                                        <div class="nk-notification-icon">
                                                            <em class="icon icon-circle bg-success-dim ni ni-curve-down-left"></em>
                                                        </div>
                                                        <div class="nk-notification-content">
                                                            <div class="nk-notification-text">Your <span>Deposit Order</span> is placed</div>
                                                            <div class="nk-notification-time">2 hrs ago</div>
                                                        </div>
                                                    </div>
                                                    <div class="nk-notification-item dropdown-inner">
                                                        <div class="nk-notification-icon">
                                                            <em class="icon icon-circle bg-warning-dim ni ni-curve-down-right"></em>
                                                        </div>
                                                        <div class="nk-notification-content">
                                                            <div class="nk-notification-text">You have requested to <span>Widthdrawl</span></div>
                                                            <div class="nk-notification-time">2 hrs ago</div>
                                                        </div>
                                                    </div>
                                                    <div class="nk-notification-item dropdown-inner">
                                                        <div class="nk-notification-icon">
                                                            <em class="icon icon-circle bg-success-dim ni ni-curve-down-left"></em>
                                                        </div>
                                                        <div class="nk-notification-content">
                                                            <div class="nk-notification-text">Your <span>Deposit Order</span> is placed</div>
                                                            <div class="nk-notification-time">2 hrs ago</div>
                                                        </div>
                                                    </div>
                                                </div><!-- .nk-notification -->
                                            </div><!-- .nk-dropdown-body -->
                                            <div class="dropdown-foot center">
                                                <a href="#">View All</a>
                                            </div>
                                        </div>
                                    </li><!-- .dropdown -->
                                </ul><!-- .nk-quick-nav -->
                            </div><!-- .nk-header-tools -->
                        </div><!-- .nk-header-wrap -->
                    </div><!-- .container-fliud -->
                </div>
                <!-- main header @e -->
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                @yield('content')
                                <div class="modal fade" tabindex="-1" id="modalDefault_switch_hotel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <em class="icon ni ni-cross"></em>
                                            </a>
                                            <div class="modal-header">
                                                <h5 class="modal-title">Switch Hotel</h5>
                                            </div>
                                            <div class="modal-body">
                                                @foreach($hotel_chains as $hotel_chain)
                                                    @foreach($hotel_chain->hotel_chain->hotels as $hotel)
                                                        @if($hotel->status=='Active')
                                                            <a href="{{ route('switch_hotels',['hotel_id'=>$hotel->id,'hotel_chain_id'=>$hotel->hotel_chain->id]) }}">
                                                                <div class="card-inner card-inner-md">
                                                                    <div class="user-card">
                                                                        <div class="user-avatar bg-primary-dim">
                                                                            <span>AB</span>
                                                                        </div>
                                                                        <div class="user-info">
                                                                            <span class="lead-text">{{$hotel->hotel_name}}</span>
                                                                            <span class="sub-text">{{$hotel->hotel_chain->name}}</span>
                                                                        </div>
                                                                        <div class="user-action">
                                                                            {{--                                                            <div class="drodown">--}}
                                                                            {{--                                                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger me-n1" data-bs-toggle="dropdown" aria-expanded="false"><em class="icon ni ni-more-h"></em></a>--}}
                                                                            {{--                                                                <div class="dropdown-menu dropdown-menu-end">--}}
                                                                            {{--                                                                    <ul class="link-list-opt no-bdr">--}}
                                                                            {{--                                                                        <li><a href="#"><em class="icon ni ni-setting"></em><span>Action Settings</span></a></li>--}}
                                                                            {{--                                                                        <li><a href="#"><em class="icon ni ni-notify"></em><span>Push Notification</span></a></li>--}}
                                                                            {{--                                                                    </ul>--}}
                                                                            {{--                                                                </div>--}}
                                                                            {{--                                                            </div>--}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        @endif
                                                @endforeach
                                                @endforeach
                                            </div>
                                            <div class="modal-footer bg-light">
                                                <button type="button" class="btn btn-danger btn-lg" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content @e -->
                <!-- footer @s -->
                <div class="nk-footer">
                    <div class="container-fluid">
                        <div class="nk-footer-wrap">
                            <div class="nk-footer-copyright"> &copy; {{ date('Y') }}  <a href="https://ravantangalle.com" target="_blank">Ravan Tangalle</a>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- footer @e -->
            </div>
            <!-- wrap @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->


    <script src="{{ asset('assets/js/bundle.js?ver=3.0.3') }}"></script>
    <script src="{{ asset('assets/js/scripts.js?ver=3.0.3') }}"></script>
    <script src="{{ asset('assets/js/libs/datatable-btns.js?ver=3.0.3') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="{{ asset('assets/js/example-toastr.js?ver=3.0.3') }}"></script>
    @toastr_js
    @yield('script')
    <script>

        function dark_switch() {
            if (!$('.dark-switch').hasClass('active')){
                var mode = 'dark-mode';
            }else{
                var mode = '';

            }
            $.ajax({
                type:'POST',
                url:'{{ route('modechange') }}',
                headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                data: {
                    'mode' : mode,
                },
                success:function(data){

                }

            });
        }
    </script>
    @toastr_render
</body>

</html>
