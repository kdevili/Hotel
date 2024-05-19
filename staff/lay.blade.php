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
                @php($privilege = \App\Privilege::where('user_id',auth()->user()->id)->where('hotel_id',auth()->user()->hotel_id)->where('hotel_chain_id',auth()->user()->hotel_chain_id)->first())
                <div class="nk-sidebar-element nk-sidebar-body">
                    <div class="nk-sidebar-content">
                        <div class="nk-sidebar-menu" data-simplebar>
                            <ul class="nk-menu">
                                <li class="nk-menu-heading">
                                    <h6 class="overline-title text-primary-alt">Pre-Built Pages</h6>
                                </li><!-- .nk-menu-heading -->
{{--                                <li class="nk-menu-item">--}}
{{--                                    <a href="{{ route('hotel/dashboard/view') }}" class="nk-menu-link">--}}
{{--                                        <span class="nk-menu-icon"><em class="icon ni ni-tranx"></em></span>--}}
{{--                                        <span class="nk-menu-text">Dashboard</span>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
                                @if($privilege->utility_widget == 'Allow' or $privilege->maintenance_widget == 'Allow' or $privilege->housekeeping_widget == 'Allow' or $privilege->booking_widget == 'Allow' or $privilege->reservation_widget == 'Allow' or $privilege->pos_widget == 'Allow' or $privilege->grn_widget == 'Allow')
                                    <li class="nk-menu-item">
                                        <a href="{{ route('hotel/widget/view') }}" class="nk-menu-link">
                                            <span class="nk-menu-icon"><em class="icon ni ni-puzzle"></em></span>
                                            <span class="nk-menu-text">Widgets</span>
                                        </a>
                                    </li>
                                @endif












                                @if($privilege->customer_view == 'Allow')
                                    <li class="nk-menu-item has-sub">
                                        <a href="#" class="nk-menu-link nk-menu-toggle">
                                            <span class="nk-menu-icon"><em class="icon ni ni-user-list-fill"></em></span>
                                            <span class="nk-menu-text">Customer</span>
                                        </a>
                                        <ul class="nk-menu-sub">

                                            <li class="nk-menu-item">
                                                <a href="{{ route('hotel/customer') }}" class="nk-menu-link"><span class="nk-menu-text">View Customer</span></a>
                                            </li>
                                        </ul><!-- .nk-menu-sub -->
                                    </li>
                                @endif


                                @if($privilege->grn_view == 'Allow')
                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-card-view"></em></span>
                                        <span class="nk-menu-text">GRN</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/grn/view') }}" class="nk-menu-link"><span class="nk-menu-text">GRN List</span></a>
                                        </li>
                                        @if($privilege->grn_add == 'Allow')
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/grn/add') }}" class="nk-menu-link"><span class="nk-menu-text">Add GRN</span></a>
                                        </li>
                                        @endif
                                    </ul><!-- .nk-menu-sub -->
                                </li><!-- .nk-menu-item -->
                                @endif

                                    @if($privilege->pos_view == 'Allow')
                                <li class="nk-menu-item">
                                    <a href="{{ route('hotel/pos/view') }}" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-tranx"></em></span>
                                        <span class="nk-menu-text">POS</span>
                                    </a>
                                </li><!-- .nk-menu-item -->
                                @endif

                                    @if($privilege->pos_view == 'Allow')
                                <li class="nk-menu-item">
                                    <a href="{{ route('hotel/promotion/view') }}" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-tranx"></em></span>
                                        <span class="nk-menu-text">Promotion</span>
                                    </a>
                                </li><!-- .nk-menu-item -->
                                @endif
                                @if($privilege->waste_view == 'Allow')
                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-trash-alt"></em></span>
                                        <span class="nk-menu-text">Waste</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        @if($privilege->waste_add == 'Allow')
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/waste/add') }}" class="nk-menu-link"><span class="nk-menu-text">Add waste</span></a>
                                        </li>
                                        @endif
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/waste/view') }}" class="nk-menu-link"><span class="nk-menu-text">View Waste</span></a>
                                        </li>
                                    </ul><!-- .nk-menu-sub -->
                                </li>
                                @endif

                                @if($privilege->maintenance_view == 'Allow')
                                    <li class="nk-menu-item has-sub">
                                        <a href="#" class="nk-menu-link nk-menu-toggle">
                                            <span class="nk-menu-icon"><em class="icon ni ni-setting-alt"></em></span>
                                            <span class="nk-menu-text">Maintenance</span>
                                        </a>
                                        <ul class="nk-menu-sub">
                                            @if($privilege->maintenance_add == 'Allow')
                                                <li class="nk-menu-item">
                                                    <a href="{{ route('hotel/repair/add') }}" class="nk-menu-link"><span class="nk-menu-text">Add Repair</span></a>
                                                </li>
                                            @endif
                                                <li class="nk-menu-item">
                                                    <a href="{{ route('hotel/repair/view') }}" class="nk-menu-link"><span class="nk-menu-text">View Repair</span></a>
                                                </li>
{{--                                                <li class="nk-menu-item">--}}
{{--                                                    <a href="{{ route('hotel/location/view') }}" class="nk-menu-link"><span class="nk-menu-text">View Location</span></a>--}}
{{--                                                </li>--}}
                                        </ul><!-- .nk-menu-sub -->
                                    </li>
                                @endif

                                @if($privilege->utility_view == 'Allow')
                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-bulb"></em></span>
                                        <span class="nk-menu-text">Utility</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        @if($privilege->utility_add == 'Allow')
                                            <li class="nk-menu-item">
                                                <a href="{{ route('hotel/utility/add') }}" class="nk-menu-link"><span class="nk-menu-text">Add Utility</span></a>
                                            </li>
                                        @endif
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/utility/view') }}" class="nk-menu-link"><span class="nk-menu-text">View Utility</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/utility/summery') }}" class="nk-menu-link"><span class="nk-menu-text">Utility Summery</span></a>
                                        </li>


                                        {{--                                        @endif--}}

                                        {{--                                                <li class="nk-menu-item">--}}
                                        {{--                                                    <a href="{{ route('hotel/location/view') }}" class="nk-menu-link"><span class="nk-menu-text">View Location</span></a>--}}
                                        {{--                                                </li>--}}
                                    </ul><!-- .nk-menu-sub -->
                                </li>
                                @endif


                                @if($privilege->housekeeping_view == 'Allow')
                                    <li class="nk-menu-item has-sub">
                                        <a href="#" class="nk-menu-link nk-menu-toggle">
                                            <span class="nk-menu-icon"><em class="icon ni ni-notes-alt"></em></span>
                                            <span class="nk-menu-text">Housekeeping</span>
                                        </a>
                                        <ul class="nk-menu-sub">
                                            @if($privilege->housekeeping_add == 'Allow')
                                                <li class="nk-menu-item">
                                                    <a href="{{ route('hotel/housekeeping/room_view') }}" class="nk-menu-link"><span class="nk-menu-text">New Check list</span></a>
                                                </li>
                                            @endif

                                                <li class="nk-menu-item">
                                                    <a href="{{ route('hotel/housekeeping/other_location_view') }}" class="nk-menu-link"><span class="nk-menu-text">Other Location</span></a>
                                                </li>

                                                <li class="nk-menu-item">
                                                    <a href="{{ route('hotel/housekeeping/view_checklist') }}" class="nk-menu-link"><span class="nk-menu-text">Check List History</span></a>
                                                </li>

                                        </ul><!-- .nk-menu-sub -->
                                    </li>
                                @endif

{{--                                @if($privilege->housekeeping_view == 'Allow')--}}

{{--                                @endif--}}


                                @if($privilege->reservation_view == 'Allow')

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
                                @endif

                                @if($privilege->invoice_view == 'Allow')
                                <li class="nk-menu-item">
                                    <a href="{{ route('hotel/hotel_invoice') }}" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-tranx"></em></span>
                                        <span class="nk-menu-text">Invoice</span>
                                    </a>
                                </li>
                                @endif


{{--                                @if($privilege->stock_view == 'Allow')--}}
{{--                                    <li class="nk-menu-item">--}}
{{--                                        <a href="{{ route('admin') }}" class="nk-menu-link">--}}
{{--                                            <span class="nk-menu-icon"><em class="icon ni ni-menu-circled"></em></span>--}}
{{--                                            <span class="nk-menu-text">Stock</span>--}}
{{--                                        </a>--}}
{{--                                    </li><!-- .nk-menu-item -->--}}
{{--                                @endif--}}
                                @if($privilege->stock_view == 'Allow')
                                    <li class="nk-menu-item has-sub">
                                        <a href="#" class="nk-menu-link nk-menu-toggle">
                                            <span class="nk-menu-icon"><em class="icon ni ni-menu-circled"></em></span>
                                            <span class="nk-menu-text">Stock</span>
                                        </a>
                                        @php($stock_category = \App\Item_category::where('hotel_id',auth()->user()->hotel_id)->where('status', 'active')->get())
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
                                @endif

{{--                                @if(auth()->user()->role == 'Admin' or $privilege->supplier_view == 'Allow')--}}
{{--                                <li class="nk-menu-item">--}}
{{--                                    <a href="{{ route('hotel/supplier') }}" class="nk-menu-link">--}}
{{--                                        <span class="nk-menu-icon"><em class="icon ni ni-cc-new"></em></span>--}}
{{--                                        <span class="nk-menu-text">Supplier</span>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                                @endif--}}

                            @if($privilege->past_view == 'Allow')
                                <li class="nk-menu-item">
                                    <a href="{{ route('hotel/invoice') }}" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-file-docs"></em></span>
                                        <span class="nk-menu-text">Past orders</span>
                                    </a>
                                </li><!-- .nk-menu-item -->
                                @endif
                                @if($privilege->kot_view == 'Allow')
                                <li class="nk-menu-item">
                                    <a href="{{ route('hotel/kot') }}" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-file-docs"></em></span>
                                        <span class="nk-menu-text">KOT</span>
                                    </a>
                                </li><!-- .nk-menu-item -->
                                @endif
                                @if($privilege->inventory_view == 'Allow')
                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-property-alt"></em></span>
                                        <span class="nk-menu-text">Inventory</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        @if($privilege->inventory_add == 'Allow')
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/inventory/add_main_categories') }}" class="nk-menu-link"><span class="nk-menu-text">Add Category</span></a>
                                        </li>
                                        @endif
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/inventory/view_inventory') }}" class="nk-menu-link"><span class="nk-menu-text">View Inventory</span></a>
                                        </li>
                                            @if($privilege->inventory_add == 'Allow')
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/inventory/add_inventory_item_bill_view') }}" class="nk-menu-link"><span class="nk-menu-text">Add Inventory Bills</span></a>
                                        </li>
                                            @endif
                                            @if($privilege->inventory_edit == 'Allow')
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/inventory/view_inventory_item_bill_list') }}" class="nk-menu-link"><span class="nk-menu-text">View Inventory Bills</span></a>
                                        </li>
                                            @endif
                                            @if($privilege->inventory_damage_view == 'Allow')
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/inventory/waste_management_view') }}" class="nk-menu-link"><span class="nk-menu-text">Inventory Damages</span></a>
                                        </li>
                                            @endif
                                    </ul><!-- .nk-menu-sub -->
                                </li><!-- .nk-menu-item -->

                                @endif
                                @if($privilege->cashbook_view == 'Allow')
                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-property-alt"></em></span>
                                        <span class="nk-menu-text">Cash Book</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        @if($privilege->cashbook_add == 'Allow')
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/cashbook/cashbook_setting') }}" class="nk-menu-link"><span class="nk-menu-text"> Cash Book Setting</span></a>
                                        </li>
                                        @endif
                                        @php($cash_books = \App\Assigned_cash_book::with('cashbook')->where('user_id',auth()->user()->id)->get())
                                        @foreach($cash_books as $cash_book)
                                            @if($cash_book->cashbook != null)
                                                <li class="nk-menu-item">
                                                    <a href="{{ route('hotel/cashbook/show_cash_book',$cash_book->cashbook->id) }}" class="nk-menu-link"><span class="nk-menu-text"> {{$cash_book->cashbook->name}}</span></a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul><!-- .nk-menu-sub -->
                                </li><!-- .nk-menu-item -->
                                @endif


                                @if($privilege->expenses_view == 'Allow')
                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-contact-fill"></em></span>
                                        <span class="nk-menu-text">Expenses</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        @if($privilege->expenses_add == 'Allow')
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/expenses/view') }}" class="nk-menu-link"><span class="nk-menu-text">Add Expenses</span></a>
                                        </li>
                                        @endif
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/expenses/view_expenses') }}" class="nk-menu-link"><span class="nk-menu-text">View Expenses</span></a>
                                        </li>
                                    </ul><!-- .nk-menu-sub -->
                                </li><!-- .nk-menu-item -->
                                @endif
                                @if($privilege->booking_view == 'Allow')
                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-calendar-booking-fill"></em></span>
                                        <span class="nk-menu-text">Bookings</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/booking/view_booking') }}" class="nk-menu-link"><span class="nk-menu-text">Booking List</span></a>
                                        </li>
                                        @if($privilege->booking_add == 'Allow')
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/booking/add_booking_view') }}" class="nk-menu-link"><span class="nk-menu-text">Add Booking</span></a>
                                        </li>
                                        @endif
                                        <li class="nk-menu-item">
                                            <a href="{{ route('hotel/booking/over_roll_booking') }}" class="nk-menu-link"><span class="nk-menu-text">Calender</span></a>
                                        </li>
                                    </ul>
                                </li><!-- .nk-menu-item -->
                                @endif
                                @if($privilege->recipe_view == 'Allow')
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
                                            @if($privilege->recipe_add == 'Allow')
                                                <li class="nk-menu-item">
                                                    <a href="{{ route('hotel/add_recipe') }}" class="nk-menu-link">
                                                        <span class="nk-menu-text">Add Recipe</span>
                                                    </a>
                                                </li>
                                            @endif
                                            <li class="nk-menu-item">
                                                <a href="{{ route('hotel/view_menu') }}" class="nk-menu-link">
                                                    <span class="nk-menu-text">View Menu</span>
                                                </a>
                                            </li>
                                            @if($privilege->recipe_add == 'Allow')
                                                <li class="nk-menu-item">
                                                    <a href="{{ route('hotel/add_menu') }}" class="nk-menu-link">
                                                        <span class="nk-menu-text">Add Menu</span>
                                                    </a>
                                                </li>
                                            @endif
                                        </ul><!-- .nk-menu-sub -->
                                    </li><!-- .nk-menu-item -->
                                @endif



                                @if($privilege->other_income_view == 'Allow')
                                    <li class="nk-menu-item has-sub">
                                        <a href="#" class="nk-menu-link nk-menu-toggle">
                                            <span class="nk-menu-icon"><em class="icon ni ni-notes-alt"></em></span>
                                            <span class="nk-menu-text">Other Income</span>
                                        </a>
                                        <ul class="nk-menu-sub">
                                            @if($privilege->other_income_add == 'Allow')
                                                <li class="nk-menu-item">
                                                    <a href="{{ route('hotel/other_income') }}" class="nk-menu-link"><span class="nk-menu-text">Other Income Add</span></a>
                                                </li>
                                            @endif

                                            <li class="nk-menu-item">
                                                <a href="{{ route('hotel/other_income/view_list') }}" class="nk-menu-link"><span class="nk-menu-text">Other Income View</span></a>
                                            </li>



                                        </ul><!-- .nk-menu-sub -->
                                    </li>
                                @endif



{{--                                @if($privilege->expenses_view == 'Allow')--}}
                                    <li class="nk-menu-item">
                                        <a href="{{ route('agency/agencyAndGuideInfo') }}" class="nk-menu-link">
                                            <span class="nk-menu-icon"><em class="icon ni ni-money"></em></span>
                                            <span class="nk-menu-text">Agency and Guide</span>
                                        </a>
                                    </li>
{{--                                @endif--}}

                                @if($privilege->resturant_view == 'Allow')
                                <li class="nk-menu-item">
                                    <a href="{{ route('hotel/resturant/view') }}" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-money"></em></span>

                                        <span class="nk-menu-text">Resturant</span>
                                    </a>
                                </li>
                                @endif









                                <!-- .nk-menu-item -->
{{--                                <li class="nk-menu-item">--}}
{{--                                    <a href="html/pricing-table.html" class="nk-menu-link">--}}
{{--                                        <span class="nk-menu-icon"><em class="icon ni ni-view-col"></em></span>--}}
{{--                                        <span class="nk-menu-text">Pricing Table</span>--}}
{{--                                    </a>--}}
{{--                                </li><!-- .nk-menu-item -->--}}
{{--                                <li class="nk-menu-item">--}}
{{--                                    <a href="html/gallery.html" class="nk-menu-link">--}}
{{--                                        <span class="nk-menu-icon"><em class="icon ni ni-img"></em></span>--}}
{{--                                        <span class="nk-menu-text">Image Gallery</span>--}}
{{--                                    </a>--}}
{{--                                </li><!-- .nk-menu-item -->--}}
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
                                                    <div class="user-status">{{ auth()->user()->role }}</div>
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
{{--                                                    <li><a href="html/user-profile-activity.html"><em class="icon ni ni-activity-alt"></em><span>Login Activity</span></a></li>--}}
                                                    <li><a class="dark-switch" href="#" onclick="dark_switch()"><em class="icon ni ni-moon"></em><span>Dark Mode</span></a></li>
                                                    <li><a href="" data-bs-toggle="modal" data-bs-target="#modalDefault"><em class="icon ni ni-activity-alt"></em><span>Switch Hotel</span></a></li>

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
                                        <a href="#" class="dropdown-toggle nk-quick-nav-icon" data-bs-toggle="">
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
                                            @php($hotels = \App\Privilege::with('hotel','hotel_chain')->where('user_id',auth()->user()->id)->get())
                                            <div class="modal-body">
                                                @foreach($hotels as $hotel)
                                                    <a href="{{ route('hotel/switch_hotels',['hotel_id'=>$hotel->hotel->id,'hotel_chain_id'=>$hotel->hotel_chain->id]) }}">
                                                        <div class="card-inner card-inner-md">
                                                            <div class="user-card">
                                                                <div class="user-avatar bg-primary-dim">
                                                                    <span>AB</span>
                                                                </div>
                                                                <div class="user-info">
                                                                    <span class="lead-text">{{$hotel->hotel->hotel_name}}</span>
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
                            <div class="nk-footer-copyright">  &copy; {{ date('Y') }}  <a href="https://ravantangalle.com" target="_blank">Ravan</a>
                            </div>
{{--                            <div class="nk-footer-links">--}}
{{--                                <ul class="nav nav-sm">--}}
{{--                                    <li class="nav-item dropup">--}}
{{--                                        <a href="#" class="dropdown-toggle dropdown-indicator has-indicator nav-link text-base" data-bs-toggle="dropdown" data-offset="0,10"><span>English</span></a>--}}
{{--                                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">--}}
{{--                                            <ul class="language-list">--}}
{{--                                                <li>--}}
{{--                                                    <a href="#" class="language-item">--}}
{{--                                                        <span class="language-name">English</span>--}}
{{--                                                    </a>--}}
{{--                                                </li>--}}
{{--                                                <li>--}}
{{--                                                    <a href="#" class="language-item">--}}
{{--                                                        <span class="language-name">Español</span>--}}
{{--                                                    </a>--}}
{{--                                                </li>--}}
{{--                                                <li>--}}
{{--                                                    <a href="#" class="language-item">--}}
{{--                                                        <span class="language-name">Français</span>--}}
{{--                                                    </a>--}}
{{--                                                </li>--}}
{{--                                                <li>--}}
{{--                                                    <a href="#" class="language-item">--}}
{{--                                                        <span class="language-name">Türkçe</span>--}}
{{--                                                    </a>--}}
{{--                                                </li>--}}
{{--                                            </ul>--}}
{{--                                        </div>--}}
{{--                                    </li>--}}
{{--                                    <li class="nav-item">--}}
{{--                                        <a data-bs-toggle="modal" href="#region" class="nav-link"><em class="icon ni ni-globe"></em><span class="ms-1">Select Region</span></a>--}}
{{--                                    </li>--}}
{{--                                </ul>--}}
{{--                            </div>--}}
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

    <!-- JavaScript -->
    <script type="text/javascript">
        window.history.forward();
        function noBack()
        {
            // window.history.forward();
        }
        // https://www.webintoapp.com/store/82545
    </script>
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
