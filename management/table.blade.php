@extends('management.lay' )

@section('title' , __(''))

@section('style')

@endsection

@section('content')
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Tables</h3>
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
                                <a href="#" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add-table"><em class="icon ni ni-plus"></em><span>Add Tables</span></a>
                            </li>
                            <li class="nk-block-tools-opt d-block d-sm-none">
                                <a href="#" class="btn btn-icon btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add-table"><em class="icon ni ni-plus"></em><span>Tables &nbsp;&nbsp;</span></a>
                            </li>
                        </ul>
                    </div>
                </div><!-- .toggle-wrap -->
            </div><!-- .nk-block-head-content -->
        </div><!-- .nk-block-between -->
    </div>

    <div class="nk-block">
        <div class="row">
            <div class="col-md-12 col-xxl-12">
                <div class="nk-block">
                    <div class="card card-bordered card-preview">
                        <div class="card-inner">

                            <table class="datatable-init-export nowrap table" data-export-title="Export" id="Room-table">
                                <thead>
                                <tr>
                                    <th>Table Name</th>
                                    <th>Number of Chairs</th>
                                    <th>Area</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($tables as $table)
                                    <tr>
                                        <td>{{$table->table_name}}</td>
                                        <td>{{$table->nu_of_chairs}}</td>
                                        <td>{{$table->area}}</td>
                                        <td class="nk-tb-col nk-tb-col-tools">
                                            <a class="btn btn-trigger btn-icon updateRecordButton" data-tableid="{{$table->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Table"><em class="icon ni ni-pen2"></em></a>

{{--                                            <div class="dropdown">--}}
{{--                                                <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown" aria-expanded="false"><em class="icon ni ni-sign-xrp-new-alt" title="Delete Table"></em></a>--}}
{{--                                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs" style="">--}}
{{--                                                    <ul class="link-list-plain">--}}
{{--                                                        <li><a class="deleteRecordButton" data-tableid="{{$table->id}}">Yes</a></li>--}}
{{--                                                        <li><a>No</a></li>--}}
{{--                                                    </ul>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="modal hide fade" role="dialog" aria-hidden="true" id="modal-add-table">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title"> Add Table</h5>
                </div>
                <div class="modal-body" id="recipe_ingredient_edit">
                    <form action="{{ route('management/table/save') }}" method="post" id="add_table">
                        @csrf
                        <input type="hidden" value="{{$hotel->id}}" name="hotel_id_a" id="hotel_id_a">
                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="email-address-1">Table Name</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="table_name" name="table_name" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="email-address-1">Number of Chairs</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="nu_of_chairs" name="nu_of_chairs" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="full-name">Area</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="area" name="area" required>
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
                        <button type="button" onclick="$('#add_table').submit();" class="btn btn-lg btn-primary">Save Table</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal hide fade" role="dialog" aria-hidden="true" id="modal-edit-table">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title"> Edit Table</h5>
                </div>
                <div class="modal-body" id="">
                    <form action="{{route('management/table_edit/save')}}" method="post" id="edit_other-table_save">
                        @csrf
                        <input type="hidden" name="e_table_id" value="" id="e_table_id">

                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="email-address-1">Table Name</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="e_table_name" name="e_table_name" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="email-address-1">Number of Chairs</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="e_nu_of_chairs" name="e_nu_of_chairs" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="full-name">Area</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="e_area" name="e_area" required>
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
                        <button type="button" onclick="$('#edit_other-table_save').submit();" class="btn btn-lg btn-primary">Save Table</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')
    <script>

        $(document).ready(function(){
            $('#edit_other-table_save').on('submit', function(e){

                e.preventDefault();
                var form = $(this);
                var formData = new FormData($(this)[0]);
                var url = form.attr('action');

                var table_name =  $('#e_table_name').val();
                var nu_of_chairs =  $('#e_nu_of_chairs').val();
                var area =  $('#e_area').val()

                if(table_name != '' && nu_of_chairs != '' && area != ''){
                    $.ajax({
                        type: "POST",
                        processData: false,
                        contentType: false,
                        url: url,
                        data: formData, // serializes the form's elements.
                        success: function (data) {

                            console.log(data);
                            // var action_buton ='<a class="btn btn-trigger btn-icon updateRecordButton" data-tableid="'+data.table.id+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Location"><em class="icon ni ni-pen2"></em></a>\n' +
                            //     '\n' +
                            //     '                                            <div class="dropdown">\n' +
                            //     '                                                <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown" aria-expanded="false"><em class="icon ni ni-sign-xrp-new-alt" title="Delete Location"></em></a>\n' +
                            //     '                                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs" style="">\n' +
                            //     '                                                    <ul class="link-list-plain">\n' +
                            //     '                                                        <li><a class="deleteRecordButton" data-tableid="'+data.table.id+'">Yes</a></li>\n' +
                            //     '                                                        <li><a>No</a></li>\n' +
                            //     '                                                    </ul>\n' +
                            //     '                                                </div>\n' +
                            //     '                                            </div>';

                            var action_buton ='<a class="btn btn-trigger btn-icon updateRecordButton" data-tableid="'+data.table.id+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Table"><em class="icon ni ni-pen2"></em></a>';
                            var table_data = [data.table.table_name,data.table.nu_of_chairs,data.table.area,action_buton];
                            NioApp.DataTable.row(global_theRowObject).data(table_data).draw(false);

                            $('#modal-edit-table').modal('hide');
                            NioApp.Toast('Successfully Edit Table', 'success',{position: 'top-right'});
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
            var export_title = $('#Room-table').data('export-title') ? $('#Room-table').data('export-title') : 'Export';
            var attr = {
                "order": [[0, "asc"]],
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
            NioApp.DataTable = $('#Room-table').DataTable(attr);
            $.fn.DataTable.ext.pager.numbers_length = 7;
            $('.dt-export-title').text(export_title);

        });

        $("#add_table").submit(function(e) {

            e.preventDefault(); // avoid to execute the actual submit of the form.
            var form = $(this);
            var formData = new FormData($(this)[0]);
            var url = form.attr('action');

            var table_name =  $('#table_name').val();
            var nu_of_chairs =  $('#nu_of_chairs').val();
            var area =  $('#area').val()

            if(table_name != '' && nu_of_chairs != '' && area != ''){
                $.ajax({
                    type: "POST",
                    processData: false,
                    contentType: false,
                    url: url,
                    data: formData, // serializes the form's elements.
                    success: function (data) {
                        // $('#add_user_save input:checkbox').prop('checked',false).prop('disabled',true);
                        // $('.handle_disable').prop('disabled',false);
                        $(':input', '#add_table')
                            .not(':button, :submit, :reset, :hidden')
                            .val('')
                            .prop('selected', false);
                        console.log(data);
                        // var action_buton ='<a class="btn btn-trigger btn-icon updateRecordButton" data-tableid="'+data.table.id+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Location"><em class="icon ni ni-pen2"></em></a>\n' +
                        //     '\n' +
                        //     '                                            <div class="dropdown">\n' +
                        //     '                                                <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown" aria-expanded="false"><em class="icon ni ni-sign-xrp-new-alt" title="Delete Location"></em></a>\n' +
                        //     '                                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs" style="">\n' +
                        //     '                                                    <ul class="link-list-plain">\n' +
                        //     '                                                        <li><a class="deleteRecordButton" data-tableid="'+data.table.id+'">Yes</a></li>\n' +
                        //     '                                                        <li><a>No</a></li>\n' +
                        //     '                                                    </ul>\n' +
                        //     '                                                </div>\n' +
                        //     '                                            </div>';

                        var action_buton ='<a class="btn btn-trigger btn-icon updateRecordButton" data-tableid="'+data.table.id+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Table"><em class="icon ni ni-pen2"></em></a>';

                        var table_data = [data.table.table_name,data.table.nu_of_chairs,data.table.area,action_buton];
                        NioApp.DataTable.row.add(table_data);
                        NioApp.DataTable.draw()

                        $('#modal-add-table').modal('hide');
                        NioApp.Toast('Successfully Add Table', 'success',{position: 'top-right'});
                    }
                });
            }
            else{
                NioApp.Toast('Required All Fields', 'error', {position: 'top-right'});
            }

        });

        $('#Room-table tbody').on('click', 'a', function () {
            if ( $(this).hasClass('updateRecordButton') ) {
                var data = NioApp.DataTable.row($(this).parents('tr')).data(); //Retrieve row data
                var tr = $(this).closest('tr'); //Find DataTables table row
                var theRowObject = NioApp.DataTable.row(tr); //Get DataTables row object
                var table_id = $(this).data('tableid');
                global_theRowObject=theRowObject;
                console.log(data);
                $.ajax({
                    type:'POST',
                    url:'{{ route('management/table_get_edit_details') }}',
                    headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                    data: {
                        'table_id' : table_id,
                    },
                    success:function(data){
                        console.log(data);
                        $('#e_table_id').val(data.edit_table.id);
                        $('#e_table_name').val(data.edit_table.table_name);
                        $('#e_nu_of_chairs').val(data.edit_table.nu_of_chairs);
                        $('#e_area').val(data.edit_table.area);

                        $('#modal-edit-table').modal('show');
                    }
                });

            }
            {{--if ( $(this).hasClass('deleteRecordButton') ) {--}}
            {{--    var data = NioApp.DataTable.row($(this).parents('tr')).data(); //Retrieve row data--}}
            {{--    var tr = $(this).closest('tr'); //Find DataTables table row--}}
            {{--    var theRowObject = NioApp.DataTable.row(tr); //Get DataTables row object--}}
            {{--    var location_id = $(this).data('locationid');--}}
            {{--    // global_theRowObject2=theRowObject;--}}
            {{--    $.ajax({--}}
            {{--        type:'POST',--}}
            {{--        url:'{{ route('management/other_location/delete') }}',--}}
            {{--        headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},--}}
            {{--        data: {--}}
            {{--            'location_id' : location_id,--}}
            {{--        },--}}
            {{--        success:function(data){--}}
            {{--            if(data.success){--}}
            {{--                NioApp.Toast('Successfully Deleted Location', 'success',{position: 'top-right'});--}}
            {{--                NioApp.DataTable.row(theRowObject).remove().draw();--}}
            {{--            }else{--}}
            {{--                NioApp.Toast(data.error, 'warning',{position: 'top-right'});--}}
            {{--            }--}}
            {{--        }--}}

            {{--    });--}}
            {{--}--}}
        });

    </script>


@endsection


