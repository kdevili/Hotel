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

                            <li class="nk-block-tools-opt d-none d-sm-block">
                                <a href="#" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-edit-layoutName"><em class="icon ni ni-pen2"></em><span>Change Layout Name</span></a>
                            </li>
                            <li class="nk-block-tools-opt d-none d-sm-block">
                                <a href="#" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add-checklist"><em class="icon ni ni-plus"></em><span>Add Check List Items</span></a>
                            </li>
                            <li class="nk-block-tools-opt d-none d-sm-block">
                                <a href="{{ route('management/view_housekeeping_layout',$hotel->id) }}"  class="btn btn-primary"><em class="icon ni ni-caret-left-fill"></em><span>Back</span></a>
                            </li>

                            <li class="nk-block-tools-opt d-block d-sm-none">
                                <a href="{{ route('management/view_housekeeping_layout',$hotel->id) }}"  class="btn btn-primary"><em class="icon ni ni-caret-left-fill"></em></a>
                                <a href="#" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-edit-layoutName"><em class="icon ni ni-pen2"></em><span>Layout Name</span></a>
                                <a href="#" class="btn btn-icon btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add-checklist"><em class="icon ni ni-plus"></em><span>List Items&nbsp;&nbsp;</span></a>
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
                <div class="row g-4">
                    <div class="row g-4" id="">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label" for="email-address-1">Layout Name &nbsp;&nbsp;:&nbsp;&nbsp;</label>
                                <span id="layout_name">{{$layout->name}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <table class="datatable-init-export nowrap table" data-export-title="Export" id="CheckList-table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($item as $items)
                        <tr>
                            <td>{{$items->item_name}}</td>
                            <td class="nk-tb-col nk-tb-col-tools">
                                <a class="btn btn-trigger btn-icon updateRecordButton" data-itemid="{{$items->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Housekeeping Item"><em class="icon ni ni-pen2"></em></a>
{{--                                <a class="btn btn-trigger btn-icon deleteRecordButton" data-itemid="{{$items->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Housekeeping Item"><em class="icon ni ni-sign-xrp-new-alt"></em></a>--}}

                                <div class="dropdown">
                                    <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown" aria-expanded="false" title="Delete Housekeeping Item"><em class="icon ni ni-sign-xrp-new-alt"></em></a>
                                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs" style="">
                                        <ul class="link-list-plain">
                                            <li><a class="deleteRecordButton" data-itemid="{{$items->id}}">Yes</a></li>
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

    <div class="modal hide fade" role="dialog" aria-hidden="true" id="modal-add-checklist">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title"> Add Check List Item</h5>
                </div>
                <div class="modal-body" id="recipe_ingredient_edit">
                    <form action="{{ route('management/housekeeping/save') }}" method="post" id="add_checkListItem" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="{{$hotel->id}}" name="hotel_id_a" id="hotel_id_a">
                        <input type="hidden" value="{{$layout->id}}" name="layout_id_a" id="layout_id_a">
                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="email-address-1">Item Name</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="item_name" name="item_name" required>
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
                        <button type="button" onclick="$('#add_checkListItem').submit();" class="btn btn-lg btn-primary">Save Item</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal hide fade" role="dialog" aria-hidden="true" id="modal-edit-checkList">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title"> Edit Check List Item</h5>
                </div>
                <div class="modal-body" id="">
                    <form action="{{route('management/edit_checklist/save')}}" method="post" id="edit_item_save">
                        @csrf
                        <input type="hidden" name="e_item_id" value="" id="e_item_id">
                        {{--                        <input type="hidden" name="edit_user_privilege_id" value="" id="edit_user_privilege_id">--}}
                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="email-address-1">Item Name</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="e_item_name" name="e_item_name" required>
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
                        <button type="button" onclick="$('#edit_item_save').submit();" class="btn btn-lg btn-primary">Save Item</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal hide fade" role="dialog" aria-hidden="true" id="modal-edit-layoutName">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title"> Edit Check List Layout Name</h5>
                </div>
                <div class="modal-body" id="">
                    <form action="{{route('management/edit_layout_name/save')}}" method="post" id="edit_layoutName_save">
                        @csrf
                        <input type="hidden" name="e_layout_id" value="{{$layout->id}}" id="e_layout_id">
                        {{--                        <input type="hidden" name="edit_user_privilege_id" value="" id="edit_user_privilege_id">--}}
                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="email-address-1">Layout Name</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="e_layout_name" name="e_layout_name" value="{{$layout->name}}" required>
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
                        <button type="button" onclick="$('#edit_layoutName_save').submit();" class="btn btn-lg btn-primary">Save Name</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $('#edit_item_save').on('submit', function(e){

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
                    var action_buton = '<a class="btn btn-trigger btn-icon updateRecordButton" data-itemid="'+data.get_item.id+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Housekeeping Item"><em class="icon ni ni-pen2"></em></a>\n' +
                        '\n' +
                        '                                <div class="dropdown">\n' +
                        '                                    <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown" aria-expanded="false" title="Delete Housekeeping Item"><em class="icon ni ni-sign-xrp-new-alt"></em></a>\n' +
                        '                                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs" style="">\n' +
                        '                                        <ul class="link-list-plain">\n' +
                        '                                            <li><a class="deleteRecordButton" data-itemid="'+data.get_item.id+'">Yes</a></li>\n' +
                        '                                            <li><a>No</a></li>\n' +
                        '                                        </ul>\n' +
                        '                                    </div>\n' +
                        '                                </div>';
                    // var action_buton ='<a class="btn btn-trigger btn-icon updateRecordButton" data-itemid="'+data.get_item.id+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Restaurant"><em class="icon ni ni-pen2"></em></a>\n' +
                    //     '              <a class="btn btn-trigger btn-icon deleteRecordButton" data-itemid="'+data.get_item.id+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Restaurant"><em class="icon ni ni-sign-xrp-new-alt"></em></a>';
                    var table_data = [data.get_item.item_name,action_buton];
                    NioApp.DataTable.row(global_theRowObject).data(table_data).draw(false);

                    $('#modal-edit-checkList').modal('hide');
                    NioApp.Toast('Successfully Edit Check List Item', 'success',{position: 'top-right'});
                }
            });
        });
        });

        $(document).ready(function(){
            $('#edit_layoutName_save').on('submit', function(e){

                e.preventDefault();
                var form = $(this);
                var formData = new FormData($(this)[0]);
                var url = form.attr('action');

                var e_layout_id =  $('#e_layout_id').val();
                var e_layout_name =  $('#e_layout_name').val();
                if(e_layout_id != '' && e_layout_name != '') {
                    $.ajax({
                        type: "POST",
                        processData: false,
                        contentType: false,
                        url: url,
                        data: formData, // serializes the form's elements.
                        success: function (data) {

                            console.log(data);
                            $('#layout_name').html(data.get_layout.name);
                            $('#modal-edit-layoutName').modal('hide');
                            NioApp.Toast('Successfully Edit Layout Name', 'success',{position: 'top-right'});
                        }
                    });
                }
                else{
                    NioApp.Toast('Required All Fields', 'error', {position: 'top-right'});
                }
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

        $("#add_checkListItem").submit(function(e) {

            e.preventDefault(); // avoid to execute the actual submit of the form.
            var form = $(this);
            var formData = new FormData($(this)[0]);
            var url = form.attr('action');

            var hotel_id =  $('#hotel_id_a').val();
            var item_name =  $('#item_name').val();
            if(hotel_id != '' && item_name != '') {
                $.ajax({
                    type: "POST",
                    processData: false,
                    contentType: false,
                    url: url,
                    data: formData, // serializes the form's elements.
                    success: function (data) {
                        // $('#add_user_save input:checkbox').prop('checked',false).prop('disabled',true);
                        // $('.handle_disable').prop('disabled',false);
                        $(':input', '#add_checkListItem')
                            .not(':button, :submit, :reset, :hidden')
                            .val('')
                            .prop('selected', false);
                        console.log(data);
                        var action_buton = '<a class="btn btn-trigger btn-icon updateRecordButton" data-itemid="'+data.housekeeping.id+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Housekeeping Item"><em class="icon ni ni-pen2"></em></a>\n' +
                            '\n' +
                            '                                <div class="dropdown">\n' +
                            '                                    <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown" aria-expanded="false" title="Delete Housekeeping Item"><em class="icon ni ni-sign-xrp-new-alt"></em></a>\n' +
                            '                                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs" style="">\n' +
                            '                                        <ul class="link-list-plain">\n' +
                            '                                            <li><a class="deleteRecordButton" data-itemid="'+data.housekeeping.id+'">Yes</a></li>\n' +
                            '                                            <li><a>No</a></li>\n' +
                            '                                        </ul>\n' +
                            '                                    </div>\n' +
                            '                                </div>';
                        // var action_buton ='<a class="btn btn-trigger btn-icon updateRecordButton" data-itemid="'+data.housekeeping.id+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Restaurant"><em class="icon ni ni-pen2"></em></a>\n' +
                        //     '              <a class="btn btn-trigger btn-icon deleteRecordButton" data-itemid="'+data.housekeeping.id+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Restaurant"><em class="icon ni ni-sign-xrp-new-alt"></em></a>';
                        var table_data = [data.housekeeping.item_name,action_buton];
                        {{--// // console.log(table_data);--}}
                        {{--// //--}}
                        NioApp.DataTable.row.add(table_data);
                        NioApp.DataTable.draw()

                        $('#modal-add-checklist').modal('hide');
                        NioApp.Toast('Successfully Add Check List Item', 'success',{position: 'top-right'});
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
                    var item_id = $(this).data('itemid');
                    global_theRowObject=theRowObject;
                    console.log(data);

                    $.ajax({
                        type:'POST',
                        url:'{{ route('management/housekeeping/get_edit_checklist_details') }}',
                        headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                        data: {
                            'item_id' : item_id,
                        },
                        success:function(data){
                            console.log(data);
                            $('#e_item_id').val(data.edit_item.id)
                            $('#e_item_name').val(data.edit_item.item_name)

                            $('#modal-edit-checkList').modal('show');

                        }

                    });

                }
                if ( $(this).hasClass('deleteRecordButton') ) {
                    var data = NioApp.DataTable.row($(this).parents('tr')).data(); //Retrieve row data
                    var tr = $(this).closest('tr'); //Find DataTables table row
                    var theRowObject = NioApp.DataTable.row(tr); //Get DataTables row object
                    var item_id = $(this).data('itemid');
                    // global_theRowObject2=theRowObject;
                    $.ajax({
                        type:'POST',
                        url:'{{ route('management/item/delete') }}',
                        headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                        data: {
                            'item_id' : item_id,
                        },
                        success:function(data){
                            if(data.success){
                                NioApp.Toast('Successfully Deleted Check List Item', 'success',{position: 'top-right'});
                                NioApp.DataTable.row(theRowObject).remove().draw();
                            }else{
                                NioApp.Toast(data.error, 'warning',{position: 'top-right'});
                            }
                        }

                    });
                }
            });


    </script>


@endsection
