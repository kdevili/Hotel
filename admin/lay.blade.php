<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="../">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('css/style.css') }}">
    <!-- Page Title  -->
    <title>@yield('title')</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="{{ asset('assets/css/dashlite.css?ver=3.0.3') }}">
    <link id="skin-default" rel="stylesheet" href="{{ asset('assets/css/theme.css?ver=3.0.3') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


    <script src="{{ asset('snow/snowfall.js') }}"></script>
    @yield('style')
    @stack('styles')
</head>

<body class="nk-body bg-lighter npc-general has-sidebar  {{ auth()->user()->mode }}">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- sidebar @s -->
            <div class="nk-sidebar nk-sidebar-fixed is-light " data-content="sidebarMenu">
                <div class="nk-sidebar-element nk-sidebar-head">
                    <div class="nk-menu-trigger">
                        <a href="javascript:void(0)" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
                        <a href="javascript:void(0)" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
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
{{--                                <li class="nk-menu-item">--}}
{{--                                    <a href="{{ route('hotel/dashboard/view') }}" class="nk-menu-link">--}}
{{--                                        <span class="nk-menu-icon"><em class="icon ni ni-tranx"></em></span>--}}
{{--                                        <span class="nk-menu-text">Dashboard</span>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
                                <li class="nk-menu-item">
                                    <a href="{{ route('hotel/widget/view') }}" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-puzzle"></em></span>
                                        <span class="nk-menu-text">Widgets</span>
                                    </a>
                                </li>
                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-dot-box"></em></span>
                                        <span class="nk-menu-text">Recipe Details</span>
                                    </a>
                                    <ul class="nk-menu-sub">

                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/view_recipe_details') }}" class="nk-menu-link">
                                                <span class="nk-menu-text">View Recipe</span>
                                            </a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/add_recipe') }}" class="nk-menu-link">
                                                <span class="nk-menu-text">Add Recipe</span>
                                            </a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/view_menu') }}" class="nk-menu-link">
                                                <span class="nk-menu-text">View Menu</span>
                                            </a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/add_menu') }}" class="nk-menu-link">
                                                <span class="nk-menu-text">Add Menu</span>
                                            </a>
                                        </li>
                                    </ul><!-- .nk-menu-sub -->
                                </li><!-- .nk-menu-item -->


                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-menu-circled"></em></span>
                                        <span class="nk-menu-text">Stock</span>
                                    </a>
                                    @php
                                    $stock_category = \App\Item_category::where('hotel_id',auth()->user()->hotel_id)->where('status', 'active')->get();
                                    @endphp

                                    <ul class="nk-menu-sub">
                                        @foreach($stock_category as $category)
                                            <li class="nk-menu-item">
                                                <a href="{{ route('hotel/view_item_category',['id'=>$category->id]) }}" class="nk-menu-link"><span class="nk-menu-text">{{$category->item_category_name}}</span></a>
                                            </li>
                                        @endforeach
                                            <li class="nk-menu-item">
                                                <a href="{{ route('hotel/view_item') }}" class="nk-menu-link"><span class="nk-menu-text">All</span></a>
                                            </li>
                                    </ul><!-- .nk-menu-sub -->
                                </li><!-- .nk-menu-item -->



                                <li class="nk-menu-item">
                                    <a href="{{ route('hotel/supplier') }}" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-cc-new"></em></span>
                                        <span class="nk-menu-text">Supplier</span>
                                    </a>
                                </li>




                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-card-view"></em></span>
                                        <span class="nk-menu-text">GRN</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/grn/view') }}" class="nk-menu-link"><span class="nk-menu-text">GRN List</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/grn/add') }}" class="nk-menu-link"><span class="nk-menu-text">Add GRN</span></a>
                                        </li>
                                    </ul><!-- .nk-menu-sub -->
                                </li><!-- .nk-menu-item -->
                                <li class="nk-menu-item">
                                    <a href="{{ route('hotel/pos/view') }}" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-tranx"></em></span>
                                        <span class="nk-menu-text">POS</span>
                                    </a>
                                </li><!-- .nk-menu-item -->
                                    <li class="nk-menu-item">
                                        <a href="{{ route('hotel/promotion/view') }}" class="nk-menu-link">
                                            <span class="nk-menu-icon"><em class="icon ni ni-tranx"></em></span>
                                            <span class="nk-menu-text">Promotion</span>
                                        </a>
                                    </li><!-- .nk-menu-item -->
                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-trash-alt"></em></span>
                                        <span class="nk-menu-text">Waste</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/waste/add') }}" class="nk-menu-link"><span class="nk-menu-text">Add waste</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/waste/view') }}" class="nk-menu-link"><span class="nk-menu-text">View Waste</span></a>
                                        </li>
                                    </ul><!-- .nk-menu-sub -->
                                </li><!-- .nk-menu-item -->

                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-setting-alt"></em></span>
                                        <span class="nk-menu-text">Maintenance</span>
                                    </a>

                                    <ul class="nk-menu-sub">

                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/repair/add') }}" class="nk-menu-link"><span class="nk-menu-text">Add Repair</span></a>
                                        </li>

                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/repair/view') }}" class="nk-menu-link"><span class="nk-menu-text">View Repair</span></a>
                                        </li>

                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/repair/view_list') }}" class="nk-menu-link"><span class="nk-menu-text">View Repair History</span></a>
                                        </li>
{{--                                        <li class="nk-menu-item">--}}
{{--                                            <a href="{{ route('hotel/location/view') }}" class="nk-menu-link"><span class="nk-menu-text">View Location</span></a>--}}
{{--                                        </li>--}}
{{--                                        <li class="nk-menu-item">--}}
{{--                                            <a href="{{ route('/hotel/reservation/print') }}" class="nk-menu-link"><span class="nk-menu-text">Reservation</span></a>--}}
{{--                                        </li>--}}
                                    </ul><!-- .nk-menu-sub -->
                                </li><!-- .nk-menu-item -->



                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-bulb"></em></span>
                                        <span class="nk-menu-text">Utility</span>
                                    </a>

                                    <ul class="nk-menu-sub">

                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/utility/add') }}" class="nk-menu-link"><span class="nk-menu-text">Add Utility</span></a>
                                        </li>

                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/utility/view') }}" class="nk-menu-link"><span class="nk-menu-text">View Utility</span></a>
                                        </li>

                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/utility/summery') }}" class="nk-menu-link"><span class="nk-menu-text">Utility Summery</span></a>
                                        </li>

{{--                                        <li class="nk-menu-item">--}}
{{--                                            <a href="{{ route('hotel/repair/view_list') }}" class="nk-menu-link"><span class="nk-menu-text">View Repair History</span></a>--}}
{{--                                        </li>--}}
                                        {{--                                        <li class="nk-menu-item">--}}
                                        {{--                                            <a href="{{ route('hotel/location/view') }}" class="nk-menu-link"><span class="nk-menu-text">View Location</span></a>--}}
                                        {{--                                        </li>--}}
                                        {{--                                        <li class="nk-menu-item">--}}
                                        {{--                                            <a href="{{ route('/hotel/reservation/print') }}" class="nk-menu-link"><span class="nk-menu-text">Reservation</span></a>--}}
                                        {{--                                        </li>--}}
                                    </ul><!-- .nk-menu-sub -->
                                </li><!-- .nk-menu-item -->




                                <li class="nk-menu-item">
                                    <a href="{{ route('hotel/invoice') }}" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-file-docs"></em></span>
                                        <span class="nk-menu-text">Past orders</span>
                                    </a>
                                </li>
                                <li class="nk-menu-item">
                                    <a href="{{ route('hotel/kot') }}" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-file-docs"></em></span>
                                        <span class="nk-menu-text">KOT</span>
                                    </a>
                                </li><!-- .nk-menu-item -->
                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-property-alt"></em></span>
                                        <span class="nk-menu-text">Inventory</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/inventory/add_main_categories') }}" class="nk-menu-link"><span class="nk-menu-text">Add Category</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/inventory/view_inventory') }}" class="nk-menu-link"><span class="nk-menu-text">View Inventory</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/inventory/add_inventory_item_bill_view') }}" class="nk-menu-link"><span class="nk-menu-text">Add Inventory Bills</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/inventory/view_inventory_item_bill_list') }}" class="nk-menu-link"><span class="nk-menu-text">View Inventory Bills</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/inventory/waste_management_view') }}" class="nk-menu-link"><span class="nk-menu-text">Inventory Damages</span></a>
                                        </li>
                                    </ul><!-- .nk-menu-sub -->
                                </li><!-- .nk-menu-item -->
                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-property-alt"></em></span>
                                        <span class="nk-menu-text">Cash Book</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/cashbook/cashbook_setting') }}" class="nk-menu-link"><span class="nk-menu-text"> Cash Book Setting</span></a>
                                        </li>
                                        @php
                                        $cash_books = \App\Cashbook::where('hotel_id',auth()->user()->hotel_id)->get();
                                        @endphp
                                        @foreach($cash_books as $cash_book)
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/cashbook/show_cash_book',$cash_book->id) }}" class="nk-menu-link"><span class="nk-menu-text"> {{$cash_book->name}}</span></a>
                                        </li>
                                        @endforeach
                                    </ul><!-- .nk-menu-sub -->
                                </li><!-- .nk-menu-item -->
                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-tranx"></em></span>
                                        <span class="nk-menu-text">Reservations</span>
                                    </a>

                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/reservation/view') }}" class="nk-menu-link"><span class="nk-menu-text">Reservation List</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/reservation/overall_reservation') }}" class="nk-menu-link"><span class="nk-menu-text">Calender</span></a>
                                        </li>
                                    </ul><!-- .nk-menu-sub -->
                                </li><!-- .nk-menu-item -->


                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-notes-alt"></em></span>
                                        <span class="nk-menu-text">Housekeeping</span>
                                    </a>

                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/housekeeping/room_view') }}" class="nk-menu-link"><span class="nk-menu-text">New Check list</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/housekeeping/other_location_view') }}" class="nk-menu-link"><span class="nk-menu-text">Other Location</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/housekeeping/view_checklist') }}" class="nk-menu-link"><span class="nk-menu-text">Check List History</span></a>
                                        </li>
                                    </ul><!-- .nk-menu-sub -->
                                </li><!-- .nk-menu-item -->




{{--                                <li class="nk-menu-item has-sub">--}}
{{--                                    <a href="#" class="nk-menu-link nk-menu-toggle">--}}
{{--                                        <span class="nk-menu-icon"><em class="icon ni ni-notes-alt"></em></span>--}}
{{--                                        <span class="nk-menu-text">House Keeping</span>--}}
{{--                                    </a>--}}
{{--                                    <ul class="nk-menu-sub">--}}
{{--                                        <li class="nk-menu-item">--}}
{{--                                            <a href="{{ route('hotel/housekeeping/checklist') }}" class="nk-menu-link"><span class="nk-menu-text">Add Check List</span></a>--}}
{{--                                        </li>--}}
{{--                                        <li class="nk-menu-item">--}}
{{--                                            <a href="{{ route('hotel/housekeeping/view_checklist') }}" class="nk-menu-link"><span class="nk-menu-text">View Check List</span></a>--}}
{{--                                        </li>--}}
{{--                                    </ul><!-- .nk-menu-sub -->--}}
{{--                                </li><!-- .nk-menu-item -->--}}
                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-contact-fill"></em></span>
                                        <span class="nk-menu-text">Expenses</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/expenses/view') }}" class="nk-menu-link"><span class="nk-menu-text">Add Expenses</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/expenses/view_expenses') }}" class="nk-menu-link"><span class="nk-menu-text">View Expenses</span></a>
                                        </li>
                                    </ul><!-- .nk-menu-sub -->
                                </li><!-- .nk-menu-item -->
                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-calendar-booking-fill"></em></span>
                                        <span class="nk-menu-text">Bookings</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/booking/view_booking') }}" class="nk-menu-link"><span class="nk-menu-text">Booking List</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/booking/add_booking_view') }}" class="nk-menu-link"><span class="nk-menu-text">Add Booking</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/booking/over_roll_booking') }}" class="nk-menu-link"><span class="nk-menu-text">Calender</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/booking/upload_xls') }}" class="nk-menu-link"><span class="nk-menu-text">Upload Excl</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/booking/view_booking_archive') }}" class="nk-menu-link"><span class="nk-menu-text">Archive Bookings</span></a>
                                        </li>
                                    </ul>
                                </li><!-- .nk-menu-item -->
                                <li class="nk-menu-item">
                                    <a href="{{ route('hotel/hotel_invoice') }}" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-tranx"></em></span>
                                        <span class="nk-menu-text">Invoice</span>
                                    </a>
                                </li>


                                <li class="nk-menu-item">
                                    <a href="{{ route('hotel/job_application/view') }}" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-notes-alt"></em></span>
                                        <span class="nk-menu-text">Job Application</span>
                                    </a>
                                </li>

                                <li class="nk-menu-item">
                                    <a href="{{ route('hotel/finance') }}" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-money"></em></span>
                                        <span class="nk-menu-text">Finance</span>
                                    </a>
                                </li>

                                <li class="nk-menu-item">
                                    <a href="{{ route('hotel/customer') }}" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-money"></em></span>
                                        <span class="nk-menu-text">Customer</span>
                                    </a>
                                </li>

                                <li class="nk-menu-item">
                                    <a href="{{ route('agency/agencyAndGuideInfo') }}" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-money"></em></span>
                                        <span class="nk-menu-text">Agency and Guide</span>
                                    </a>
                                </li>

{{--                                <li class="nk-menu-item">--}}
{{--                                    <a href="{{ route('hotel/other_income') }}" class="nk-menu-link">--}}
{{--                                        <span class="nk-menu-icon"><em class="icon ni ni-money"></em></span>--}}
{{--                                        <span class="nk-menu-text">Other Income</span>--}}
{{--                                    </a>--}}
{{--                                </li>--}}

                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-calendar-booking-fill"></em></span>
                                        <span class="nk-menu-text">Other Income</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/other_income/view_list') }}" class="nk-menu-link"><span class="nk-menu-text">Other Income List</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/other_income') }}" class="nk-menu-link"><span class="nk-menu-text">Add Other Income</span></a>
                                        </li>
                                    </ul>
                                </li><!-- .nk-menu-item -->


                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-report-profit"></em></span>
                                        <span class="nk-menu-text">Hotel Room Estimation</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/room_estimate/add_estimate') }}" class="nk-menu-link"><span class="nk-menu-text">Add Estimate</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/room_estimate/view_estimate_details') }}" class="nk-menu-link"><span class="nk-menu-text">View Details</span></a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="nk-menu-item">
                                    <a href="{{ route('hotel/resturant/view') }}" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-money"></em></span>
                                        <span class="nk-menu-text">Resturant</span>
                                    </a>
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
                                    <a class="nk-news-item" href="" data-bs-toggle="modal" data-bs-target="#modalDefault">
                                        <div class="nk-news-icon">
                                            <em class="icon ni ni-home"></em>
                                        </div>
                                        @php($now_stay = \App\Hotel::with('hotel_chain')->where('id',auth()->user()->hotel_id)->first())
                                        <div class="nk-block-des text-soft">
                                            <p>You in <span class="text-warning">{{$now_stay->hotel_chain->name}}</span>  <em class="icon ni ni-forward-arrow-fill"></em>  <span class="text-success">{{$now_stay->hotel_name}}</span></p>
                                        </div>
                                    </a>
                                </div>
                            </div><!-- .nk-header-news -->
                            <div class="nk-header-tools">
                                <ul class="nk-quick-nav">
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
                                                    <li><a href="" data-bs-toggle="modal" data-bs-target="#modalDefault"><em class="icon ni ni-activity-alt"></em><span>Switch Hotel</span></a></li>
                                                    @if(auth()->user()->role == 'Admin')
                                                    <li><a href="{{ route('management/view_hotels',1) }}"><em class="icon ni ni-setting-alt"></em><span>Management</span></a></li>
                                                    @endif
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
                                <div class="modal fade" tabindex="-1" id="modalDefault">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <em class="icon ni ni-cross"></em>
                                            </a>
                                            <div class="modal-header">
                                                <h5 class="modal-title">Switch Hotel</h5>
                                            </div>
                                            @php($hotel_chains = \App\Assigned_hotel::select('hotel_chain_id','user_id')->with('hotel_chain.hotels')->where('user_id',auth()->user()->id)->groupBy('hotel_chain_id','user_id')->get())
                                            <div class="modal-body">
                                                @foreach($hotel_chains as $hotel_chain)
                                                    @foreach($hotel_chain->hotel_chain->hotels as $hotel)
                                                        @if($hotel->status=='Active')
                                                            <a href="{{ route('hotel/switch_hotels',['hotel_id'=>$hotel->id,'hotel_chain_id'=>$hotel->hotel_chain->id]) }}">
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
    <script src="{{ asset('assets/js/example-toastr.js?ver=3.0.3') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


    @yield('script')
    @stack('scripts')
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

</body>

</html>
