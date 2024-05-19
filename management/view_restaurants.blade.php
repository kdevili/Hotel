@extends('management.lay' )

@section('title' , __(''))

@section('style')

@endsection

@section('content')
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Restaurants</h3>
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
                                <a href="#" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add-restaurant"><em class="icon ni ni-plus"></em><span>Add Restaurant</span></a>
                            </li>
                            <li class="nk-block-tools-opt d-block d-sm-none">
                                <a href="#" class="btn btn-icon btn-primary"><em class="icon ni ni-plus"></em></a>
                            </li>
                        </ul>
                    </div>
                </div><!-- .toggle-wrap -->
            </div><!-- .nk-block-head-content -->
        </div><!-- .nk-block-between -->
    </div>


    <div class="nk-block">
        <div class="card card-bordered card-preview">
            <div class="card-inner">

                <table class="datatable-init-export nowrap table" data-export-title="Export" id="restarants-table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Hotel</th>
                        <th>Hotel Chain</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($restaurants as $restaurant)
                            <tr>
                                <td>{{$restaurant->name}}</td>
                                <td>{{$restaurant->hotel->hotel_name}}</td>
                                <td>{{$restaurant->hotel->hotel_chain->name}}</td>
                                <td class="nk-tb-col nk-tb-col-tools">
                                    <a class="btn btn-trigger btn-icon updateRecordButton" data-restaurantid="{{$restaurant->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Restaurant"><em class="icon ni ni-pen2"></em></a>
                                    <a class="btn btn-trigger btn-icon deleteRecordButton" data-restaurantid="{{$restaurant->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Restaurant"><em class="icon ni ni-sign-xrp-new-alt"></em></a>
                                    <a class="btn btn-trigger btn-icon" onclick="change_menu_view({{$restaurant->id}});" data-bs-toggle="tooltip" data-bs-placement="top" title="View Restaurant"><em class="icon ni ni-list-index-fill"></em></a>
                                </td>
                            </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <div class="modal hide fade" role="dialog" aria-hidden="true" id="modal-add-restaurant">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title"> Add Restaurant</h5>
                </div>
                <div class="modal-body" id="recipe_ingredient_edit">
                    <form action="{{ route('management/restaurants/save') }}" method="post" id="add_user_restaurant" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="{{$hotel->id}}" name="hotel_id_a" id="hotel_id_a">
                        <input type="hidden" value="{{$hotel->hotel_chain->id}}" name="hotel_chain_id_a" id="hotel_chain_id_a">
                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="email-address-1">Restaurant Name</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="restaurant_name" name="restaurant_name" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="email-addr">Select Cash Book For Card Payments</label>
                                        <div class="form-control-wrap">
                                            <select class="form-select js-select2" data-search="on" id="card-cashbook-id" name="card-cashbook-id">
                                                <option value="">Select Cash Book</option>
                                                @foreach($cash_books as $cash_book)
                                                    <option value="{{$cash_book->id}}">{{$cash_book->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="email-adwwdr">Select Cash Book For Cash Payments</label>
                                        <div class="form-control-wrap">
                                            <select class="form-select js-select2" data-search="on" id="cash-cashbook-id" name="cash-cashbook-id">
                                                <option value="">Select Cash Book</option>
                                                @foreach($cash_books as $cash_book)
                                                    <option value="{{$cash_book->id}}">{{$cash_book->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-light">
                    <div class="form-group">
                        <button type="button" class="btn btn-danger btn-lg" data-bs-dismiss="modal">Close</button>
                        <button type="button" onclick="$('#add_user_restaurant').submit();" class="btn btn-lg btn-primary">Save Restaurant</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal hide fade" role="dialog" aria-hidden="true" id="modal-edit-restaurant">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title"> Edit Restaurant</h5>
                </div>
                <div class="modal-body" id="">
                    <form action="{{route('management/edit_restaurant/save')}}" method="post" id="edit_restaurant_save">
                        @csrf
                        <input type="hidden" name="e_restaurant_id" value="" id="e_restaurant_id">
{{--                        <input type="hidden" name="edit_user_privilege_id" value="" id="edit_user_privilege_id">--}}
                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="email-address-1">Restaurant Name</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="e_restaurant_name" name="e_restaurant_name" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="email-addeer">Select Cash Book For Card Payments</label>
                                        <div class="form-control-wrap">
                                            <select class="form-select js-select2" data-search="on" id="e_card-cashbook-id" name="e_card-cashbook-id">
                                                <option value="">Select Cash Book</option>
                                                @foreach($cash_books as $cash_book)
                                                    <option value="{{$cash_book->id}}">{{$cash_book->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="email-adwwdeer">Select Cash Book For Cash Payments</label>
                                        <div class="form-control-wrap">
                                            <select class="form-select js-select2" data-search="on" id="e_cash-cashbook-id" name="e_cash-cashbook-id">
                                                <option value="">Select Cash Book</option>
                                                @foreach($cash_books as $cash_book)
                                                    <option value="{{$cash_book->id}}">{{$cash_book->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer bg-light">
                    <div class="form-group">
                        <button type="button" class="btn btn-danger btn-lg" data-bs-dismiss="modal">Close</button>
                        <button type="button" onclick="$('#edit_restaurant_save').submit();" class="btn btn-lg btn-primary">Save Restaurant</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="modal-resturent_menu">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title">assign menu</h5>
                </div>
                <div class="modal-body">
                    <form action="{{ route('management/restaurant/assign_menu/save') }}" method="post" id="assign_menu_form" enctype="multipart/form-data">
                        <input type="hidden" name="resturent_id" id="resturent_id">
                        @csrf
                        <table class="datatable-init-export table" data-export-title="Export" id="resturent_menu-table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Hotel</th>
                                <th>Hotel Chain</th>
                                <th>
                                    <div class="custom-control custom-control-sm custom-checkbox notext">
                                        <input name="menu-select-all" type="checkbox" class="custom-control-input" id="menu-select-all">
                                        <label class="custom-control-label" for="menu-select-all"></label>
                                    </div>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($menus = \App\Menu::where('hotel_id', $hotel->id)->where('type', 'Visible')->get())


                            @foreach($menus as $menu)
                                <tr>
                                    <td>{{$menu->name}}</td>
                                    <td>{{$menu->price}}</td>
                                    <td>{{$menu->price}}</td>
                                    <td>
                                        <div class="custom-control custom-control-sm custom-checkbox notext">
                                            <input name="menus[]" type="checkbox" class="custom-control-input" id="check-menu-{{$menu->id}}" value="{{$menu->id}}">
                                            <label class="custom-control-label" for="check-menu-{{$menu->id}}"></label>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>

                    </form>
                </div>
                <div class="modal-footer bg-light">
                    <div class="form-group">
                        <button type="button" onclick="$('#assign_menu_form').submit();" class="btn btn-lg btn-primary">Save Item</button>
                        <button type="button" class="btn btn-danger btn-lg" data-bs-dismiss="modal">Close</button>
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
                var export_title = $('#restarants-table').data('export-title') ? $('#restarants-table').data('export-title') : 'Export';
                var attr = {
                    "responsive": {"details": true},
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
                NioApp.DataTable = $('#restarants-table').DataTable(attr);
                $.fn.DataTable.ext.pager.numbers_length = 7;
                $('.dt-export-title').text(export_title);


                var export_title = $('#resturent_menu-table').data('export-title') ? $('#resturent_menu-table').data('export-title') : 'Export';
                var attr =  {
                    "responsive":{"details":true},
                    "autoWidth":false,
                    "dom":"<\"row justify-between g-2 with-export\"<\"col-7 col-sm-4 text-start\"f><\"col-5 col-sm-8 text-end\"<\"datatable-filter\"<\"d-flex justify-content-end g-2\"<\"dt-export-buttons d-none align-center\"<\"dt-export-title d-none d-md-inline-block\">B>l>>>><\"datatable-wrap my-3\"t><\"row align-items-center\"<\"col-7 col-sm-12 col-md-9\"p><\"col-5 col-sm-12 col-md-3 text-start text-md-end\"i>>",
                    "language":{"search":"","searchPlaceholder":"Type in to Search","infoEmpty":"0","infoFiltered":"( Total MAX  )","paginate":{"first":"First","last":"Last","next":"Next","previous":"Prev"}},
                    // "buttons":["copy","excel","csv","pdf","colvis"]
                    "ordering": false
                };
                NioApp.DataTable2 = $('#resturent_menu-table').DataTable(attr);
                $.fn.DataTable.ext.pager.numbers_length = 7;
                $('.dt-export-title').text(export_title);



            });
            $("#add_user_restaurant").submit(function(e) {

                e.preventDefault(); // avoid to execute the actual submit of the form.
                var form = $(this);
                var formData = new FormData($(this)[0]);
                var url = form.attr('action');
                $.ajax({
                    type: "POST",
                    processData: false,
                    contentType: false,
                    url: url,
                    data: formData, // serializes the form's elements.
                    success: function (data) {
                        // $('#add_user_save input:checkbox').prop('checked',false).prop('disabled',true);
                        // $('.handle_disable').prop('disabled',false);
                        $(':input', '#add_user_restaurant')
                            .not(':button, :submit, :reset, :hidden')
                            .val('')
                            .prop('selected', false);
                        console.log(data);
                        var action_buton ='<a class="btn btn-trigger btn-icon updateRecordButton" data-restaurantid="'+data.restaurant.id+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Restaurant"><em class="icon ni ni-pen2"></em></a>\n' +
                            '              <a class="btn btn-trigger btn-icon deleteRecordButton" data-restaurantid="'+data.restaurant.id+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Restaurant"><em class="icon ni ni-sign-xrp-new-alt"></em></a>\n' +
                            '              <a class="btn btn-trigger btn-icon" onclick="change_menu_view('+data.restaurant.id+');" data-bs-toggle="tooltip" data-bs-placement="top" title="View Restaurant"><em class="icon ni ni-list-index-fill"></em></a>';
                        var table_data = [data.restaurant.name,'{{$hotel->hotel_name}}','{{$hotel->hotel_chain->name}}',action_buton];
                        {{--// // console.log(table_data);--}}
                        {{--// //--}}
                        NioApp.DataTable.row.add(table_data);
                        NioApp.DataTable.draw();
                        $('#modal-add-restaurant').modal('hide');
                        NioApp.Toast('Successfully Add Restaurants', 'success',{position: 'top-right'});
                    }
                });
            });
            $('#restarants-table tbody').on('click',
                'a',
                function () {
                    if ( $(this).hasClass('updateRecordButton') ) {
                        var data = NioApp.DataTable.row($(this).parents('tr')).data(); //Retrieve row data
                        var tr = $(this).closest('tr'); //Find DataTables table row
                        var theRowObject = NioApp.DataTable.row(tr); //Get DataTables row object
                        var restaurant_id = $(this).data('restaurantid');
                        global_theRowObject=theRowObject;
                        console.log(data);
                        $.ajax({
                            type:'POST',
                            url:'{{ route('management/restaurant/get_edit_restaurant_details') }}',
                            headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                            data: {
                                'restaurant_id' : restaurant_id,
                            },
                            success:function(data){
                                console.log(data);
                                $('#e_restaurant_id').val(data.restaurant.id)
                                $('#e_restaurant_name').val(data.restaurant.name)
                                $('#e_cash-cashbook-id').val(data.restaurant.cash_payment).trigger("change");
                                $('#e_card-cashbook-id').val(data.restaurant.card_payment).trigger("change");

                                $('#modal-edit-restaurant').modal('show');

                            }

                        });

                    }
                    if ( $(this).hasClass('deleteRecordButton') ) {
                        var data = NioApp.DataTable.row($(this).parents('tr')).data(); //Retrieve row data
                        var tr = $(this).closest('tr'); //Find DataTables table row
                        var theRowObject = NioApp.DataTable.row(tr); //Get DataTables row object
                        var restaurant_id = $(this).data('restaurantid');
                        // global_theRowObject2=theRowObject;
                        $.ajax({
                            type:'POST',
                            url:'{{ route('management/restaurant/delete') }}',
                            headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                            data: {
                                'restaurant_id' : restaurant_id,
                            },
                            success:function(data){
                                if(data.success){
                                    NioApp.Toast('Successfully Deleted Restaurant', 'success',{position: 'top-right'});
                                    NioApp.DataTable.row(theRowObject).remove().draw();
                                }else{
                                    NioApp.Toast(data.error, 'warning',{position: 'top-right'});
                                }
                            }

                        });

                    }
                });

            $("#edit_restaurant_save").submit(function(e) {

                e.preventDefault(); // avoid to execute the actual submit of the form.
                var form = $(this);
                var formData = new FormData($(this)[0]);
                var url = form.attr('action');
                $.ajax({
                    type: "POST",
                    processData: false,
                    contentType: false,
                    url: url,
                    data: formData, // serializes the form's elements.
                    success: function (data) {

                        console.log(data);
                        var action_buton ='<a class="btn btn-trigger btn-icon updateRecordButton" data-restaurantid="'+data.restaurant.id+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Restaurant"><em class="icon ni ni-pen2"></em></a>\n' +
                            '                                 <a class="btn btn-trigger btn-icon deleteRecordButton" data-restaurantid="'+data.restaurant.id+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Restaurant"><em class="icon ni ni-sign-xrp-new-alt"></em></a>\n' +
                            '                                <a class="btn btn-trigger btn-icon" onclick="view_privilege_details();" data-bs-toggle="tooltip" data-bs-placement="top" title="View Restaurant"><em class="icon ni ni-list-index-fill"></em></a>';
                        var table_data = [data.restaurant.name,'{{$hotel->hotel_name}}','{{$hotel->hotel_chain->name}}',action_buton];

                        NioApp.DataTable.row(global_theRowObject).data(table_data).draw(false);
                        $('#modal-edit-restaurant').modal('hide');
                        NioApp.Toast('Successfully Edit Restaurant', 'success',{position: 'top-right'});
                    }
                });
            });

            function change_menu_view(id) {
                $('#resturent_id').val(id);
                $.ajax({
                    type: "POST",
                    headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                    url: '{{route('management/restaurant/assign_menus/get')}}',
                    data: {
                        restaurant_id : id,
                    }, // serializes the form's elements.
                    success: function (data) {
                        NioApp.DataTable2.rows().nodes().to$().find("input:checked").prop('checked',false);
                        $.each(data.menus, function (key, val) {
                             NioApp.DataTable2.rows().nodes().to$().find("#check-menu-"+val.menu_id).prop('checked',true);
                        });
                        $('#modal-resturent_menu').modal('show');

                    }
                });

            }
            $( '#menu-select-all' ).click( function () {
                NioApp.DataTable2.rows().nodes().to$().find("input[type=\"checkbox\"]").prop('checked', this.checked);
            })

            $('#assign_menu_form').on('submit', function(e) {
                e.preventDefault();
                var select_menu_ids = NioApp.DataTable2.rows().nodes().to$().find("input:checked").map(function() {
                    return this.value;
                }).get();
                var form = $(this);


                var url = form.attr('action');
                $.ajax({
                    type: "POST",
                    headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                    url: url,
                    data: {
                        select : select_menu_ids,
                        restaurant_id : $('#resturent_id').val(),
                    }, // serializes the form's elements.
                    success: function (data) {
                        $('#modal-resturent_menu').modal('hide');

                    }
                });
                return false;
            } );
</script>


@endsection
