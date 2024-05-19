@extends('management.lay' )

@section('title' , __(''))

@section('style')

@endsection

@section('content')
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Other Sale</h3>
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
                                <a href="#" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add-other-income"><em class="icon ni ni-plus"></em><span>Add Other Income Category</span></a>
                            </li>
                            <li class="nk-block-tools-opt d-none d-sm-block">
                                <a href="#" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add-other-income-cash"><em class="icon ni ni-plus"></em><span>Add Other Income Cash Book</span></a>
                            </li>
                            <li class="nk-block-tools-opt d-block d-sm-none">
                                <a href="#" class="btn btn-icon btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add-other-income"><em class="icon ni ni-plus"></em><span>Other Income &nbsp;&nbsp;</span></a>
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
                <div class="nk-block">
                    <div class="card card-bordered card-preview">
                        <div class="card-inner">

                            <table class="datatable-init-export nowrap table" data-export-title="Export" id="Room-table">
                                <thead>
                                <tr>
                                    <th>Category Name</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($other_income_category_lists as $other_income_category_list)
                                    <tr>
                                        <td>{{$other_income_category_list->category_name}}</td>

                                        <td class="nk-tb-col nk-tb-col-tools">
                                            <a class="btn btn-trigger btn-icon updateRecordButton" data-otherIncomeid="{{$other_income_category_list->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit other income"><em class="icon ni ni-pen2"></em></a>

                                            <div class="dropdown">
                                                <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown" aria-expanded="false"><em class="icon ni ni-sign-xrp-new-alt" title="Delete other income"></em></a>
                                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs" style="">
                                                    <ul class="link-list-plain">
                                                        <li><a class="deleteRecordButton" data-otherIncomeid="{{$other_income_category_list->id}}">Yes</a></li>
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


            <div class="col-md-4 col-xxl-4">
                <div class="card card-bordered card-full">
                    <div class="card-inner-group"  id="category_list">
                        <div class="card-inner">
                            <div class="card-title-group">
                                <div class="card-title">
                                    <h6 class="title">Other Income Select Cash Book</h6>
                                </div>
                            </div>
                        </div>
                        @php($books = \App\Cashbook::select('id', 'name', 'hotel_id')->get())

                        <form action="{{route('management/assign_cash/update')}}" method="post" id="assign_cash_save">
                            @csrf
                        <div class="card-inner card-inner-md">
                            <div class="form-group">
                                <label class="form-label" for="email-address-1">Cash</label>
                                <div class="form-control-wrap">
                                    <div class="form-control-select">
                                        <select class="form-control" id="assign_cash_book_id" name="assign_cash_book_id" required>
                                            <option value="default_option"> Cash </option>
                                            @foreach($books as $book)

                                                <option value="{{$book->id}}">{{$book->name}} </option>

                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="email-address-1">Cheque</label>
                                <div class="form-control-wrap">
                                    <div class="form-control-select">
                                        <select class="form-control" id="assign_cheque_book_id" name="assign_cheque_book_id" required>
                                            <option value="default_option"> Cheque </option>
                                            @foreach($books as $book)
                                                <option value="{{$book->id}}">{{$book->name}} </option>
                                            @endforeach


                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="email-address-1">Card</label>
                                <div class="form-control-wrap">
                                    <div class="form-control-select">
                                        <select class="form-control" id="assign_card_book_id" name="assign_card_book_id" required>
                                            <option value="default_option"> Card </option>
                                            @foreach($books as $book)
                                                <option value="{{$book->id}}">{{$book->name}} </option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        </form>
                    </div>
                    <div class="modal-footer bg-light">
                        <div class="form-group">

                            <button type="button" onclick="$('#assign_cash_save').submit();" class="btn btn-lg btn-primary">Save Cash Book</button>
                        </div>
                    </div>

                </div>
            </div><!-- .card -->


        </div>
    </div>










    <div class="modal hide fade" role="dialog" aria-hidden="true" id="modal-add-other-income">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title"> Add Other Income Category</h5>
                </div>
                <div class="modal-body" id="recipe_ingredient_edit">
                    <form action="{{ route('management/other_income_category/save') }}" method="post" id="add_other_income">
                        @csrf
                        <input type="hidden" value="{{$hotel->id}}" name="hotel_id_a" id="hotel_id_a">
                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="email-address-1">Other Income Category Name</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="other_income_name" name="other_income_name" required>
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
                        <button type="button" onclick="$('#add_other_income').submit();" class="btn btn-lg btn-primary">Save Category</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal hide fade" role="dialog" aria-hidden="true" id="modal-add-other-income-cash">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title"> Add Other Income Category</h5>
                </div>
                <div class="modal-body" id="recipe_ingredient_edit">
                    <form action="{{ route('management/other_income_cashbook/save') }}" method="post" id="add-other-income-cash">
                        @csrf
                        <input type="hidden" value="{{$hotel->id}}" name="hotel_id_a" id="hotel_id_a">
                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        @php($adbooks = \App\Cashbook::select('id', 'name', 'hotel_id')->get())
                                        <label class="form-label" for="email-address-1">Other Income Cash Book  Name</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="add_cash_book_name" name="add_cash_book_name" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="email-address-1">Other Income Cash Book  Name</label>
                                        <div class="form-control-wrap">
                                            <select class="form-control" id="add_cash_book_id" name="add_cash_book_id" required>
                                                <option value="default_option"> Cheque </option>
                                                @foreach($adbooks as $adbook)
                                                    <option value="{{$adbook->id}}">{{$adbook->name}} </option>
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
                        <button type="button" onclick="$('#add-other-income-cash').submit();" class="btn btn-lg btn-primary">Save Cash Book</button>
                    </div>
                </div>
            </div>
        </div>
    </div>






























    <div class="modal hide fade" role="dialog" aria-hidden="true" id="modal-edit-other-income">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title"> Edit Other Location</h5>
                </div>
                <div class="modal-body" id="">
                    <form action="{{route('management/edit_other_income_category/save')}}" method="post" id="edit_other_income_save">
                        @csrf
                        <input type="hidden" name="e_other_income_id" value="" id="e_other_income_id">

                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="email-address-1">Other Income Category Name</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="edit_other_income_name" name="edit_other_income_name" required>
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
                        <button type="button" onclick="$('#edit_other_income_save').submit();" class="btn btn-lg btn-primary">Save Category</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')
    <script>

        $(document).ready(function(){
            $('#edit_other_income_save').on('submit', function(e){

                e.preventDefault();
                var form = $(this);
                var formData = new FormData($(this)[0]);
                var url = form.attr('action');

                var other_income_name =  $('#edit_other_income_name').val();
                if(other_income_name != '') {
                    $.ajax({
                        type: "POST",
                        processData: false,
                        contentType: false,
                        url: url,
                        data: formData, // serializes the form's elements.
                        success: function (data) {
                            // $('#add_user_save input:checkbox').prop('checked',false).prop('disabled',true);
                            // $('.handle_disable').prop('disabled',false);
                            $(':input', '#edit_other_income_save')
                                .not(':button, :submit, :reset, :hidden')
                                .val('')
                                .prop('selected', false);
                            console.log(data);
                            var action_buton = '<td class="nk-tb-col nk-tb-col-tools">\n' +
                                '                                            <a class="btn btn-trigger btn-icon updateRecordButton" data-otherIncomeid="'+data.other_income_category_list.id+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit other income"><em class="icon ni ni-pen2"></em></a>\n' +
                                '\n' +
                                '                                            <div class="dropdown">\n' +
                                '                                                <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown" aria-expanded="false"><em class="icon ni ni-sign-xrp-new-alt" title="Delete other income"></em></a>\n' +
                                '                                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs" style="">\n' +
                                '                                                    <ul class="link-list-plain">\n' +
                                '                                                        <li><a class="deleteRecordButton" data-otherIncomeid="'+data.other_income_category_list.id+'">Yes</a></li>\n' +
                                '                                                        <li><a>No</a></li>\n' +
                                '                                                    </ul>\n' +
                                '                                                </div>\n' +
                                '                                            </div>\n' +
                                '\n' +
                                '                                        </td>' ;

                            var table_data = [data.other_income_category_list.category_name,action_buton];
                            NioApp.DataTable.row(global_theRowObject).data(table_data).draw(false);

                            $('#modal-edit-other-income').modal('hide');
                            NioApp.Toast('Successfully Edit Other Income Categor', 'success',{position: 'top-right'});
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

        $("#add_other_income").submit(function(e) {

            e.preventDefault(); // avoid to execute the actual submit of the form.
            var form = $(this);
            var formData = new FormData($(this)[0]);
            var url = form.attr('action');

            var other_income_name =  $('#other_income_name').val();
            if(other_income_name != '') {
                $.ajax({
                    type: "POST",
                    processData: false,
                    contentType: false,
                    url: url,
                    data: formData, // serializes the form's elements.
                    success: function (data) {
                        // $('#add_user_save input:checkbox').prop('checked',false).prop('disabled',true);
                        // $('.handle_disable').prop('disabled',false);
                        $(':input', '#add_other_income')
                            .not(':button, :submit, :reset, :hidden')
                            .val('')
                            .prop('selected', false);
                        console.log(data);
                        var action_buton = '<td class="nk-tb-col nk-tb-col-tools">\n' +
                            '                                            <a class="btn btn-trigger btn-icon updateRecordButton" data-otherIncomeid="'+data.other_income_category_list.id+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit other income"><em class="icon ni ni-pen2"></em></a>\n' +
                            '\n' +
                            '                                            <div class="dropdown">\n' +
                            '                                                <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown" aria-expanded="false"><em class="icon ni ni-sign-xrp-new-alt" title="Delete other income"></em></a>\n' +
                            '                                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs" style="">\n' +
                            '                                                    <ul class="link-list-plain">\n' +
                            '                                                        <li><a class="deleteRecordButton" data-otherIncomeid="'+data.other_income_category_list.id+'">Yes</a></li>\n' +
                            '                                                        <li><a>No</a></li>\n' +
                            '                                                    </ul>\n' +
                            '                                                </div>\n' +
                            '                                            </div>\n' +
                            '\n' +
                            '                                        </td>' ;

                        var table_data = [data.other_income_category_list.category_name,action_buton];
                        {{--// // console.log(table_data);--}}
                        {{--// //--}}
                        NioApp.DataTable.row.add(table_data);
                        NioApp.DataTable.draw()

                        $('#modal-add-other-income').modal('hide');
                        NioApp.Toast('Successfully Add Other Income Category', 'success',{position: 'top-right'});
                    }
                });
            }
            else{
                NioApp.Toast('Required All Fields', 'error', {position: 'top-right'});
            }

        });

        $("#assign_cash_save").submit(function (e) {
            e.preventDefault();

            var form = $(this);
            var url = form.attr('action');
            var formData = form.serialize(); // Use serialize instead of FormData

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                success: function (data) {
                    console.log(data);
                    NioApp.Toast('Successfully Edit Cash book', 'success', { position: 'top-right' });
                }
            });
        });


        $("#add-other-income-cash").submit(function (e) {
            e.preventDefault();

            var form = $(this);
            var url = form.attr('action');
            var formData = form.serialize(); // Use serialize instead of FormData

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                success: function (data) {
                    console.log(data);
                    NioApp.Toast('Successfully Add Cash book', 'success', { position: 'top-right' });
                }
            });
        });













        $('#Room-table tbody').on('click', 'a', function () {
            if ( $(this).hasClass('updateRecordButton') ) {
                var data = NioApp.DataTable.row($(this).parents('tr')).data(); //Retrieve row data
                var tr = $(this).closest('tr'); //Find DataTables table row
                var theRowObject = NioApp.DataTable.row(tr); //Get DataTables row object
                var otherIncomeid = $(this).attr('data-otherIncomeid');
                global_theRowObject=theRowObject;
                console.log(data);

                $.ajax({
                    type:'POST',
                    url:'{{ route('management/other_income_get_edit_details') }}',
                    headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                    data: {
                        'otherIncomeid' : otherIncomeid,
                    },
                    success:function(data){
                        console.log(data);
                        $('#e_other_income_id').val(data.other_income_category_list.id);
                        $('#edit_other_income_name').val(data.other_income_category_list.category_name);

                        $('#modal-edit-other-income').modal('show');
                    }
                });

            }
            if ( $(this).hasClass('deleteRecordButton') ) {
                var data = NioApp.DataTable.row($(this).parents('tr')).data(); //Retrieve row data
                var tr = $(this).closest('tr'); //Find DataTables table row
                var theRowObject = NioApp.DataTable.row(tr); //Get DataTables row object
                var otherIncomeid = $(this).attr('data-otherIncomeid');

                $.ajax({
                    type:'POST',
                    url:'{{ route('management/other_income/delete') }}',
                    headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                    data: {
                        'otherIncomeid' : otherIncomeid,
                    },
                    success:function(data){
                        if(data.success){
                            NioApp.Toast('Successfully Deleted Other Income', 'success',{position: 'top-right'});
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


