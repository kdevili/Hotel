@extends('management.lay' )

@section('title' , __(''))

@section('style')

@endsection

@section('content')
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Expenses</h3>
                <div class="nk-block-des text-soft">
                    <p>You in <span class="text-warning">{{$hotel->hotel_chain->name}}</span>  <em class="icon ni ni-forward-arrow-fill"></em> <span class="text-success">{{$hotel->hotel_name}}</span></p>
                </div>
            </div><!-- .nk-block-head-content -->
            <div class="nk-block-head-content">
                <div class="toggle-wrap nk-block-tools-toggle">
                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                    <div class="toggle-expand-content" data-content="pageMenu">
                        <ul class="nk-block-tools g-3">
                                <li class="nk-block-tools-opt d-none d-sm-block">
                                    <a href="#" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add-ex_category"><em class="icon ni ni-plus"></em><span>Category Setting</span></a>
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
        <div class="row">
            <div class="col-md-4 col-xxl-8">
                <div class="card card-bordered card-full">
                    <div class="card-inner border-bottom">
                        <div class="card-title-group">
                            <div class="card-title">
                                <h6 class="title">Assign Cash Books</h6>
                            </div>
                            <div class="card-tools">
                                <ul class="card-tools-nav">

                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('management/expenses/add_cashbook_expenses') }}" method="post" id="add_expense_cashbooks" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="{{$hotel->id}}" name="hotel_id_a" id="hotel_id_a">
                            @foreach($cash_books as $cash_book)
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="a_customCheck4{{$cash_book->id}}" name="cash_book_id[]" value="{{$cash_book->id}}">
                                    <label class="custom-control-label" for="a_customCheck4{{$cash_book->id}}">{{$cash_book->name}}</label>
                                </div>
                                <br>
                                <br>
                            @endforeach
                        </form>
                    </div>
                    <div class="card-footer bg-light">
                        <div class="form-group">
                            <button type="button" onclick="$('#add_expense_cashbooks').submit();" class="btn btn-lg btn-primary text-center">Update Setting</button>
                        </div>
                    </div>
                </div><!-- .card -->
            </div><!-- .col -->
            <div class="col-md-4 col-xxl-4">
                <div class="card card-bordered card-full">
                    <div class="card-inner-group"  id="category_list">
                        <div class="card-inner">
                            <div class="card-title-group">
                                <div class="card-title">
                                    <h6 class="title">Categories</h6>
                                </div>
                            </div>
                        </div>
                    @foreach($expense_categories as $expense_category)
                            <div class="card-inner card-inner-md">
                                <div class="user-card">
                                    <div class="user-avatar bg-primary-dim">
                                        <span>AB</span>
                                    </div>
                                    <div class="user-info">
                                        <a href="JavaScript:void(0);" onclick="add_sub_category_view('{{$expense_category->id}}');">
                                        <span class="lead-text" id="category_name_append{{$expense_category->id}}">{{$expense_category->name}}</span>
                                        <span class="sub-text">have {{count($expense_category->expense_sub_category)}} sub categories</span>
                                    </a>
                                    </div>

                                    <div class="user-action">
                                        <div class="drodown">
                                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger me-n1" data-bs-toggle="dropdown" aria-expanded="false"><em class="icon ni ni-more-h"></em></a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <ul class="link-list-opt no-bdr">
                                                    <li><a onclick="edit_category('{{$expense_category->id}}')"><em class="icon ni ni-setting"></em><span>Edit Category</span></a></li>
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

            <div class="col-lg-4 col-xxl-6">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="col-lg-12 col-xxl-12" >
                            <div class="row">
                                <div class="col-lg-7"><h6 class="card-title" id="a_sub_category_name"></h6></div>
                                <div class="col-lg-5 text-end" id="add_item_button"></div>
                            </div>
                            <div class="team" id="sub_category_item">
                                <ul class="team-info">
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="modal hide fade" role="dialog" aria-hidden="true" id="modal-add-ex_category">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title"> Add Expenses Category</h5>
                </div>
                <div class="modal-body" id="">
                    <form action="{{ route('management/expenses/add_category') }}" method="post" id="add_expense_category" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="{{$hotel->id}}" name="hotel_id_a" id="hotel_id_a">
                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="email-address-1">Category Name</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="category_name" name="category_name">
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
                        <button type="button" onclick="$('#add_expense_category').submit();" class="btn btn-lg btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal hide fade" role="dialog" aria-hidden="true" id="modal-edit-ex_category">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title"> Edit Expenses Category</h5>
                </div>
                <div class="modal-body" id="">
                    <form action="{{ route('management/expenses/edit_category_save') }}" method="post" id="edit_expense_category" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="e_category_id" name="e_category_id">
                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="email-address-1">Category Name</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="e_category_name" name="e_category_name">
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
                        <button type="button" onclick="$('#edit_expense_category').submit();" class="btn btn-lg btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal hide fade" role="dialog" aria-hidden="true" id="modal-add-ex_sub_category">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title"> Add Expenses Sub Category</h5>
                </div>
                <div class="modal-body" id="">
                    <form action="{{ route('management/expenses/add_sub_category') }}" method="post" id="add_expense_sub_category" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="v_category_id" name="v_category_id">
                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="email-address-1">Sub Category Name</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="sub_category_name" name="sub_category_name">
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
                        <button type="button" onclick="$('#add_expense_sub_category').submit();" class="btn btn-lg btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal hide fade" role="dialog" aria-hidden="true" id="modal-edit-ex_sub_category">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title"> Edit Expenses Sub Category</h5>
                </div>
                <div class="modal-body" id="">
                    <form action="{{ route('management/expenses/edit_sub_category_save') }}" method="post" id="edit_expense_sub_category" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="e_sub_category_id" name="e_sub_category_id">
                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="email-address-1">Sub Category Name</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="e_sub_category_name" name="e_sub_category_name">
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
                        <button type="button" onclick="$('#edit_expense_sub_category').submit();" class="btn btn-lg btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

@section('script')
    <script>
        $("#add_expense_category").submit(function(e) {

            e.preventDefault(); // avoid to execute the actual submit of the form.
            var form = $(this);
            var formData = new FormData($(this)[0]);
            var url = form.attr('action');
            var c_name = $('#category_name').val();
            if(c_name != ''){
                $.ajax({
                    type: "POST",
                    processData: false,
                    contentType: false,
                    url: url,
                    data: formData, // serializes the form's elements.
                    success: function (data) {
                        $(':input', '#add_expense_category')
                            .not(':button, :submit, :reset, :hidden')
                            .val('')
                            .prop('selected', false);
                        console.log(data);

                        var category = ' <div class="card-inner card-inner-md">\n' +
                            '                                <div class="user-card">\n' +
                            '                                    <div class="user-avatar bg-primary-dim">\n' +
                            '                                        <span>AB</span>\n' +
                            '                                    </div>\n' +
                            '                                    <div class="user-info">\n' +
                            '<a href="JavaScript:void(0);" onclick="add_sub_category_view('+data.category.id+');">\n'+
                            '                                        <span class="lead-text">'+data.category.name+'</span>\n' +
                            '                                        <span class="sub-text">have 0 sub categories</span>\n' +
                            '</a>'+
                            '                                    </div>\n' +
                            '                                    <div class="user-action">\n' +
                            '                                        <div class="drodown">\n' +
                            '                                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger me-n1" data-bs-toggle="dropdown" aria-expanded="false"><em class="icon ni ni-more-h"></em></a>\n' +
                            '                                            <div class="dropdown-menu dropdown-menu-end">\n' +
                            '                                                <ul class="link-list-opt no-bdr">\n' +
                            '                                                    <li><a onclick="edit_category('+data.category.id+')"><em class="icon ni ni-setting"></em><span>Edit Category</span></a></li>\n' +
                            '                                                </ul>\n' +
                            '                                            </div>\n' +
                            '                                        </div>\n' +
                            '                                    </div>\n' +
                            '                                </div>\n' +
                            '                            </div>';


                        $('#category_list').append(category);

                        $('#modal-add-ex_category').modal('hide');
                        NioApp.Toast('Successfully Add Category', 'success',{position: 'top-right'});
                    }
                });
            }else{
                NioApp.Toast('Cannot Empty Category', 'error',{position: 'top-right'});
            }

        });
        $("#add_expense_sub_category").submit(function(e) {

            e.preventDefault(); // avoid to execute the actual submit of the form.
            var form = $(this);
            var formData = new FormData($(this)[0]);
            var url = form.attr('action');
            var c_name = $('#sub_category_name').val();
            if(c_name != ''){
                $.ajax({
                    type: "POST",
                    processData: false,
                    contentType: false,
                    url: url,
                    data: formData, // serializes the form's elements.
                    success: function (data) {
                        $(':input', '#add_expense_sub_category')
                            .not(':button, :submit, :reset, :hidden')
                            .val('')
                            .prop('selected', false);
                        console.log(data);
                        var sub_category_item = ' <div class="user-card">\n' +
                            '                                                    <div class="user-info">\n' +
                            '                                                        <span class="lead-text" id="category_item_name'+data.sub_category.id+'">'+data.sub_category.name+'</span>\n' +
                            '                                                    </div>\n' +
                            '                                                    <div class="user-action">\n' +
                            '                                                        <div class="drodown">\n' +
                            '                                                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger me-n1" data-bs-toggle="dropdown" aria-expanded="false"><em class="icon ni ni-more-h"></em></a>\n' +
                            '                                                            <div class="dropdown-menu dropdown-menu-end">\n' +
                            '                                                                <ul class="link-list-opt no-bdr">\n' +
                            '                                                                    <li><a onclick="edit_sub_category_item('+data.sub_category.id+');"><em class="icon ni ni-setting"></em><span>Edit Item</span></a></li>\n' +
                            '                                                                </ul>\n' +
                            '                                                            </div>\n' +
                            '                                                        </div>\n' +
                            '                                                    </div>\n' +
                            '                                                </div>';

                        $('#sub_category_item').append(sub_category_item);
                        $('#modal-add-ex_sub_category').modal('hide');
                        NioApp.Toast('Successfully Add Sub Category', 'success',{position: 'top-right'});
                    }
                });
            }else{
                NioApp.Toast('Cannot Empty Fields', 'error',{position: 'top-right'});
            }

        });
        $("#add_expense_cashbooks").submit(function(e) {
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
                        $('#modal-add-ex_setting').modal('hide');
                        NioApp.Toast('Successfully Assign Cash Books', 'success',{position: 'top-right'});
                    }
                });
        });

        @foreach($assign_expense_cashbooks as $assign_expense_cashbook)
        $('#a_customCheck4{{$assign_expense_cashbook->cashbook_id}}').prop('checked',true);
        @endforeach

        function edit_category(category_id) {
            $.ajax({
                type:'POST',
                url:'{{ route('management/expenses/edit_category') }}',
                headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                data: {
                    'category_id' : category_id,
                },
                success: function (data) {
                    $('#e_category_id').val(data.category.id);
                    $('#e_category_name').val(data.category.name);
                    $('#modal-edit-ex_category').modal('show');
                }
            });
        }
        $("#edit_expense_category").submit(function(e) {
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
                        $('#category_name_append'+data.category.id).html(data.category.name);
                        $('#modal-edit-ex_category').modal('hide');
                        NioApp.Toast('Successfully Edit Category', 'success',{position: 'top-right'});
                    }
                });
        });

        $("#edit_expense_sub_category").submit(function(e) {
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
                        $('#category_item_name'+data.sub_category.id).html(data.sub_category.name);
                        $('#modal-edit-ex_sub_category').modal('hide');
                        NioApp.Toast('Successfully Edit Sub Category', 'success',{position: 'top-right'});
                    }
                });
        });

        function add_sub_category_view(category_id) {
            $.ajax({
                type:'POST',
                url:'{{ route('management/expenses/add_sub_category_view') }}',
                headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                data: {
                    'category_id' : category_id,
                },
                success: function (data) {
                    console.log(data);
                    $('#a_sub_category_name').html(data.category.name);
                    $('#add_item_button').html('<a onclick="add_sub_category_item('+data.category.id+')" class="btn btn-sm btn-primary">Add</a>');
                    let category_item;
                    $('#sub_category_item').html('');
                    $.each(data.category.expense_sub_category, function (key, val) {

                        category_item = ' <div class="user-card">\n' +
                            '                                                    <div class="user-info">\n' +
                            '                                                        <span class="lead-text" id="category_item_name'+val.id+'">'+val.name+'</span>\n' +
                            '                                                    </div>\n' +
                            '                                                    <div class="user-action">\n' +
                            '                                                        <div class="drodown">\n' +
                            '                                                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger me-n1" data-bs-toggle="dropdown" aria-expanded="false"><em class="icon ni ni-more-h"></em></a>\n' +
                            '                                                            <div class="dropdown-menu dropdown-menu-end">\n' +
                            '                                                                <ul class="link-list-opt no-bdr">\n' +
                            '                                                                    <li><a onclick="edit_sub_category_item('+val.id+');"><em class="icon ni ni-setting"></em><span>Edit Item</span></a></li>\n' +
                            '                                                                </ul>\n' +
                            '                                                            </div>\n' +
                            '                                                        </div>\n' +
                            '                                                    </div>\n' +
                            '                                                </div>';

                        $('#sub_category_item').append(category_item);
                    });


                }
            });
        }
        function add_sub_category_item(category_id) {
            $('#v_category_id').val(category_id);
            $('#modal-add-ex_sub_category').modal('show');
        }
        function edit_sub_category_item(sub_category_id) {
            $.ajax({
                type:'POST',
                url:'{{ route('management/expenses/edit_sub_category/get_detail') }}',
                headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                data: {
                    'sub_category_id' : sub_category_id,
                },
                success: function (data) {
                    $('#e_sub_category_id').val(data.sub_category.id);
                    $('#e_sub_category_name').val(data.sub_category.name);
                    $('#modal-edit-ex_sub_category').modal('show');
                }
            });
        }

    </script>


@endsection
