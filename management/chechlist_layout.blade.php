@extends('management.lay' )

@section('title' , __(''))

@section('style')

@endsection

@section('content')
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Housekeeping</h3>
                <div class="nk-block-des text-soft">
                    <p>You in <span class="text-warning">{{$hotel->hotel_chain->name}}</span>  <em class="icon ni ni-forward-arrow-fill"></em>  <span class="text-success">{{$hotel->hotel_name}}</span></p>
                </div>
            </div><!-- .nk-block-head-content -->
            <div class="nk-block-head-content">
                <div class="toggle-wrap nk-block-tools-toggle">
                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                    <div class="toggle-expand-content" data-content="pageMenu">
                        <ul class="nk-block-tools g-3">

{{--                            <li class="nk-block-tools-opt d-none d-sm-block">--}}
{{--                                <a href="#" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add-checklist_layout"><em class="icon ni ni-plus"></em><span>Add Check List Layouts</span></a>--}}
{{--                            </li>--}}
{{--                            <li class="nk-block-tools-opt d-block d-sm-none">--}}
{{--                                <a href="#" class="btn btn-icon btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add-checklist_layout"><em class="icon ni ni-plus"></em><span>Layouts&nbsp;&nbsp;</span></a>--}}
{{--                            </li>--}}
                        </ul>
                    </div>
                </div><!-- .toggle-wrap -->
            </div><!-- .nk-block-head-content -->
        </div><!-- .nk-block-between -->
    </div>

    <div class="nk-block">
        <div class="row">

            <div class="col-md-8 col-xxl-8">
                <div class="nk-block">
                    <div class="card card-bordered card-preview">
                        <div class="card-inner">

                            <table class="datatable-init-export nowrap table" data-export-title="Export" id="CheckList-table">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Checklist Layout</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($rooms as $room)
                                    <tr>
                                        <td>{{$room->room_number}}</td>
                                        <td>{{$room->room_category->category}}</td>
                                        <td>{{isset($room->check_list_layout->name) ? $room->check_list_layout->name : '-'}}</td>
                                        <td class="nk-tb-col nk-tb-col-tools">
                                            <a class="btn btn-trigger btn-icon updateRecordButton" data-locationid="{{$room->id}}" data-locationtype="room" data-bs-toggle="tooltip" data-bs-placement="top" title="Change Layout"><em class="icon ni ni-pen2"></em></a>
                                            {{--                                            <a class="btn btn-trigger btn-icon deleteRecordButton" data-roomid="{{$room->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Room"><em class="icon ni ni-sign-xrp-new-alt"></em></a>--}}
                                        </td>
                                    </tr>
                                @endforeach

                                @foreach($other_locations as $other_location)
                                    <tr>
                                        <td>{{$other_location->name}}</td>
                                        <td>{{$other_location->category}}</td>
                                        <td>{{isset($other_location->check_list_layout->name) ? $other_location->check_list_layout->name : '-'}}</td>
                                        <td class="nk-tb-col nk-tb-col-tools">
                                            <a class="btn btn-trigger btn-icon updateRecordButton" data-locationid="{{$other_location->id}}" data-locationtype="other_location" data-bs-toggle="tooltip" data-bs-placement="top" title="Change Layout" ><em class="icon ni ni-pen2"></em></a>
                                            {{--                                            <a class="btn btn-trigger btn-icon deleteRecordButton" data-roomid="{{$room->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Room"><em class="icon ni ni-sign-xrp-new-alt"></em></a>--}}
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-xxl-4">
                <div class="card card-bordered card-full">
                    <div class="card-inner-group" id="check_list_layout_list">
                        <div class="card-inner">
                            <div class="card-title-group">
                                <div class="card-title">
                                    <h6 class="title">Check List Layouts</h6>
                                </div>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add-checklist_layout">Add</button>
                                </div>
                            </div>
                        </div>
                        @foreach($layout as $layouts)
                            <div class="card-inner card-inner-md">
                                <div class="user-card">
                                    <div class="user-avatar bg-primary-dim">
                                        <span>AB</span>
                                    </div>
                                    <div class="user-info">
                                        <span class="lead-text">{{$layouts->name}}</span>
{{--                                        <span class="sub-text">have {{$layouts->room->count()}} categories</span>--}}
                                    </div>
                                    <div class="user-action">
                                        <div class="drodown">
                                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger me-n1" data-bs-toggle="dropdown" aria-expanded="false"><em class="icon ni ni-more-h"></em></a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <ul class="link-list-opt no-bdr">
                                                    <li><a href="{{route('management/view_housekeeping',[$hotel->id,'layout_id'=>$layouts->id])}}"><em class="icon ni ni-setting"></em><span>Edit Layout</span></a></li>
                                                    <li><a href="{{route('management/view_Janitorial',[$hotel->id,'layout_id'=>$layouts->id])}}"><em class="icon ni ni-setting"></em><span>Customize Janitorial Item</span></a></li>
                                                    <li><a href="{{route('management/view_refilling',[$hotel->id,'layout_id'=>$layouts->id])}}"><em class="icon ni ni-setting"></em><span>Refilling Item</span></a></li>
                                                    {{--                                            <li><a href="#"><em class="icon ni ni-notify"></em><span>Push Notification</span></a></li>--}}
                                                </ul>
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

    <div class="modal hide fade" role="dialog" aria-hidden="true" id="modal-change-layout">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title"> Change Check List Layout</h5>
                </div>
                <div class="modal-body" id="">
                    <form action="{{route('management/edit_location/save')}}" method="post" id="edit_location_save">
                        @csrf
                        <input type="hidden" name="e_location_id" value="" id="e_location_id">
                        {{--                        <input type="hidden" name="edit_user_privilege_id" value="" id="edit_user_privilege_id">--}}
                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
{{--                                            <input type="text" class="form-control" id="e_location_name" name="e_location_name" required>--}}
                                            <label class="form-label" for="email-address-1">Location Name &nbsp;&nbsp;:&nbsp;&nbsp;</label><label id="e_location_name" name="e_location_name"></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <input type="hidden" name="e_location_type" value="" id="e_location_type">
                                            <label class="form-label" for="email-address-1">Location Type &nbsp;&nbsp;:&nbsp;&nbsp;</label><label id="location_type" name="location_type"></label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="full-name">Check List Layout</label>
                                        <div class="form-control-wrap">
                                            <select id="e_checkList_layout" name="e_checkList_layout" class="form-control pl-15" required>
                                                <option value="">--Select Room CheckList Layout - </option>
                                                @foreach($layout as $layouts)
                                                    <option value="{{$layouts->id}}">{{$layouts->name}}</option>
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
                        <button type="button" onclick="$('#edit_location_save').submit();" class="btn btn-lg btn-primary">Save Item</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal hide fade" role="dialog" aria-hidden="true" id="modal-add-checklist_layout">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title"> Add Check List Layout</h5>
                </div>
                <div class="modal-body" id="recipe_ingredient_edit">
                    <form action="{{ route('management/housekeeping_layout/save') }}" method="post" id="add_checkList_layout">
                        @csrf
                        <input type="hidden" value="{{$hotel->id}}" name="hotel_id" id="hotel_id">
                        <div class="row g-4">
                            <div class="row g-4" id="item-row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="email-address-1">Layout Name</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="layout_name" name="layout_name" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12" id="item-row">
                                    <div class="form-group">
                                        <hr>
                                        <label class="form-label" for="email-address-1">Check List Itam</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="item_name-1" name="item_name-1" required="required">
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <button type="button" class="btn btn-dim btn-primary mt-2 " onclick="addrow()">Add Row</button>
                                </div>
                            </div>
                            <hr>
                            <input type="hidden" id="count" name="count" value="1">
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-light">
                    <div class="form-group">
                        <button type="button" class="btn btn-danger btn-lg" data-bs-dismiss="modal">Close</button>
                        <button type="button" onclick="$('#add_checkList_layout').submit();" class="btn btn-lg btn-primary" id="check-list-layout-button">Save Layout</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $('#edit_location_save').on('submit', function(e){

                e.preventDefault();
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

                        if (data.location == 'room'){
                            var action_buton ='<a class="btn btn-trigger btn-icon updateRecordButton" data-locationid="'+data.get_location.id+'" data-locationtype="room" data-bs-toggle="tooltip" data-bs-placement="top" title="Change Layout"><em class="icon ni ni-pen2"></em></a>\n';

                            var table_data = [data.get_location.room_number,data.get_location.room_category.category,data.get_location.check_list_layout!=null?data.get_location.check_list_layout.name:'-',action_buton];

                            // console.log(action_buton)
                        }
                        else{
                            var action_buton ='<a class="btn btn-trigger btn-icon updateRecordButton" data-locationid="'+data.get_location.id+'" data-locationtype="other_location" data-bs-toggle="tooltip" data-bs-placement="top" title="Change Layout"><em class="icon ni ni-pen2"></em></a>\n';

                            var table_data = [data.get_location.name,data.get_location.category,data.get_location.check_list_layout!=null?data.get_location.check_list_layout.name:'-',action_buton];
                        }

                        NioApp.DataTable.row(global_theRowObject).data(table_data).draw(false);

                        $('#modal-change-layout').modal('hide');
                        NioApp.Toast('Successfully Change Layout', 'success',{position: 'top-right'});
                    }
                });
            });
        });
        let global_theRowObject;
        $(document).ready( function () {
            var export_title = $('#CheckList-table').data('export-title') ? $('#CheckList-table').data('export-title') : 'Export';
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
            NioApp.DataTable = $('#CheckList-table').DataTable(attr);
            $.fn.DataTable.ext.pager.numbers_length = 7;
            $('.dt-export-title').text(export_title);

        });

        $("#add_checkList_layout").submit(function(e) {


            e.preventDefault(); // avoid to execute the actual submit of the form.
            var form = $(this);
            var formData = new FormData($(this)[0]);
            var url = form.attr('action');

            var hotel_id =  $('#hotel_id').val();
            var layout_name =  $('#layout_name').val();
            var item_name =  $('#item_name').val();
            if(hotel_id != '' && item_name != '' && layout_name != '') {
                $.ajax({
                    type: "POST",
                    processData: false,
                    contentType: false,
                    url: url,
                    data: formData, // serializes the form's elements.
                    success: function (data) {
                        // $('#add_user_save input:checkbox').prop('checked',false).prop('disabled',true);
                        // $('.handle_disable').prop('disabled',false);
                        // location.reload(); //auto refresh page
                        $(':input', '#add_checkList_layout')
                            .not(':button, :submit, :reset, :hidden')
                            .val('')
                            .prop('selected', false);
                        console.log(data);

                        var category_row = '<div class="card-inner card-inner-md">\n' +
                            '                                <div class="user-card">\n' +
                            '                                    <div class="user-avatar bg-primary-dim">\n' +
                            '                                        <span>AB</span>\n' +
                            '                                    </div>\n' +
                            '                                    <div class="user-info">\n' +
                            '                                        <span class="lead-text">'+data.housekeeping_layout.name+'</span>\n' +
                            '                                    </div>\n' +
                            '                                    <div class="user-action">\n' +
                            '                                        <div class="drodown">\n' +
                            '                                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger me-n1" data-bs-toggle="dropdown" aria-expanded="false"><em class="icon ni ni-more-h"></em></a>\n' +
                            '                                            <div class="dropdown-menu dropdown-menu-end">\n' +
                            '                                                <ul class="link-list-opt no-bdr">\n' +
                            '                                                    <li><a href="{{route('management/view_housekeeping',[$hotel->id])}}?layout_id='+data.housekeeping_layout.id+'"><em class="icon ni ni-setting"></em><span>Edit Layout</span></a></li>\n' +
                            '                                                </ul>\n' +
                            '                                            </div>\n' +
                            '                                        </div>\n' +
                            '                                    </div>\n' +
                            '                                </div>\n' +
                            '                            </div>';

                        $('#check_list_layout_list').append(category_row);

                        var layout_add = '<option value="'+data.housekeeping_layout.id+'">'+data.housekeeping_layout.name+'</option>';
                        $('#e_checkList_layout').append(layout_add);

                        $('#modal-add-checklist_layout').modal('hide');
                        NioApp.Toast('Successfully Add Check List Layout', 'success',{position: 'top-right'});
                    }
                });
            }
            else{
                NioApp.Toast('Required All Fields', 'error', {position: 'top-right'});
            }

        });
        $('#CheckList-table tbody').on('click', 'a', function () {
            if ( $(this).hasClass('updateRecordButton') ) {
                var data = NioApp.DataTable.row($(this).parents('tr')).data(); //Retrieve row data
                var tr = $(this).closest('tr'); //Find DataTables table row
                var theRowObject = NioApp.DataTable.row(tr); //Get DataTables row object
                var location_id = $(this).data('locationid');
                var location_type = $(this).data('locationtype');
                global_theRowObject=theRowObject;
                console.log(data);

                $.ajax({
                    type:'POST',
                    url:'{{ route('management/housekeeping/get_edit_location') }}',
                    headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                    data: {
                        'location_id' : location_id,
                        'location_type' : location_type,
                    },
                    success:function(data){
                        console.log(data);
                        if(location_type == 'room'){
                            $('#e_location_id').val(data.edit_location.id)
                            $('#e_location_name').html(data.edit_location.room_number)
                            $('#location_type').html('Room')
                            $('#e_location_type').val('room')
                            $('#e_checkList_layout').val(data.edit_location.check_list_layout_id).change();
                            $('#modal-change-layout').modal('show');
                        }
                        else {
                            $('#e_location_id').val(data.edit_location.id)
                            $('#e_location_name').html(data.edit_location.name)
                            $('#location_type').html('Other Location')
                            $('#location_type').val('other')
                            $('#e_checkList_layout').val(data.edit_location.check_list_layout_id).change();
                            $('#modal-change-layout').modal('show');
                        }


                    }

                });

            }
        });

        function addrow() {
            var count = parseInt($('#count').val())+1;
            var newrow = '<div class="item-row-bg" id="remove_field_id-'+count+'">\n' +
                '                                    <div class="row g-4">\n' +
                '                                        <div class="col-lg-12">\n' +
                '                                            <div class="form-control-wrap">\n' +
                '                                                <div class="input-group">\n' +
                '                                                    <input type="text" class="form-control" id="item_name-'+count+'" name="item_name-'+count+'" required="required">\n' +
                '                                                    <div class="input-group-append">\n' +
                '                                                        <button class="btn btn-outline-danger btn-dim" onclick="remove_item_field('+count+')">Remove</button>\n' +
                '                                                    </div>\n' +
                '                                                </div>\n' +
                '                                            </div>\n' +
                '                                        </div>\n' +
                '                                    </div>\n' +
                '                                </div>';

            $('#item-row').append(newrow);
            $('#count').val(count);
            NioApp.Select2('.js-select2');
        }

        function remove_item_field(count) {
            $('#remove_field_id-'+count).remove();
        }
    </script>


@endsection

