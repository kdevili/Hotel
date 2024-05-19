@extends('User.lay')

@section('title' , __(''))

@section('style')

@endsection

@section('content')


    <div class="nk-block nk-block-middle nk-auth-body  wide-xs">

        <div class="card card-bordered">
            <div class="card-inner card-inner-lg">
                <div class="nk-block-head">
                    <div class="nk-block-head-content">
                        <ul class="row p-1">
                        <button id="order" class="btn btn-round btn-md btn-primary center mb-1 mt-2">MENU</button>
                        <button id="cartButton" class="btn btn-round btn-md btn-outline-primary center mb-1 mt-2" >CART</button>
                        <button id="ongoingOrders" class="btn btn-round btn-md btn-success center mb-1 mt-2">ONGOING ORDERS</button>
                        </ul>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-4">
                        <img class="img" src="{{ asset('images/ravanlogo.jpg') }}"  alt="logo">
                    </div>
                </div>
                <br>

                <div class="row">

                    <div class="col-12 text-center">
                        <h6 class="nk-block-title text-center" style="color: #b78600;">Deluxe room wifi Passcode</h6>
                        <img class="img w-50" src="{{ asset('images/Ravan Delux.png') }}"  alt="logo">
                        <p class="pb-0 text-black">Wifi Network : Ravan Deluxe <br> Password : ravan@2023ul1</p>
                    </div>
                    {{--                    @endif--}}

                </div>

            </div>
        </div>
    </div>




    <div class="modal fade" tabindex="-1" id="show-menu-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title">MENU</h5>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                <div class="nk-block nk-block-lg">
                                    <div class="col-lg-5" style="padding: 3px;">
                                        <div class="nk-ibx">
                                            <div class="nk-ibx-aside toggle-screen-lg" data-content="inbox-aside" data-toggle-overlay="true" data-toggle-screen="lg">
                                                <div class="nk-ibx-head">
                                                    <a href="#" class="nk-ibx-menu-item"><span class="nk-ibx-menu-text">All</span></a>
                                                </div>
                                                <div class="nk-ibx-nav" data-simplebar="init">
                                                    <div class="simplebar-wrapper" style="margin: 0px;">
                                                        <div class="simplebar-height-auto-observer-wrapper">
                                                            <div class="simplebar-height-auto-observer"></div>
                                                        </div>
                                                        <div class="simplebar-mask">
                                                            <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                                                <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: 100%; overflow: hidden scroll;">
                                                                    <div class="simplebar-content" style="padding: 0px;">
                                                                        <ul class="nk-ibx-menu">
                                                                            @php($categories = \App\Recipe_category::where('hotel_id','1')->get())
                                                                            @foreach($categories as $category)
                                                                                <li class="category_filter_list_li"><a class="nk-ibx-menu-item category_filter_list" onclick="view_menu('{{$category->id}}')" href="#" data-category="{{$category->id}}" id="categoryx-{{$category->id}}"><span class="nk-ibx-menu-text">{{$category->category_name}}</span></a></li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="simplebar-placeholder" style="width: auto; height: 899px;"></div>
                                                </div>
                                                <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                                    <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                                                </div>
                                                <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                                                    <div class="simplebar-scrollbar" style="height: 514px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
                                                </div>
                                            </div>
                                            <div class="nk-ibx-body bg-white">
                                                <div class="nk-ibx-head">
                                                    <div class="search-wrap active" data-search="search">
                                                        <div class="search-content">
                                                            <input type="text" class="form-control border-transparent form-focus-none" id="search-input" placeholder="Search by name">
                                                            <button class="search-submit btn btn-icon"><em class="icon ni ni-search"></em></button>
                                                        </div>
                                                    </div><!-- .search-wrap -->
                                                </div><!-- .nk-ibx-head -->
                                                <div class="nk-ibx-list" data-simplebar="init">
                                                    <div class="simplebar-wrapper" style="margin: 0px;">
                                                        <div class="simplebar-height-auto-observer-wrapper">
                                                            <div class="simplebar-height-auto-observer"></div>
                                                        </div>
                                                        <div class="simplebar-mask">
                                                            <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                                                <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: 100%; overflow: hidden scroll;">
                                                                    <div class="simplebar-content" style="padding: 0px;">
                                                                        <div class="nk-ibx-item is-unread" style="cursor: auto">
                                                                            <div class="row w-100" id="menuContainer">
                                                                                @php($items = \App\Menu::where('hotel_id', '1')->where('type', 'Visible')->whereIn('id', \App\Restaurant_menu::select('menu_id')->where('restaurant_id', '1')->get()->pluck('menu_id'))->get())
                                                                                @foreach($items as $menu)
                                                                                    <div class="col-4 col-sm-4 col-md-4 col-lg-4 menu_item_list_pos menu-item" style="padding: 5px;" data-item_name="{{$menu->item_code}} {{$menu->name}}" data-menu-id="{{$menu->id}}">
                                                                                        <div class="card card-bordered" onclick="try_add_to_cart({{$menu->id}},'new')">
                                                                                            <div class="squar">
                                                                                                <img src="{{ asset('storage/') }}/{{$menu->image}}" class="card-img-top" alt="" style="width: 100%;">
                                                                                            </div>
                                                                                            <div class="card-inner" style="padding: 15px 5px;">
                                                                                                <h6 class="small text-center"><b>{{$menu->item_code}}</b> {{$menu->name}}</h6>
                                                                                                <h6 class="small card-title text-center">Rs.{{$menu->price}}</h6>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="simplebar-placeholder" style="width: auto; height: 1167px;">
                                                        </div>
                                                    </div>
                                                    <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                                        <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                                                    </div>
                                                    <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                                                        <div class="simplebar-scrollbar" style="height: 397px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
                                                    </div>
                                                </div><!-- .nk-ibx-list -->
                                            </div><!-- .nk-ibx-body -->
                                        </div>
                                    </div>
                                </div><!-- .nk-block -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="view-cart-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title">CART</h5>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                <div class="nk-block nk-block-lg">
                                    <div class="card-inner p-2 cart-div">
                                        <div class="nk-tb-list">
                                            <div class="nk-tb-item nk-tb-head">
                                                <div class="nk-tb-col nk-tb-col-check tb-col-md">
                                                    <div class="custom-control custom-control-sm custom-checkbox notext">
                                                        <input type="checkbox" class="custom-control-input" id="pid" disabled>
                                                        <label class="custom-control-label" for="pid"></label>
                                                    </div>
                                                </div>
                                                <div class="nk-tb-col"><span>Item</span></div>
                                                <div class="nk-tb-col tb-col-sm"><span>Price</span></div>
                                                <div class="nk-tb-col"><span>Qty</span></div>
                                                <div class="nk-tb-col tb-col-md"><span>Discount</span></div>
                                                <div class="nk-tb-col"><span>Total</span></div>
                                                <div class="nk-tb-col"><em class="tb-asterisk icon ni ni-star-round"></em></div>
                                            </div><!-- .nk-tb-item -->

                                            {{--                                                <div class="nk-tb-item" id="cart-item-1">--}}
                                            {{--                                                    <div class="nk-tb-col nk-tb-col-check">--}}
                                            {{--                                                        <div class="custom-control custom-control-sm custom-checkbox notext">--}}
                                            {{--                                                            <input type="checkbox" class="custom-control-input" id="pid1">--}}
                                            {{--                                                            <label class="custom-control-label" for="pid1"></label>--}}
                                            {{--                                                        </div>--}}
                                            {{--                                                    </div>--}}
                                            {{--                                                    <div class="nk-tb-col tb-col-sm">--}}
                                            {{--                                                            <span class="tb-product">--}}
                                            {{--                                                                <span class="title" id="cart-item-title-1">Pink Fitness Tracker</span>--}}
                                            {{--                                                            </span>--}}
                                            {{--                                                    </div>--}}
                                            {{--                                                    <div class="nk-tb-col">--}}
                                            {{--                                                        <span class="tb-lead" id="cart-item-price-1">$99.49</span>--}}
                                            {{--                                                    </div>--}}
                                            {{--                                                    <div class="nk-tb-col">--}}
                                            {{--                                                        <span class="tb-sub">--}}
                                            {{--                                                            <div style="width: 116px;">--}}
                                            {{--                                                            <div class="form-group">--}}
                                            {{--                                                            <div class="form-control-wrap number-spinner-wrap">--}}
                                            {{--                                                                <button class="btn btn-icon btn-outline-light number-spinner-btn number-minus" data-number="minus"><em class="icon ni ni-minus"></em></button>--}}
                                            {{--                                                                <input type="number" class="form-control number-spinner" placeholder="number" value="1" min="1" max="30">--}}
                                            {{--                                                                <button class="btn btn-icon btn-outline-light number-spinner-btn number-plus" data-number="plus"><em class="icon ni ni-plus"></em></button>--}}
                                            {{--                                                            </div>--}}
                                            {{--                                                            </div>--}}
                                            {{--                                                        </div>--}}
                                            {{--                                                        </span>--}}
                                            {{--                                                    </div>--}}
                                            {{--                                                    <div class="nk-tb-col tb-col-md">--}}
                                            {{--                                                        <span class="tb-sub" id="cart-item-descount-1">0</span>--}}
                                            {{--                                                    </div>--}}
                                            {{--                                                    <div class="nk-tb-col">--}}
                                            {{--                                                        <span class="tb-lead" id="cart-item-totle-1">$ 99.49</span>--}}
                                            {{--                                                    </div>--}}
                                            {{--                                                    <div class="nk-tb-col tb-col-md">--}}
                                            {{--                                                        <div class="asterisk tb-asterisk">--}}
                                            {{--                                                            <a href="#" id="cart-item-remove-1"><em class="text-danger icon ni ni-trash"></em></a>--}}
                                            {{--                                                        </div>--}}
                                            {{--                                                    </div>--}}

                                            {{--                                                </div><!-- .nk-tb-item -->--}}

                                        </div><!-- .nk-tb-list -->
                                    </div>
                                    <div class="card-inner pb-0 b-summery" style="bottom: 0px;width: 100%">

                                        <div class="aside-wg">
                                            {{--                                                <h6 class="overline-title-alt mb-2">Additional</h6>--}}
                                            <div class="row gx-1 gy-3">
                                                <div class="col-4 mt-0">
                                                    <span class="sub-text">Total Item: <span id="total-item">0</span></span>
                                                </div>
                                                <div class="col-4 mt-0">
                                                    <span class="sub-text">Sub total: <span id="subtotal-amount">Rs.0.00</span></span>
                                                </div>
                                                <div class="col-4 mt-0">
                                                    <div class="custom-control custom-control-sm custom-checkbox checked">
                                                        <input type="checkbox" class="custom-control-input" id="service-charge-check" checked>
                                                        <label class="custom-control-label" for="service-charge-check">Service Charge: <span id="service-charge">Rs.0.00 </span></label>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                            <div class="border-bottom border-top pricing-amount text-center">
                                                <div class="amount">Total Payable:  <span id="total-amount">0.00</span></div>
                                            </div>
                                            <ul class="row p-1 justify-content-around">
                                                <li class="col-3 col-sm-3 col-lg-3">
                                                    <button id="place-order-btn" class="btn btn-round btn-sm btn-primary">Place Order</button>
                                                </li>
                                            </ul>
                                        </div>

                                    </div>
                                </div><!-- .nk-block -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <div class="modal fade" tabindex="-1"  id="view-ongoingOrders-modal">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title">ONGOING ORDER</h5>
                </div>
                <div class="modal-body">

                    <div id="runnig-orders">

                    </div>

                </div>
                <div class="modal-footer bg-light">
                    <div class="form-group">
                        <button type="button" class="btn btn-danger btn-lg" data-bs-dismiss="modal">Close</button>
                        {{--                        <button type="button" onclick="order_cancel()" class="btn btn-lg btn-primary" id="order-cancel-btn">Submit</button>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1"  id="finalize-order-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title">Finalize Bill</h5>
                </div>
                <div class="modal-body">
                    <form action="#" method="post" id="finalize-order-form" enctype="multipart/form-data" onsubmit="event.preventDefault();">
                        @csrf
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <h6 id="f-total-payable">Total payable : Rs.25137.00</h6>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label pull-right" id="f-order-id">Order ID : #1045 </label>
                                </div>
                            </div>

                            {{--                            <div class="col-lg-12">--}}
                            {{--                                <div class="form-group">--}}
                            {{--                                    <label class="form-label">Paid Amount</label>--}}
                            {{--                                    <div class="form-control-wrap">--}}
                            <input type="hidden" class="form-control" name="" id="f-paid-amount">
                            {{--                                    </div>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="full-name-1">Given Amount</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="f-give-amount" name="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="email-address-1">Change Amount</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" name="" id="f-change-amount" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">Date</label>
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-left">
                                            <em class="icon ni ni-calendar"></em>
                                        </div>
                                        <input type="text" class="form-control date-picker" data-date-format="yyyy-mm-dd" name="date" required value="{{date('Y-m-d')}}" id="f-order-date">
                                    </div>
                                    {{--<div class="form-note">Date format<code>yyyy-mm-dd</code></div>--}}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="payment_method">Payment method</label>
                                    <div class="form-control-wrap">
                                        <select class="form-select"  name="payment_method" id="f-payment_method">
                                            <option value="Cash">Cash</option>
                                            <option value="Card">Card</option>
                                            <option value="Pre-paid">Pre-paid</option>
                                            <option value="Free">Free</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="customer_email">Customer Email Address</label>
                                    <div class="form-control-wrap">
                                        <input type="email" class="form-control" id="customer_email" name="customer_email">
                                    </div>
                                </div>
                            </div>
                        </div>


                    </form>
                </div>
                <div class="modal-footer bg-light">
                    <div class="form-group">
                        <button type="button" class="btn btn-danger btn-lg" data-bs-dismiss="modal">Close</button>
                        <button type="button" onclick="order_complete()" class="btn btn-lg btn-primary" id="order-complete-btn">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1"  id="cancel-order-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title">Cancel Order</h5>
                </div>
                <div class="modal-body">
                    <form action="#" method="post" id="cancel-order-form" enctype="multipart/form-data" onsubmit="event.preventDefault();">
                        @csrf
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <h6>Are you sure?</h6>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label pull-right" id="c-order-id">Order ID : #1045 </label>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label" for="full-name-1">Reason</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="c-reason" name="">
                                    </div>
                                </div>
                            </div>

                        </div>


                    </form>
                </div>
                <div class="modal-footer bg-light">
                    <div class="form-group">
                        <button type="button" class="btn btn-danger btn-lg" data-bs-dismiss="modal">Close</button>
                        <button type="button" onclick="order_cancel()" class="btn btn-lg btn-primary" id="order-cancel-btn">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1"  id="add-to-cart-model">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title" id="add-to-cart-model-title">Select Options</h5>
                </div>
                <div class="modal-body" id="add-to-cart-model-body">
                    <form action="#" method="post" id="cancel-order-form" enctype="multipart/form-data" onsubmit="event.preventDefault();">
                        @csrf
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <h6>Are you sure?</h6>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label pull-right" id="c-order-id">Order ID : #1045 </label>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label" for="full-name-1">Reason</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="c-reason" name="">
                                    </div>
                                </div>
                            </div>

                        </div>


                    </form>
                </div>
                <div class="modal-footer bg-light">
                    <div class="form-group">
                        <button type="button" class="btn btn-danger btn-lg" data-bs-dismiss="modal">Close</button>
                        <button type="button" onclick="add_to_cart2()" class="btn btn-lg btn-primary" id="order-cancel-btn">Add to cart</button>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
@section('script')

    <script>

        document.addEventListener('DOMContentLoaded', function () {
            // Get a reference to the button
            const clearButton = document.getElementById('table_button');

            // Add a click event listener to the button
            clearButton.addEventListener('click', function () {
                // Select all radio buttons with the class 'select-table-radio' and uncheck them
                const radioButtons = document.querySelectorAll('.select-table-radio');
                radioButtons.forEach(function (radio) {
                    radio.checked = false;
                });
            });
        });

        function toggleOrderDetails(tableId) {
            console.log(tableId);
            var table_order = $('#table_div-'+tableId).html();
            console.log($('#table_div-'+tableId).innerHTML);
            $('#tble_details').html(table_order);
        }



        $(document).ready(function () {
            $('#order_type').on('change', function () {
                var selectedOption = $(this).val();
                if (selectedOption === 'Dine In') {
                    $('#view-table-model').removeClass('hidden'); // Remove the "hidden" class
                    $('#view-table-model').modal('show');
                }
            });

            $('#view-table-model').on('hidden.bs.modal', function () {
                // When the modal is hidden, add back the "hidden" class
                $(this).addClass('hidden');
            });
        });

        $(document).ready(function () {


            $('.select-table-radio').on('change', function () {
                var tableName = $(this).data('table-name');
                var tableId = $(this).data('table-id');

                if ($(this).is(':checked')) {
                    global_row_list['order_table'] = tableId;

                } else {
                    global_row_list['order_table'] = null;
                }
            });



            $('#view-table-model').on('hidden.bs.modal', function () {
                // Reset the selected tables when the modal is closed
                selectedTables = [];
            });
        });




        let global_row_id = 0;
        let global_row_list = {};

        global_row_list['total'] = 0.00;
        global_row_list['item_count'] = 0;
        global_row_list['cart-items'] = [];
        global_row_list['order_id'] = 'new';
        global_row_list['order_table'] = null;


        let global_combo_selection = {};
        // global_combo_selection['recipe_list_with_qty'] = [];

        function add_to_cart(resipe_id,name,price,qty,total,db_row_id,order_menus) {
            let row_id = global_row_id+1;
            let aaa = "cart-item-"+row_id;

            let row_list = {
                "row_id": db_row_id,
                "resipe_id": resipe_id,
                "name": name,
                "price": price,
                "total": total,
                "qty": qty,
                "discount": 0,
                "quantity": qty,
                "order_menus": order_menus,
            }

            global_row_list[aaa] = row_list;
            global_row_list['cart-items'].push(aaa);
            global_row_list['total'] = global_row_list['total']+parseFloat(total);
            global_row_list['item_count'] += qty;

            console.log(global_row_list);
            let cart_row ='<div class="nk-tb-item" id="cart-item-'+row_id+'">\n' +
                '                                                    <div class="nk-tb-col nk-tb-col-check tb-col-md">\n' +
                '                                                        <div class="custom-control custom-control-sm custom-checkbox notext">\n' +
                '                                                            <input type="checkbox" class="custom-control-input" id="pid1" disabled>\n' +
                '                                                            <label class="custom-control-label" for="pid1"></label>\n' +
                '                                                        </div>\n' +
                '                                                    </div>\n' +
                '                                                    <div class="nk-tb-col">\n' +
                '                                                            <span class="tb-product">\n' +
                '                                                                <span class="title" id="cart-item-title-'+row_id+'">'+name+'</span>\n' +
                '                                                            </span>\n' +
                '                                                    </div>\n' +
                '                                                    <div class="nk-tb-col tb-col-sm">\n' +
                '                                                        <span class="tb-lead" id="cart-item-price-'+row_id+'">Rs.'+price+'</span>\n' +
                '                                                    </div>\n' +
                '                                                    <div class="nk-tb-col">\n' +
                '                                                        <span class="tb-sub">\n' +
                '                                                            <div style="width: 116px;">\n' +
                '                                                            <div class="form-group">\n' +
                '                                                            <div class="form-control-wrap number-spinner-wrap">\n' +
                '                                                                <button class="btn btn-icon btn-outline-light number-spinner-btn number-minus" data-number="minus" id="qty-minus-'+row_id+'"><em class="icon ni ni-minus"></em></button>\n' +
                '                                                                <input type="number" class="form-control number-spinner" placeholder="number" value="'+qty+'" min="1"  id="qty-val-'+row_id+'">\n' +
                '                                                                <button class="btn btn-icon btn-outline-light number-spinner-btn number-plus" data-number="plus" id="qty-plus-'+row_id+'"><em class="icon ni ni-plus"></em></button>\n' +
                '                                                            </div>\n' +
                '                                                            </div>\n' +
                '                                                        </div>\n' +
                '                                                        </span>\n' +
                '                                                    </div>\n' +
                '                                                    <div class="nk-tb-col tb-col-md">\n' +
                '                                                        <span class="tb-sub" id="cart-item-descount-'+row_id+'">0</span>\n' +
                '                                                    </div>\n' +
                '                                                    <div class="nk-tb-col">\n' +
                '                                                        <span class="tb-lead" id="cart-item-totle-'+row_id+'">Rs.'+total+'</span>\n' +
                '                                                    </div>\n' +
                '                                                    <div class="nk-tb-col">\n' +
                '                                                        <div class="asterisk tb-asterisk">\n' +
                '                                                            <a href="#" onclick="remove_from_cart('+resipe_id+','+row_id+')" id="cart-item-remove-'+row_id+'"><em class="text-danger icon ni ni-trash"></em></a>\n' +
                '                                                        </div>\n' +
                '                                                    </div>\n' +
                '\n' +
                '                                                </div><!-- .nk-tb-item -->';


            $('.nk-tb-list').append(cart_row);

            global_row_id++;
            cart_sync();

            $('#qty-plus-'+row_id).bind('click', function() {
                let aaa = "cart-item-"+row_id;
                var value = !$('#qty-val-'+row_id).val() == "" ? parseInt($('#qty-val-'+row_id).val()) : 0;
                var step = !$('#qty-val-'+row_id).attr('step') === "" ? parseInt($('#qty-val-'+row_id).attr('step')) : 1;
                var max = !$('#qty-val-'+row_id).attr('max') == "" ? parseInt($('#qty-val-'+row_id).attr('max')) : Infinity;

                if (max + 1 > value + step) {
                    var qty = value + step;
                    $('#qty-val-'+row_id).val(qty);
                    global_row_list[aaa].qty = qty;
                    global_row_list[aaa].total = global_row_list[aaa].price*qty;
                    $('#cart-item-totle-'+row_id).html('Rs.'+global_row_list[aaa].total);
                    global_row_list['total'] = global_row_list['total']+(global_row_list[aaa].price*step);
                    global_row_list['item_count'] += 1;
                } else {
                    $('#qty-val-'+row_id).val(value);
                }
                cart_sync();
            });
            $('#qty-minus-'+row_id).bind('click', function() {
                let aaa = "cart-item-"+row_id;
                var value = !$('#qty-val-'+row_id).val() == "" ? parseInt($('#qty-val-'+row_id).val()) : 0;
                var step = !$('#qty-val-'+row_id).attr('step') === "" ? parseInt($('#qty-val-'+row_id).attr('step')) : 1;
                var min = !$('#qty-val-'+row_id).attr('min') == "" ? parseInt($('#qty-val-'+row_id).attr('min')) : 0;

                if (min - 1 < value - step) {
                    var qty = value - step;
                    $('#qty-val-'+row_id).val(qty);
                    global_row_list[aaa].qty = qty;
                    global_row_list[aaa].total = global_row_list[aaa].price*qty;
                    $('#cart-item-totle-'+row_id).html('Rs.'+global_row_list[aaa].total);
                    global_row_list['total'] = global_row_list['total']-(global_row_list[aaa].price*step);
                    global_row_list['item_count'] -= 1;
                } else {
                    $('#qty-val-'+row_id).val(value);
                    remove_from_cart(resipe_id,row_id)
                }
                cart_sync();
            });
        }
        function add_to_cart3(resipe_id,name,price,qty,total,db_row_id,order_menus) {
            let row_id = global_row_id+1;
            let aaa = "cart-item-"+row_id;

            let row_list = {
                "row_id": db_row_id,
                "resipe_id": resipe_id,
                "name": name,
                "price": price,
                "total": total,
                "qty": qty,
                "discount": 0,
                "quantity": qty,
                "order_menus": order_menus,
            }

            global_row_list[aaa] = row_list;
            global_row_list['cart-items'].push(aaa);
            global_row_list['total'] = global_row_list['total']+parseFloat(total);
            global_row_list['item_count'] += qty;

            console.log(global_row_list);
            let cart_row ='<div class="nk-tb-item" id="cart-item-'+row_id+'">\n' +
                '                                                    <div class="nk-tb-col nk-tb-col-check tb-col-md">\n' +
                '                                                        <div class="custom-control custom-control-sm custom-checkbox notext">\n' +
                '                                                            <input type="checkbox" class="custom-control-input" id="pid1" disabled>\n' +
                '                                                            <label class="custom-control-label" for="pid1"></label>\n' +
                '                                                        </div>\n' +
                '                                                    </div>\n' +
                '                                                    <div class="nk-tb-col">\n' +
                '                                                            <span class="tb-product">\n' +
                '                                                                <span class="title" id="cart-item-title-'+row_id+'">'+name+'</span>\n' +
                '                                                            </span>\n' +
                '                                                    </div>\n' +
                '                                                    <div class="nk-tb-col tb-col-sm">\n' +
                '                                                        <span class="tb-lead" id="cart-item-price-'+row_id+'">Rs.'+price+'</span>\n' +
                '                                                    </div>\n' +
                '                                                    <div class="nk-tb-col">\n' +
                '                                                        <span class="tb-sub">\n' +
                '                                                            <div style="width: 116px;">\n' +
                '                                                            <div class="form-group">\n' +
                '                                                            <div class="form-control-wrap number-spinner-wrap">\n' +
                '                                                                <button class="btn btn-icon btn-outline-light number-spinner-btn number-minus" data-number="minus" id="qty-minus-'+row_id+'" disabled><em class="icon ni ni-minus"></em></button>\n' +
                '                                                                <input type="number" class="form-control number-spinner" placeholder="number" value="'+qty+'" min="1"  id="qty-val-'+row_id+'" readonly>\n' +
                '                                                                <button class="btn btn-icon btn-outline-light number-spinner-btn number-plus" data-number="plus" id="qty-plus-'+row_id+' disabled"><em class="icon ni ni-plus"></em></button>\n' +
                '                                                            </div>\n' +
                '                                                            </div>\n' +
                '                                                        </div>\n' +
                '                                                        </span>\n' +
                '                                                    </div>\n' +
                '                                                    <div class="nk-tb-col tb-col-md">\n' +
                '                                                        <span class="tb-sub" id="cart-item-descount-'+row_id+'">0</span>\n' +
                '                                                    </div>\n' +
                '                                                    <div class="nk-tb-col">\n' +
                '                                                        <span class="tb-lead" id="cart-item-totle-'+row_id+'">Rs.'+total+'</span>\n' +
                '                                                    </div>\n' +
                '                                                    <div class="nk-tb-col">\n' +
                '                                                        <div class="asterisk tb-asterisk">\n' +
                '                                                            <a href="#" id="cart-item-remove-'+row_id+'"><em class="text-success icon ni ni-coffee"></em></a>\n' +
                '                                                        </div>\n' +
                '                                                    </div>\n' +
                '\n' +
                '                                                </div><!-- .nk-tb-item -->';


            $('.nk-tb-list').append(cart_row);

            global_row_id++;
            cart_sync();

            $('#qty-plus-'+row_id).bind('click', function() {
                let aaa = "cart-item-"+row_id;
                var value = !$('#qty-val-'+row_id).val() == "" ? parseInt($('#qty-val-'+row_id).val()) : 0;
                var step = !$('#qty-val-'+row_id).attr('step') === "" ? parseInt($('#qty-val-'+row_id).attr('step')) : 1;
                var max = !$('#qty-val-'+row_id).attr('max') == "" ? parseInt($('#qty-val-'+row_id).attr('max')) : Infinity;

                if (max + 1 > value + step) {
                    var qty = value + step;
                    $('#qty-val-'+row_id).val(qty);
                    global_row_list[aaa].qty = qty;
                    global_row_list[aaa].total = global_row_list[aaa].price*qty;
                    $('#cart-item-totle-'+row_id).html('Rs.'+global_row_list[aaa].total);
                    global_row_list['total'] = global_row_list['total']+(global_row_list[aaa].price*step);
                    global_row_list['item_count'] += 1;
                } else {
                    $('#qty-val-'+row_id).val(value);
                }
                cart_sync();
            });
            $('#qty-minus-'+row_id).bind('click', function() {
                let aaa = "cart-item-"+row_id;
                var value = !$('#qty-val-'+row_id).val() == "" ? parseInt($('#qty-val-'+row_id).val()) : 0;
                var step = !$('#qty-val-'+row_id).attr('step') === "" ? parseInt($('#qty-val-'+row_id).attr('step')) : 1;
                var min = !$('#qty-val-'+row_id).attr('min') == "" ? parseInt($('#qty-val-'+row_id).attr('min')) : 0;

                if (min - 1 < value - step) {
                    var qty = value - step;
                    $('#qty-val-'+row_id).val(qty);
                    global_row_list[aaa].qty = qty;
                    global_row_list[aaa].total = global_row_list[aaa].price*qty;
                    $('#cart-item-totle-'+row_id).html('Rs.'+global_row_list[aaa].total);
                    global_row_list['total'] = global_row_list['total']-(global_row_list[aaa].price*step);
                    global_row_list['item_count'] -= 1;
                } else {
                    $('#qty-val-'+row_id).val(value);
                    remove_from_cart(resipe_id,row_id)
                }
                cart_sync();
            });
        }

        function remove_from_cart(resipe_id,row_id,aaa_name ='') {
            let aaa;
            if(aaa_name == ''){
                $('#cart-item-'+row_id).remove();
                aaa = "cart-item-"+row_id;
            }else{
                $('#'+aaa_name).remove();
                aaa = aaa_name;
            }


            global_row_list['item_count'] -= global_row_list[aaa].qty;
            global_row_list['total'] = global_row_list['total']-global_row_list[aaa].total;
            delete global_row_list[aaa];

            global_row_list['cart-items'] = global_row_list['cart-items'].filter(item => item !== aaa)
            cart_sync();

        }
        function cart_sync() {
            $('#subtotal-amount').html('Rs.'+global_row_list['total']);
            $('#total-item').html(global_row_list['item_count']);
            var serchg = global_row_list['total']*0.1;
            $('#service-charge').html('Rs.'+serchg);

            if ($('#service-charge-check').prop('checked')==true){
                $('#total-amount').html('Rs.'+(global_row_list['total']+serchg));
            }else{
                $('#total-amount').html('Rs.'+global_row_list['total']);
            }
        }
        $('#service-charge-check').change(function() {
            if ($('#service-charge-check').prop('checked')==true){
                var serchg = global_row_list['total']*0.1;
                $('#total-amount').html('Rs.'+(global_row_list['total']+serchg));
            }else{
                $('#total-amount').html('Rs.'+global_row_list['total']);
            }
        });

        $('#f-give-amount').on('keyup', function() {
            // $('#f-give-amount').val(global_row_list['total']).focus();
            // $('#f-change-amount').val('0.00');

            let this_value = $.trim($(this).val());
            if (isNaN(this_value)) {
                $(this).val("");
            }
            //get the value of the delivery charge amount
            let given_amount = $(this).val() != "" ? $(this).val() : 0;

            //check wether value is valid or not
            remove_last_two_digit_without_percentage(given_amount, $(this));

            given_amount = $(this).val() != "" ? $(this).val() : 0;
            let total_payable = $('#f-paid-amount').val();
            let total_change = (
                parseFloat(given_amount) - parseFloat(total_payable)
            ).toFixed(2);
            $("#f-change-amount").val(total_change);
        });
        //remove last digits if number is more than 2 digits after decimal
        function remove_last_two_digit_without_percentage(value, object_element) {
            if (value.length > 0 && value.indexOf(".") > 0) {
                let percentage = false;
                let number_without_percentage = value;
                if (value.indexOf("%") > 0) {
                    percentage = true;
                    number_without_percentage = value
                        .toString()
                        .substring(0, value.length - 1);
                }
                let number = number_without_percentage.split(".");
                if (number[1].length > 2) {
                    let value = parseFloat(Math.floor(number_without_percentage * 100) / 100);
                    let add_percentage = percentage ? "%" : "";
                    if (isNaN(value)) {
                        object_element.val("");
                    } else {
                        object_element.val(value.toString() + add_percentage);
                    }
                }
            }
        }
        function order_open(id) {
            $.ajax({
                type:'POST',
                url:'{{ route('user/resturent/open_order') }}',
                headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                data: {
                    'order_id' : id,
                },
                success:function(data){
                    NioApp.Toast('Bill Open Successfully', 'success',{position: 'top-right'});

                    cart_remove_all();
                    $('#place-order-btn').html('Update order');
                    $('#order-card-title').html('Order ID : #'+data.order_list.id);
                    if (data.order_list.service_charge > 0){
                        $('#service-charge-check').prop('checked',true);
                    }else{
                        $('#service-charge-check').prop('checked',false);
                    }

                    $('#order_type').val(data.order_list.type).change();

                    if (data.order_list.table_id != null){
                        var tableElement = document.querySelector('#table_div-' + data.order_list.table_id);
                        var tableRadioButton = document.querySelector('#table_' + data.order_list.table_id);

                        if (tableElement) {
                            tableElement.click();
                        }

                        if (tableRadioButton) {
                            tableRadioButton.checked = true;
                        }

                    }
                    else{

                    }


                    if (data.order_list.steward_id != null){
                        $('#steward').val(data.order_list.steward_id).change();
                    }
                    else{
                        $('#steward').val(data.order_list.steward_id).change();
                    }



                    global_row_list['order_id'] = data.order_list.id;
                    $.each(data.order_list.order_list_detail, function (key, val) {
                        let order_menus = JSON.parse(val.como_items_list);
                        add_to_cart3(val.recipe_note_id,val.recipe_name,val.price,val.quantity,val.total,val.id,order_menus);
                    });
                }

            });
        }

        function cart_remove_all(){
            global_row_list['order_id'] = 'new';
            $('#order-card-title').html('Ready for new order...');
            $('#place-order-btn').html('Place order');
            $('#quick-pay-btn').html('Quick pay');
            $('#service-charge-check').prop('checked',true);
            $.each(global_row_list['cart-items'], function (key, val) {
                remove_from_cart('','',val)
            });
        }

        $('#quick-pay-btn').on('click', function() {
            if(global_row_list['item_count'] > 0){
                if ($('#service-charge-check').prop('checked')==true){
                    var serchg = global_row_list['total']*0.1;
                }else{
                    var serchg = 0.00;
                }
                $('#f-paid-amount').val((global_row_list['total']+serchg));
                $('#f-order-id').html(global_row_list['order_id'] != 'new' ? 'Order ID : #'+global_row_list['order_id'] : 'Quick Pay');
                $('#f-total-payable').html('Total payable : Rs.'+(global_row_list['total']+serchg));
                $('#f-give-amount').val(global_row_list['total']+serchg).focus();
                $('#f-change-amount').val('0.00');
                $('#finalize-order-modal').modal('show');
            }else{
                NioApp.Toast('Cart is empty!', 'error',{position: 'bottom-right'});
            }
        });


        function sync_order(status){
            if ($('#service-charge-check').prop('checked')==true){
                var serchg = global_row_list['total']*0.1;
            }else{
                var serchg = 0.00;
            }

            if(global_row_list['item_count'] <= 0){
                NioApp.Toast('Cart is empty!', 'error',{position: 'bottom-right'});
                return;
            }
            var loadbtn_html = '<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span><span>Loading...</span>';
            $('#order-complete-btn').html(loadbtn_html).prop('disabled',true);
            $('#place-order-btn').html(loadbtn_html).prop('disabled',true);
            // var order_type = $('#order_type');
            $.ajax({
                type:'POST',
                url:'{{ route('user/pos/place_order') }}',
                headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                data: {
                    'order' : JSON.stringify(global_row_list),
                    'serchg' : serchg,
                    'table_id': {{ $table_id }},

                    // Pass the extracted table IDs to the server
                },
                success:function(data){

                    console.log(global_row_list);
                    if(status == 'Processing'){
                        cart_remove_all();

                        NioApp.Toast('Successfully Saved Item', 'success',{position: 'top-right'});
                        $('#running-order-'+data.order_list.id).remove();
                        var x='<div class="card card-bordered my-1" id="running-order-'+data.order_list.id+'">\n' +
                            '                                        <a href="javascript:void(0)" onclick="order_open(\''+data.order_list.id+'\')">\n' +
                            '                                        <div class="card-inner p-1">\n' +
                            '                                            <h6 class="small"><b id="">Order id : '+data.order_list.id+'</b></h6>\n' +
                            // '                                            <h6 class="small">Name : <span id="">'+data.order_list.reservation.first_name+'</span></h6>\n' +
                            '                                            <h6 class="small">Price : <span id="">'+data.order_list.total+'/=</span></h6>\n' +
                            '                                        </div>\n' +
                            '                                        </a>\n' +
                            '                                    </div>';
                        $('#runnig-orders').append(x);

                        $('#table_div-'+data.order_list.table_id).html(data.output);

                        $('#table_available').empty();

                        if(data.order_count >= 1){
                            var count = '<h6 class="card-title" style="text-align: right;"><span class="tb-status text-danger"> Orders AVAILABLE</span></h6>';
                        }
                        else{
                            var count = '<h6 class="card-title" style="text-align: right;"><span class="tb-status text-blue"> Table EMPTY </span></h6>';
                        }

                        $('#table_available').append(count);

                        // var y='<h6 class="modal-title">Order Id : '+data.order_list.id+'</h6>\n' +
                        //     '<h6 class="modal-title">Items : </h6>\n' +
                        //     '<h6 class="modal-title">Quantity : '+data.order_list.item_count+'</h6>\n' +
                        //     '                                                                                <h6 class="modal-title">Price : '+data.order_list.total+'</h6>';


                        {{--var y = '<div id="table_div-'+data.order_list.table_id+'" style="display: none;">\n' +--}}
                        {{--    '\n' +--}}
                        {{--    '                                                                                    <h5 class="card-title">'+data.tables.table_name+'</h5>\n' +--}}
                        {{--    '                                                                                    <hr/>';--}}

                        {{--$.each(data.items, function (key2, val2) {--}}
                        {{--    if(val2.id == val.item.id) {--}}
                        {{--        ingredients_li += '<option value="' +val2.id+ '" selected>' + val2.item + ' (' + val2.unit + ')</option>\n';--}}
                        {{--    }else{--}}
                        {{--        ingredients_li += '<option value="' + val2.id + '">' + val2.item + ' (' + val2.unit + ')</option>\n';--}}
                        {{--    }--}}
                        {{--});--}}

                        {{--var y='<div id="table_div-{{$table->id}}" style="display: none;">\n' +--}}
                        {{--    '\n' +--}}
                        {{--    '                                                                                    <h5 class="card-title">{{$table->table_name}}</h5>\n' +--}}
                        {{--    '                                                                                    <hr/>\n' +--}}
                        {{--    '                                                                                    @foreach($orders as $order)\n' +--}}
                        {{--    '                                                                                        @if($order->table_id == $table->id)\n' +--}}
                        {{--    '\n' +--}}
                        {{--    '                                                                                            <h6 class="modal-title">Order Id : {{$order->id}}</h6>\n' +--}}
                        {{--    '                                                                                            --}}{{--                                                                                            <h6 class="modal-title">Steward : {{$order->user->name}} {{$order->user->lname}}</h6>--}}{{--\n' +--}}
                        {{--    '                                                                                            @if($order->steward_id!=null)\n' +--}}
                        {{--    '                                                                                                <h6 class="modal-title">Steward : {{$order->user->name}} {{$order->user->lname}}</h6>\n' +--}}
                        {{--    '                                                                                            @endif\n' +--}}
                        {{--    '\n' +--}}
                        {{--    '                                                                                            @php($order_lists = \\App\\Order_list_detail::where(\'order_list_id\',$order->id)->get())\n' +--}}
                        {{--    '\n' +--}}
                        {{--    '                                                                                            @foreach($order_lists as $order_list)\n' +--}}
                        {{--    '\n' +--}}
                        {{--    '                                                                                                @php($como_item = json_decode($order_list->como_items_list))\n' +--}}
                        {{--    '\n' +--}}
                        {{--    '                                                                                                --}}{{--                                                                                                {{$list_item->name}} <br/>--}}{{--\n' +--}}
                        {{--    '                                                                                                <div class="col-lg-12 col-xxl-12">\n' +--}}
                        {{--    '                                                                                                    <div class="card card-bordered c_hight">\n' +--}}
                        {{--    '                                                                                                        <div class="card-inner ScrollStyle">\n' +--}}
                        {{--    '                                                                                                            <h6 class="modal-title">Items : {{$order_list->recipe_name}} &nbsp;-&emsp; {{$order_list->quantity}}</h6> <br/>\n' +--}}
                        {{--    '                                                                                                            <div class="timeline">\n' +--}}
                        {{--    '                                                                                                                @foreach($como_item as $list_item)\n' +--}}
                        {{--    '                                                                                                                    <h6 class="timeline-head"><span class="badge bg-light">{{$list_item->name}} &nbsp;-&emsp; {{$list_item->qty}}</span></h6>\n' +--}}
                        {{--    '                                                                                                                @endforeach\n' +--}}
                        {{--    '                                                                                                            </div>\n' +--}}
                        {{--    '                                                                                                        </div>\n' +--}}
                        {{--    '                                                                                                    </div><!-- .card -->\n' +--}}
                        {{--    '                                                                                                </div><!-- .col -->\n' +--}}
                        {{--    '                                                                                            @endforeach\n' +--}}
                        {{--    '\n' +--}}
                        {{--    '                                                                                            --}}{{--                                                                                        $.each(data.order_list.order_list_detail, function (key, val) {--}}{{--\n' +--}}
                        {{--    '                                                                                            --}}{{--                                                                                        let order_menus = JSON.parse(val.como_items_list);--}}{{--\n' +--}}
                        {{--    '                                                                                            --}}{{--                                                                                        add_to_cart(val.recipe_note_id,val.recipe_name,val.price,val.quantity,val.total,val.id,order_menus);--}}{{--\n' +--}}
                        {{--    '                                                                                            --}}{{--                                                                                        });--}}{{--\n' +--}}
                        {{--    '                                                                                            <h6 class="modal-title">Total : {{$order->total}}</h6>\n' +--}}
                        {{--    '                                                                                            <hr/>\n' +--}}
                        {{--    '\n' +--}}
                        {{--    '                                                                                        @else\n' +--}}
                        {{--    '                                                                                            --}}{{--                                                                                        <div id="table_div-{{$table->id}}">--}}{{--\n' +--}}
                        {{--    '\n' +--}}
                        {{--    '                                                                                            --}}{{--                                                                                        </div>--}}{{--\n' +--}}
                        {{--    '                                                                                        @endif\n' +--}}
                        {{--    '\n' +--}}
                        {{--    '                                                                                    @endforeach\n' +--}}
                        {{--    '                                                                                </div>';--}}




                        // $('#table_div-'+data.order_list.table_id).append(y);

                    }else if(status == 'Complete'){
                        $('#running-order-'+data.order_list.id).remove();
                        finalize_order(data.order_list.id);
                    }
                    $('#order-complete-btn').html('Submit').prop('disabled',false);
                    $('#place-order-btn').html('Place Order').prop('disabled',false);
                }

            });
        }



        function finalize_order(order_id){

            $.ajax({
                type:'POST',
                url:'{{ route('hotel/pos/finalize_order') }}',
                headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                data: {
                    'order_id' : order_id,
                    'paid-amount' : $('#f-paid-amount').val(),
                    'give-amount' : $('#f-give-amount').val(),
                    'change-amount' : $('#f-change-amount').val(),
                    'cashbook_id' : $('#f-cashbook-id').val(),
                    'payment_method' : $('#f-payment_method').val(),
                    'order_date' : $('#f-order-date').val(),
                },
                success:function(data){
                    cart_remove_all();
                    $('#finalize-order-modal').modal('hide');
                    var customer_email = $('#customer_email').val();
                    var url = '{!! route('hotel/invoice') !!}?print=true&id=' + order_id + '&customer_email=' + customer_email;
                    window.open(url, '_blank').focus();
                }
            });
        }
        function order_complete(){
            sync_order('Complete');
        }

        $('#place-order-btn').on('click', function() {
            sync_order('Processing');
        });
        $('#cancel-order-btn').on('click', function() {
            if(global_row_list['order_id'] != 'new'){
                $('#c-order-id').html('Order ID : #'+global_row_list['order_id']);
                $('#cancel-order-modal').modal('show');
            }else{
                NioApp.Toast('Don\'t worry, just clear cart', 'info',{position: 'bottom-right'});
            }
        });

        function order_cancel(){
            var loadbtn_html = '<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span><span>Loading...</span>';
            $('#order-cancel-btn').html(loadbtn_html).prop('disabled',true);
            $.ajax({
                type:'POST',
                url:'{{ route('hotel/pos/cancel_order') }}',
                headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                data: {
                    'order_id' : global_row_list['order_id'],
                    'reason' : $('#c-reason').val(),
                },
                success:function(data){

                    cart_remove_all();
                    $('#cancel-order-modal').modal('hide');

                    NioApp.Toast('Successfully Order Canceled!', 'success',{position: 'top-right'});
                    $('#running-order-'+data.order_list.id).remove();
                    $('#order-cancel-btn').html('Submit').prop('disabled',false);
                }

            });
        }

        $('.category_filter_list').on('click', function() {
            // $(this).removeClass('category_filter_list_li');

            $('.category_filter_list_li').removeClass('active');
            var cat = $(this).data('category');
            $(this).parent().addClass("active");

        });

    </script>

    <script>
        function try_add_to_cart(menuid , type) {
            $.ajax({
                type:'POST',
                url:'{{ route('user/pos/try_add_to_cart') }}',
                headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                data: {
                    'menu_id' : menuid,
                },
                success:function(data){
                    global_combo_selection = [];
                    global_combo_selection['compalsary'] = [];
                    global_combo_selection['group_ids'] = [];
                    global_combo_selection['name'] = data.menu.name;
                    global_combo_selection['price'] = data.menu.price;
                    global_combo_selection['menu_id'] = data.menu.id;
                    // cart_remove_all();
                    $('#add-to-cart-model-body').html(data.output);
                    $('#add-to-cart-model-title').html(data.menu.name+' - Rs.'+data.menu.price+'/-');
                    $('#add-to-cart-model').modal('show');
                    $.each(data.menu.combo, function (key, val) {
                        if(val.item == 1){
                            var n = {
                                'combo_item_id':val.combo_item[0].id,
                                'menu_id':val.combo_item[0].menu_id,
                                'qty':val.combo_item[0].quantity,
                                'name':val.combo_item[0].menu.name
                            }
                            global_combo_selection['compalsary'].push(n);
                        }else{
                            var comboid = 'comob-'+val.id
                            global_combo_selection[comboid] = {max : val.maximum_count,select_items: []}
                            global_combo_selection['group_ids'].push(comboid);
                            console.log(val);
                            console.log(global_combo_selection);

                        }
                    });

                    // NioApp.Toast('Successfully Order Canceled!', 'success',{position: 'top-right'});
                    // $('#running-order-'+data.order_list.id).remove();
                    // $('#order-cancel-btn').html('Submit').prop('disabled',false);
                }

            });
        }

        function combo_group_option_select(se_object,combo_id,combo_item_id,menu_id,name,qty){
            var comboid = 'comob-'+combo_id;
            var cList = se_object.classList;
            if (cList.contains('bg-success-dim') || cList.contains('border-success')) {
                global_combo_selection[comboid].select_items = global_combo_selection[comboid].select_items.filter(item => item.combo_item_id != combo_item_id)
                cList.remove('bg-success-dim');
                cList.remove('border-success');
            }else{
                if(global_combo_selection[comboid].select_items.length < global_combo_selection[comboid].max){
                    var n = {
                        'combo_item_id':combo_item_id,
                        'menu_id':menu_id,
                        'qty':qty,
                        'name':name
                    }
                    global_combo_selection[comboid].select_items.push(n);
                    cList.add('bg-success-dim');
                    cList.add('border-success');
                }
            }

            // console.log(global_combo_selection);
            // console.log(cList.contains('bg-success-dim') || cList.contains('border-success'));

        }

        function add_to_cart2() {
            // console.log(global_combo_selection);
            $.each(global_combo_selection['group_ids'], function (key,comboid) {
                var s = global_combo_selection[comboid].select_items;
                // console.log(s);
                $.each(s, function (k,v) {
                    global_combo_selection['compalsary'].push(v);

                });
            });
            add_to_cart(global_combo_selection['menu_id'],global_combo_selection['name'],global_combo_selection['price'],1,global_combo_selection['price'],'new',global_combo_selection['compalsary']);
            // console.log(global_combo_selection);
            $('#add-to-cart-model').modal('hide');

        }

        $('#select_customer_').change(function() {
            var reservation_id = $(this).val();
            var room_select = $('#room_number');
            room_select.empty();
            if (reservation_id == 'Walk-in Customer') {
                room_select.append(
                    $('<option></option>').val('Walk-in Customer').html('-')
                );
                $('#f-payment_method option[value="Pay later"]').remove();
            }else{
                $('#f-payment_method').append(
                    $('<option></option>').val('Pay later').html('Pay later')
                );
                $.ajax({
                    type: 'POST',
                    url: '{{ route('hotel/pos/gte/customer/room') }}',
                    headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                    data: {
                        'reservation_id': reservation_id,
                    },
                    success: function (data) {
                        if (data.room.length > 0) {
                            $.each(data.room, function (index, val) {
                                room_select.append(
                                    $('<option></option>').val(val.room.id).html(val.room.room_number)
                                );
                            });
                        } else {
                            NioApp.Toast('Rooms not assign yet', 'info',{position: 'top-right'});
                            room_select.append(
                                $('<option></option>').val('Walk-in Customer').html('-')
                            );
                        }


                    }

                });
            }
        });

    </script>

    <script>

        $(document).ready(function(){
            // Listen for input changes in the search input field
            $('#search-input').on('input', function() {
                // Get the search query
                var query = $(this).val().toLowerCase();

                // Loop through each card and hide/show based on the search query
                $('.menu_item_list_pos').each(function() {
                    var item_name = $(this).data('item_name').toLowerCase();
                    if (item_name.indexOf(query) === -1) {
                        $(this).hide();
                    } else {
                        $(this).show();
                    }
                });
            });
        });

        document.getElementById('order').addEventListener('click', function() {
            order_open('{{$order_id}}');
            $("#show-menu-modal").modal('show');
        });

        document.getElementById('cartButton').addEventListener('click', function() {
{{--            order_open('{{$order_id}}')--}}
            $("#view-cart-modal").modal('show');
        });

        document.getElementById('ongoingOrders').addEventListener('click', function() {
            $.ajax({
                type: 'POST',
                url: '{{ route('user/resturent/getOngoingOrders') }}',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                data: {
                    'order_id': '{{ $order_id }}', // Ensure $order_id is properly printed as a string
                },
                success: function(data) {
                    console.log(data);
                    document.getElementById("runnig-orders").innerHTML = '';
                    var html = '<div class="card-inner px-1">' +
                        '<div class="card-head">' +
                        '<h6 class="card-title">Running Orders</h6>' +
                        '</div>' +
                        '</div>';

                    var totalPrice = 0; // Initialize total price

                    $.each(data, function(index, order) {
                        html += '<div class="col-12 text-left">' +
                            '<h6 class="modal-title"> ' + order.recipe_name + '&nbsp;-&emsp;' + order.quantity + '&nbsp;=&emsp;' + order.price * order.quantity + '</h6>' +
                            '</div><!-- .col -->'+
                            '<hr/>';

                        totalPrice += parseFloat(order.price * order.quantity); // Calculate the total price for each item
                    });
                    var serviceCharges = totalPrice * 10 / 100;
                    var totalPayble = totalPrice + serviceCharges;

                    html += '<div class="row">' +
                        '<div class="col-6 text-left">' +
                        '<h6 class="modal-title">Sub Total: ' + totalPrice.toFixed(2) + '</h6>' +
                        '</div>' +
                        '<div class="col-6 text-right">' +
                        '<h6 class="modal-title">Service Charges: ' + serviceCharges.toFixed(2) + '</h6>' +
                        '</div>' +
                        '</div>' +
                        '<hr/>' +
                        '<h5 class="modal-title text-center">Total Payable: ' + totalPayble.toFixed(2) + '</h5>' +
                        '<hr/>';

                    $("#runnig-orders").html(html);
                    $("#view-ongoingOrders-modal").modal('show');
                }
            });
        });






    </script>

@endsection
