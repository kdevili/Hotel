@extends('management.lay' )

@section('title' , __(''))

@section('style')

@endsection

@section('content')
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Stock</h3>
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
                                <a href="#" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add-stock-category"><em class="icon ni ni-plus"></em><span>Add Stock Category</span></a>
                            </li>
                            <li class="nk-block-tools-opt d-block d-sm-none">
                                <a href="#" class="btn btn-icon btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add-stock-category"><em class="icon ni ni-plus"></em><span>Stock Category &nbsp;&nbsp;</span></a>
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
                                    <th>Category</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($item_categories as $item_category)
                                    <tr>
                                        <td>{{$item_category->item_category_name}}</td>

                                        <td class="nk-tb-col nk-tb-col-tools">
                                            <a class="btn btn-trigger btn-icon updateRecordButton" data-categoryid="{{$item_category->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Category"><em class="icon ni ni-pen2"></em></a>

                                            <div class="dropdown">
                                                <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown" aria-expanded="false"><em class="icon ni ni-sign-xrp-new-alt" title="Delete Category"></em></a>
                                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs" style="">
                                                    <ul class="link-list-plain">
                                                        <li><a class="deleteRecordButton" data-categoryid="{{$item_category->id}}">Yes</a></li>
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
            </div>

        </div>
    </div>

    <div class="modal hide fade" role="dialog" aria-hidden="true" id="modal-add-stock-category">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title"> Stock Category </h5>
                </div>
                <div class="modal-body" id="recipe_ingredient_edit">
                    <form action="{{ route('management/stock_category/save') }}" method="post" id="add_stock_category">
                        @csrf
                        <input type="hidden" value="{{$hotel->id}}" name="hotel_id_a" id="hotel_id_a">

                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="email-address-1">Category</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="category" name="category" required>
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
                        <button type="button" onclick="$('#add_stock_category').submit();" class="btn btn-lg btn-primary">Save Category</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal hide fade" role="dialog" aria-hidden="true" id="modal-edit-stock-category">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title"> Edit Stock Category</h5>
                </div>
                <div class="modal-body" id="">
                    <form action="{{route('management/stock_category_edit/save')}}" method="post" id="edit_stock_category_save">
                        @csrf
                        <input type="hidden" name="e_category_id" value="" id="e_category_id">

                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="email-address-1">Category</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="e_category" name="e_category" required>
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
                        <button type="button" onclick="$('#edit_stock_category_save').submit();" class="btn btn-lg btn-primary">Save Category</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')
    <script>

        $(document).ready(function(){
            $('#edit_stock_category_save' + '').on('submit', function(e){

                e.preventDefault();
                var form = $(this);
                var formData = new FormData($(this)[0]);
                var url = form.attr('action');

                var category =  $('#e_category').val();

                if(category != '') {
                    $.ajax({
                        type: "POST",
                        processData: false,
                        contentType: false,
                        url: url,
                        data: formData, // serializes the form's elements.
                        success: function (data) {

                            // console.log(data);
                            // var action_buton ='<a class="btn btn-trigger btn-icon updateRecordButton" data-categoryid="'+data.item_categories.id+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Category"><em class="icon ni ni-pen2"></em></a>';

                            var action_buton = '<a class="btn btn-trigger btn-icon updateRecordButton" data-categoryid="'+data.item_categories.id+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Category"><em class="icon ni ni-pen2"></em></a>\n' +
                                '\n' +
                                '                                            <div class="dropdown">\n' +
                                '                                                <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown" aria-expanded="false"><em class="icon ni ni-sign-xrp-new-alt" title="Delete Category"></em></a>\n' +
                                '                                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs" style="">\n' +
                                '                                                    <ul class="link-list-plain">\n' +
                                '                                                        <li><a class="deleteRecordButton" data-categoryid="'+data.item_categories.id+'">Yes</a></li>\n' +
                                '                                                        <li><a>No</a></li>\n' +
                                '                                                    </ul>\n' +
                                '                                                </div>\n' +
                                '                                            </div>';

                            var table_data = [data.item_categories.item_category_name,action_buton];
                            NioApp.DataTable.row(global_theRowObject).data(table_data).draw(false);

                            $('#modal-edit-stock-category').modal('hide');
                            NioApp.Toast('Successfully Edit Category', 'success',{position: 'top-right'});
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

        $("#add_stock_category").submit(function(e) {

            e.preventDefault(); // avoid to execute the actual submit of the form.
            var form = $(this);
            var formData = new FormData($(this)[0]);
            var url = form.attr('action');

            var category =  $('#category').val();

            if(category != '') {
                $.ajax({
                    type: "POST",
                    processData: false,
                    contentType: false,
                    url: url,
                    data: formData, // serializes the form's elements.
                    success: function (data) {
                        // $('#add_user_save input:checkbox').prop('checked',false).prop('disabled',true);
                        // $('.handle_disable').prop('disabled',false);
                        $(':input', '#add_stock_category')
                            .not(':button, :submit, :reset, :hidden')
                            .val('')
                            .prop('selected', false);
                        // console.log(data);
                        // var action_buton ='<a class="btn btn-trigger btn-icon updateRecordButton" data-categoryid="'+data.item_categories.id+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Category"><em class="icon ni ni-pen2"></em></a>';

                        var action_buton = '<a class="btn btn-trigger btn-icon updateRecordButton" data-categoryid="'+data.item_categories.id+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Category"><em class="icon ni ni-pen2"></em></a>\n' +
                            '\n' +
                            '                                            <div class="dropdown">\n' +
                            '                                                <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown" aria-expanded="false"><em class="icon ni ni-sign-xrp-new-alt" title="Delete Category"></em></a>\n' +
                            '                                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs" style="">\n' +
                            '                                                    <ul class="link-list-plain">\n' +
                            '                                                        <li><a class="deleteRecordButton" data-categoryid="'+data.item_categories.id+'">Yes</a></li>\n' +
                            '                                                        <li><a>No</a></li>\n' +
                            '                                                    </ul>\n' +
                            '                                                </div>\n' +
                            '                                            </div>';
                        var table_data = [data.item_categories.item_category_name,action_buton];
                        NioApp.DataTable.row.add(table_data);
                        NioApp.DataTable.draw()

                        $('#modal-add-stock-category').modal('hide');
                        NioApp.Toast('Successfully Add Stock Category', 'success',{position: 'top-right'});
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
                var categoryid = $(this).data('categoryid');
                global_theRowObject=theRowObject;
                console.log(data);
                $.ajax({
                    type:'POST',
                    url:'{{ route('management/stock_category_get_edit_details') }}',
                    headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                    data: {
                        'categoryid' : categoryid,
                    },
                    success:function(data){
                        console.log(data);
                        $('#e_category_id').val(data.edit_category.id);
                        $('#e_category').val(data.edit_category.item_category_name);

                        $('#modal-edit-stock-category').modal('show');
                    }
                });

            }
            if ( $(this).hasClass('deleteRecordButton') ) {
                var data = NioApp.DataTable.row($(this).parents('tr')).data(); //Retrieve row data
                var tr = $(this).closest('tr'); //Find DataTables table row
                var theRowObject = NioApp.DataTable.row(tr); //Get DataTables row object
                var categoryid = $(this).data('categoryid');
                // global_theRowObject2=theRowObject;
                $.ajax({
                    type:'POST',
                    url:'{{ route('management/stock_category/delete') }}',
                    headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                    data: {
                        'categoryid' : categoryid,
                    },
                    success:function(data){
                        if(data.success){
                            NioApp.Toast('Successfully Deleted Stock Category', 'success',{position: 'top-right'});
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

