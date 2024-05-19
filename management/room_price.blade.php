@extends('management.lay' )

@section('title' , __(''))

@section('style')

    <style>
        .date_range{display: block;
            width: 100%;
            padding: 0.4375rem 1rem;
            font-size: 0.8125rem;
            font-weight: 400;
            line-height: 1.25rem;
            color: #3c4d62;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #dbdfea;
            appearance: none;
            border-radius: 4px;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
    </style>
@endsection

@section('content')
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Rooms Prices</h3>
                <div class="nk-block-des text-soft">
                    <p>You in <span class="text-warning">{{$hotel->hotel_chain->name}}</span>  <em class="icon ni ni-forward-arrow-fill"></em>  <span class="text-success">{{$hotel->hotel_name}}</span></p>
                </div>
            </div><!-- .nk-block-head-content -->
            <div class="nk-block-head-content">
                <div class="toggle-wrap nk-block-tools-toggle">
                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                    <div class="toggle-expand-content" data-content="pageMenu">
                        <ul class="nk-block-tools g-3">

                            <li class="nk-block-tools-opt d-none d-sm-block">
                                <a href="#" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add-rooms"><em class="icon ni ni-plus"></em><span>Add Rooms</span></a>
                            </li>
                            <li class="nk-block-tools-opt d-block d-sm-none">
                                <a href="#" class="btn btn-icon btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add-rooms"><em class="icon ni ni-plus"></em><span>Rooms &nbsp;&nbsp;</span></a>
                            </li>
                        </ul>
                    </div>
                </div><!-- .toggle-wrap -->
            </div><!-- .nk-block-head-content -->
        </div><!-- .nk-block-between -->
    </div>



    <div class="nk-block">
        <div class="row">

            <div class="col-md-8 col-xxl-8">
                @foreach ($price_categories as $category => $categoryPrices)
                    <div class="nk-block">
                        <div class="card card-bordered card-preview">
                            <div class="card-inner">

                                <table class="datatable-init-export nowrap table room-table" data-export-title="Export" id="Room-table">
                                    {{--                                <h4>{{$category}}</h4><a onclick="add_price_category('{{$categoryPrices[0]->room_category_id}}')"><em class="icon ni ni-note-add"></em><span>Add Price Category</span></a>--}}

                                    <div class="card-inner">
                                        <div class="card-title-group">
                                            <div class="card-title">
                                                <h6 class="title">{{$category}}</h6>
                                            </div>
                                            <div class="card-tools">
                                                <a class="btn btn-primary" onclick="add_price_category('{{$categoryPrices[0]->room_category_id}}')"><span>Add Price Category</span></a>
                                                {{--                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalDefault">Add</button>--}}
                                            </div>
                                        </div>
                                    </div>
                                    <thead>
                                    <tr>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Room Price</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($categoryPrices as $priceCategory)
                                        <tr>
                                            <td>{{$priceCategory->start_date}}</td>
                                            <td>{{$priceCategory->end_date}}</td>
                                            <td>{{$priceCategory->price}}</td>
                                            <td class="nk-tb-col nk-tb-col-tools">
                                                <a class="btn btn-trigger btn-icon updateRecordButton" data-roomid="{{$priceCategory->id}}" data-bs-toggle="modal" data-bs-target="#modal-edit-price-category" data-bs-tooltip="tooltip" data-bs-placement="top" title="Edit Category">
                                                    <em class="icon ni ni-pen2"></em>
                                                </a>
                                                <div class="dropdown">
                                                    <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown" aria-expanded="false"><em class="icon ni ni-sign-xrp-new-alt" title="Delete Category"></em></a>
                                                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs" style="">
                                                        <ul class="link-list-plain">
                                                            <li><a class="deleteRecordButton" data-roomid="{{$priceCategory->id}}">Yes</a></li>
                                                            <li><a>No</a></li>
                                                        </ul>
                                                    </div>
                                                </div>

                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>


            <div class="col-md-4 col-xxl-4">
                <div class="card card-bordered card-full">
                    <div class="card-inner-group" id="room_category_list">
                        <div class="card-inner">
                            <div class="card-title-group">
                                <div class="card-title">
                                    <h6 class="title">Room Category</h6>
                                </div>

                            </div>
                        </div>
                        @foreach($room_categories as $room_category)
                            <div class="card-inner card-inner-md">
                                <div class="user-card">
                                    <div class="user-avatar bg-primary-dim">
                                        <span>AB</span>
                                    </div>
                                    <div class="user-info">
                                        <span class="lead-text">{{$room_category->category}}</span>
                                        <span class="sub-text">have {{$room_category->room_count}} Rooms, And Assigned {{$room_category->room->count()}} Rooms</span>
                                    </div>
                                    <div class="user-action">
                                        <div class="drodown">
                                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger me-n1" data-bs-toggle="dropdown" aria-expanded="false"><em class="icon ni ni-more-h"></em></a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="btn btn-primary" onclick="add_price_category('{{$room_category->id}}')"><span>Add Price Category</span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div><!-- .card -->
            </div><!-- .col -->
        </div>
    </div>



    {{--    <div class="modal hide fade" role="dialog" aria-hidden="true" id="modal-edit-price_category">--}}
    <div class="modal hide fade" id="modal-edit-price-category" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title"> Edit Price Category</h5>
                </div>
                <div class="modal-body" id="">
                    <form action="{{ route('management/edit_price_category/save') }}" method="post" id="edit_price_category_save" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="p_category_id" id="p_category_id">
                        <input type="hidden" name="check_in_date" id="echeck_in_date">
                        <input type="hidden" name="check_out_date" id="echeck_out_date">

                        <div class="form-group">
                            <div class="form-label-group">
                                <label for="daterange" class="form-label">Select Date Range</label>
                            </div>
                            <div class="form-control-wrap">
                                <input type="text" id="daterange" name="daterange" value="{{date('Y-m-d')}}" class="date_range"/>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-xxl-6">
                            <div class="form-group">
                                <label class="form-label" for="e_b_rooms_count">Price</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="ue_b_rooms_count" name="e_b_rooms_count" required>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-light">
                    <div class="form-group">
                        <button type="button" class="btn btn-danger btn-lg" data-bs-dismiss="modal">Close</button>
                        <button type="button" onclick="$('#edit_price_category_save').submit();" class="btn btn-lg btn-primary">Save Price Category</button>
                    </div>
                </div>
            </div>
        </div>
    </div>







    <div class="modal hide fade" role="dialog" aria-hidden="true" id="modale_add_price_category">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title"> Add Price Category</h5>
                </div>
                <div class="modal-body" id="">
                    <form action="{{route('management/add_price_category/save')}}" method="post" id="add_price_category_save" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="e_category_id" id="e_category_id">
                        <input type="hidden" name="check_in_date" id="check_in_date">
                        <input type="hidden" name="check_out_date" id="check_out_date">

                        <div class="form-group">
                            <div class="form-label-group">
                                <label for="daterange" class="form-label">Select Date Range</label>
                            </div>
                            <div class="form-control-wrap">
                                <input type="text" id="daterange" name="daterange" value="{{date('Y-m-d')}}" class="date_range"/>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-xxl-6">
                            <div class="form-group">
                                <label class="form-label" for="email-address-1">Price</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="e_b_rooms_count" name="e_b_rooms_count" required>
                                </div>
                            </div>
                        </div>


                    </form>
                </div>
                <div class="modal-footer bg-light">
                    <div class="form-group">
                        <button type="button" class="btn btn-danger btn-lg" data-bs-dismiss="modal">Close</button>
                        <button type="button" onclick="$('#add_price_category_save').submit();" class="btn btn-lg btn-primary">Save Category</button>
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
            var export_title = $('.room-table').data('export-title') ? $('.room-table').data('export-title') : 'Export';
            var attr = {
                "order": [[0, "desc"]],
                "responsive": false,
                "scrollX": true, // enable horizontal scrolling
                "autoWidth": false,
                "dom": "<\"row justify-between g-2 with-export\"<\"col-7 col-sm-4 text-start\"f><\"col-5 col-sm-8 text-end\"<\"datatable-filter\"<\"d-flex justify-content-end g-2\"<\"dt-export-buttons d-flex align-center\"<\"dt-export-title d-none d-md-inline-block\">B>l>>>><\"datatable-wrap my-3\"t><\"row align-items-center\"<\"col-7 col-sm-12 col-md-9\"p><\"col-5 col-sm-12 col-md-3 text-start text-md-end\"i>>",
                "language": {
                    "search": "",
                    "searchPlaceholder": "Type in to Search",
                    "infoEmpty": "0",
                    "infoFiltered": "( Total MAX  )",
                    "paginate": {"first": "First", "last": "Last", "next": "Next", "previous": "Prev"}
                },
                "buttons": ["copy", "excel", "csv", "pdf", "colvis"]
            };
            NioApp.DataTable = $('.room-table').DataTable(attr);
            $.fn.DataTable.ext.pager.numbers_length = 7;
            $('.dt-export-title').text(export_title);

        });


        // Ensure jQuery and datepicker libraries are included

        // Initialize date range picker
        $('.date_range').daterangepicker();

        // Event delegation for dynamic elements
        $('#Room-table tbody').on('click', 'a', function () {
            if ($(this).hasClass('updateRecordButton')) {
                var tr = $(this).closest('tr');
                var room_id = $(this).data('roomid');

                $('#modal-edit-price_category').modal('show');

                $.ajax({
                    type: 'POST',
                    url: '{{ route('management/Room/get_edit_rooms_details') }}',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    data: { 'room_id': room_id },
                    success: function (data) {
                        $('#p_category_id').val(data.edit_price_category.id);
                        $('#start_date').val(data.edit_price_category.start_date);
                        $('#end_date').val(data.edit_price_category.end_date);
                        $('#e_b_rooms_count').val(data.edit_price_category.price);

                        $('#modal-edit-price_category').modal('show');
                    }
                });
            }

            if ($(this).hasClass('deleteRecordButton')) {
                var tr = $(this).closest('tr');
                var room_id = $(this).data('roomid');

                $.ajax({
                    type: 'POST',
                    url: '{{ route('management/room/delete') }}',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    data: { 'room_id': room_id },
                    success: function (data) {
                        if (data.success) {
                            NioApp.Toast('Successfully Deleted Room', 'success', { position: 'top-right' });
                            tr.remove().draw();
                        } else {
                            NioApp.Toast(data.error, 'warning', { position: 'top-right' });
                        }
                    }
                });
            }
        });


        function add_price_category(category_id) {

            $('#e_category_id').val(category_id);
            $('#modale_add_price_category').modal('show');
        }




    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Enable Bootstrap tooltips
            var updateButtons = document.querySelectorAll('.updateRecordButton');
            updateButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    var priceCategoryId = button.getAttribute('data-roomid');

                    $.ajax({
                        type: 'POST',
                        url: '{{ route("management/Room/get_edit_price_category_details") }}',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        data: { 'room_id': priceCategoryId },
                        success: function (data) {
                            var initialCheckinDate;
                            var initialCheckoutDate;
                            console.log(data);
                            $('#p_category_id').val(data.edit_price_category.id);
                            initialCheckinDate = data.edit_price_category.start_date;
                            initialCheckoutDate = data.edit_price_category.end_date;
                            $('#ue_b_rooms_count').val(data.edit_price_category.price);


                            const startDate = new Date(initialCheckinDate);
                            const endDate = new Date(initialCheckoutDate);

                            // Format the dates as MM/DD/YYYY
                            const formattedStartDate = `${startDate.getMonth() + 1}/${startDate.getDate()}/${startDate.getFullYear()}`;
                            const formattedEndDate = `${endDate.getMonth() + 1}/${endDate.getDate()}/${endDate.getFullYear()}`;

                            // Create the date range string
                            const dateRange = `${formattedStartDate} - ${formattedEndDate}`;

                            console.log(dateRange);
                            $('#daterange').val(dateRange);



                            $('#modal-edit-price_category').modal('show');
                        }
                    });
                });
            });


            var deleteButtons = document.querySelectorAll('.deleteRecordButton');
            deleteButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    var priceCategoryId = button.getAttribute('data-roomid');

                    $.ajax({
                        type: 'POST',
                        url: '{{ route("management/Room/delete_price_category_details") }}',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        data: { 'room_id': priceCategoryId },
                        success: function (data) {

                            location.reload();

                        }
                    });
                });
            });
        });
    </script>

    <script>

        $(function() {
            // Function to initialize the date range picker
            var currentPicker;
            // function initializeDateRangePicker() {
            currentPicker =  $('input[name="daterange"]').daterangepicker({
                opens: 'right',
                minDate: moment().startOf('day') // Set minimum date to today
            }, function(start, end, label) {
                var checking_date = start.format('YYYY-MM-DD');
                var checkout_date = end.format('YYYY-MM-DD');
                $('#check_in_date').val(checking_date);
                $('#check_out_date').val(checkout_date);
                $('#echeck_in_date').val(checking_date);
                $('#echeck_out_date').val(checkout_date);
                // get_avilable_rooms(checking_date,checkout_date,'Night Stay');
                // Need ajax here to send selected date or date range to the backend
                console.log("A new date selection was made: " + checking_date + ' to ' + checkout_date);
                // });
            })


        });


    </script>


@endsection

