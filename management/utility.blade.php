@extends('management.lay' )

@section('title' , __(''))

@section('style')

@endsection

@section('content')
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Utility</h3>
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
                                <a href="#" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add-category" id="add_c"><em class="icon ni ni-plus"></em><span>Add New Category</span></a>
                            </li>
                            <li class="nk-block-tools-opt d-block d-sm-none">
                                <a href="#" class="btn btn-icon btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add-category" id="add_c"><em class="icon ni ni-plus"></em></a>
                            </li>

                            {{--                            <li class="nk-block-tools-opt d-none d-sm-block">--}}
                            {{--                                <a href="#" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add-location"><em class="icon ni ni-plus"></em><span>Add New Location</span></a>--}}
                            {{--                            </li>--}}
                            {{--                            <li class="nk-block-tools-opt d-block d-sm-none">--}}
                            {{--                                <a href="#" class="btn btn-icon btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add-location"><em class="icon ni ni-plus"></em></a>--}}
                            {{--                            </li>--}}


                        </ul>
                    </div>
                </div><!-- .toggle-wrap -->
            </div><!-- .nk-block-head-content -->
        </div><!-- .nk-block-between -->
    </div>

    <div class="nk-block">

        <div class="row">
            <div class="col-12">
                <div class="card card-bordered card-preview">

                    <div class="card-inner">
                        <h3 class="nk-block-title page-title">Utility Category</h3><br>
                        <table class="datatable-init-export nowrap table" data-export-title="Export" id="Utility-table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Difference</th>
                                <th>Average</th>
                                <th>Decimals</th>
                                <th>Guests</th>
                                <th>Unit Price</th>
                                <th>Bill Range Date</th>
                                <th>Monthly Charj</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($utility_category as $utility_categories)
                                <tr>
                                    <td>{{$utility_categories->utility_category_name}}</td>
                                    <td>{{$utility_categories->difference}}</td>
                                    <td>{{$utility_categories->average}}</td>
                                    <td>{{$utility_categories->point}}</td>
                                    <td>{{$utility_categories->guest}}</td>
                                    <td>@if($utility_categories->unit_price == null)
                                            -
                                        @else
                                            {{$utility_categories->unit_price}}
                                        @endif
                                    </td>
                                    <td>@if($utility_categories->range_date == null)
                                            -
                                        @else
                                            {{$utility_categories->range_date}}
                                        @endif
                                    </td>
                                    <td>@if($utility_categories->monthly_charj == null)
                                            -
                                        @else
                                            {{$utility_categories->monthly_charj}}
                                        @endif
                                    </td>

                                    <td class="nk-tb-col nk-tb-col-tools">
                                        <a class="btn btn-trigger btn-icon updateRecordButton" data-itemid="{{$utility_categories->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Category"><em class="icon ni ni-pen2"></em></a>

                                        <div class="dropdown">
                                            <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown" aria-expanded="false" title="Delete Category"><em class="icon ni ni-sign-xrp-new-alt"></em></a>
                                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs" style="">
                                                <ul class="link-list-plain">
                                                    <li><a class="deleteRecordButton" data-itemid="{{$utility_categories->id}}">Yes</a></li>
                                                    <li><a>No</a></li>
                                                </ul>
                                            </div>
                                        </div>
{{--                                        <a class="btn btn-trigger btn-icon deleteRecordButton" data-itemid="{{$utility_categories->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Category"><em class="icon ni ni-sign-xrp-new-alt"></em></a>--}}
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

    <div class="modal hide fade" role="dialog" aria-hidden="true" id="modal-add-category">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title"> Add Utility Category</h5>
                </div>
                <div class="modal-body" id="recipe_ingredient_edit">
                    <form action="{{ route('management/utility_category/save') }}" method="post" id="add_category" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="{{$hotel->id}}" name="hotel_id_a" id="hotel_id_a">
                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="email-address-1">Category Name</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="a_utility_category_name" name="a_utility_category_name" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="email-address-1">Decimals</label>
                                        <div class="form-control-wrap">
                                            <select class="form-select js-select2" data-search="on" id="decimal_point" name="decimal_point" required>
                                                <option value="">Select Decimal Point</option>
                                                <option value="0">None</option>
                                                @for($i = 1; $i <= 5; $i++)
                                                    <option value="{{$i}}">{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="email-address-1">Unit Price</label>
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control" id="a_utility_category_unit_price" name="a_utility_category_unit_price" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="email-address-1">Bill Range Date</label>
                                        <div class="form-control-wrap">
                                            <select class="form-select js-select2" data-search="on" id="range_date" name="range_date" required>
                                                <option value="">Select Bill Range Dat</option>
                                                <option value="0">None</option>
                                                @for($i = 1; $i <= 30; $i++)
                                                    <option value="{{$i}}">{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="email-address-1">Monthly Charj</label>
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control" id="a_utility_category_monthly_charj" name="a_utility_category_monthly_charj" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>




                        <div class="row g-4 Guests">
                            <div class="row g-4" id="">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-label" for="">Guests</label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input guests" class="radio" value="Yes" id="guests_yes" name="guests" required="required">
                                            <label class="custom-control-label" for="guests_yes">Yes</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input guests" class="radio" value="No" id="guests_no" name="guests" required="required">
                                            <label class="custom-control-label" for="guests_no">No</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="row g-4 Difference">
                            <div class="row g-4" id="">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-label" for="email-address-1">Difference</label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input difference" class="radio" value="yes" id="difference_yes" name="difference" required="required">
                                            <label class="custom-control-label" for="difference_yes">Yes</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input difference" class="radio" value="no" id="difference_no" name="difference" required="required">
                                            <label class="custom-control-label" for="difference_no">No</label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="row g-4 Average">
                            <div class="row g-4" id="">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-label" for="email-address-1">Average</label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input average" class="radio" value="yes" id="average_yes" name="average" required="required">
                                            <label class="custom-control-label" for="average_yes">Yes</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input average" class="radio" value="no" id="average_no" name="average" required="required">
                                            <label class="custom-control-label" for="average_no">No</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>

                    </form>
                </div>
                <div class="modal-footer bg-light">
                    <div class="form-group">
                        <button type="button" class="btn btn-danger btn-lg" data-bs-dismiss="modal">Close</button>
                        <button type="button" onclick="$('#add_category').submit();" class="btn btn-lg btn-primary">Save Category</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal hide fade" role="dialog" aria-hidden="true" id="modal-edit-category">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title"> Edit Utility Category</h5>
                </div>
                <div class="modal-body" id="">
                    <form action="{{route('management/edit_utility_category/save')}}" method="post" id="edit_item_save">
                        @csrf
                        <input type="hidden" name="e_item_id" value="" id="e_item_id">
                        {{--                        <input type="hidden" name="edit_user_privilege_id" value="" id="edit_user_privilege_id">--}}
                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="email-address-1">Category Name</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="edit_utility_category_name" name="edit_utility_category_name" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="email-address-1">Decimals</label>
                                        <div class="form-control-wrap">
                                            <select class="form-select js-select2" data-search="on" id="e_decimal_point" name="e_decimal_point" required>
                                                <option value="">Select Decimal Point</option>
                                                <option value="0">None</option>
                                                @for($i = 1; $i <= 5; $i++)
                                                    <option value="{{$i}}">{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="email-address-1">Unit Price</label>
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control" id="e_utility_category_unit_price" name="e_utility_category_unit_price" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="email-address-1">Monthly Charj</label>
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control" id="e_utility_category_monthly_charj" name="e_utility_category_monthly_charj" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="email-address-1">Bill Range Date</label>
                                        <div class="form-control-wrap">
                                            <select class="form-select js-select2" data-search="on" id="edit_range_date" name="edit_range_date" required>
                                                <option value="">Select Bill Range Dat</option>
                                                <option value="0">None</option>
                                                @for($i = 1; $i <= 30; $i++)
                                                    <option value="{{$i}}">{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-4 Guests">
                            <div class="row g-4" id="">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-label" for="">Guests</label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input e_guests" class="radio" value="Yes" id="e_guests_yes" name="e_guests" required="required">
                                            <label class="custom-control-label" for="e_guests_yes">Yes</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input e_guests" class="radio" value="No" id="e_guests_no" name="e_guests" required="required">
                                            <label class="custom-control-label" for="e_guests_no">No</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <hr>
                        <div class="row g-4 Difference">
                            <div class="row g-4" id="">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-label" for="email-address-1">Difference</label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input e_difference" class="radio" value="yes" id="e_difference_yes" name="e_difference" required="required">
                                            <label class="custom-control-label" for="e_difference_yes">Yes</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input e_difference" class="radio" value="no" id="e_difference_no" name="e_difference" required="required">
                                            <label class="custom-control-label" for="e_difference_no">No</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-4 Average">
                            <div class="row g-4" id="">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-label" for="email-address-1">Average</label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input e_average" class="radio" value="yes" id="e_average_yes" name="e_average" required="required">
                                            <label class="custom-control-label" for="e_average_yes">Yes</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input e_average" class="radio" value="no" id="e_average_no" name="e_average" required="required">
                                            <label class="custom-control-label" for="e_average_no">No</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>


                    </form>
                </div>
                <div class="modal-footer bg-light">
                    <div class="form-group">
{{--                        <button type="button" class="btn btn-danger btn-lg" data-bs-dismiss="modal">Close</button>--}}
                        <button type="button" class="btn btn-danger btn-lg" data-bs-dismiss="modal" id="closeButton">Close</button>

                        <button type="button" onclick="$('#edit_item_save').submit();" class="btn btn-lg btn-primary">Save Category</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('.custom-control-input').on('change', function () {
                $(this).closest('.Average').find('.custom-control-input').not(this).prop('checked', false);
                $(this).closest('.Average').find('.custom-control-input').not(this).removeAttr('required');
                $(this).attr('required', 'required');
            });
        });
        $(document).ready(function () {
            $('.custom-control-input').on('change', function () {
                $(this).closest('.Difference').find('.custom-control-input').not(this).prop('checked', false);
                $(this).closest('.Difference').find('.custom-control-input').not(this).removeAttr('required');
                $(this).attr('required', 'required');
            });
        });
        $(document).ready(function () {
            $('.custom-control-input').on('change', function () {
                $(this).closest('.Guests').find('.custom-control-input').not(this).prop('checked', false);
                $(this).closest('.Guests').find('.custom-control-input').not(this).removeAttr('required');
                $(this).attr('required', 'required');
            });
        });


        $(document).ready(function(){
            $('#edit_item_save').on('submit', function(e){

                e.preventDefault();
                var form = $(this);
                var formData = new FormData($(this)[0]);
                var url = form.attr('action');

                var utility_category_name =  $('#edit_utility_category_name').val();
                var decimal_point =  $('#e_decimal_point').val();
                var range_date =  $('#edit_range_date').val();
                var utility_category_monthly_charj = $('#e_utility_category_monthly_charj').val();
                var differenceCheckboxYes = $('#e_difference_yes');
                var differenceCheckboxNo = $('#e_difference_no');
                var averageCheckboxeYes = $('#e_average_yes');
                var averageCheckboxeNo = $('#e_average_no');
                var guestsCheckboxeYes = $('#e_guests_yes');
                var guestsCheckboxeNo = $('#e_guests_no');

                if(utility_category_name != '' && utility_category_monthly_charj!='' && decimal_point != '' && range_date != '' && (guestsCheckboxeYes.prop('checked') || guestsCheckboxeNo.prop('checked')) && (differenceCheckboxNo.prop('checked') || (differenceCheckboxYes.prop('checked') && (averageCheckboxeYes.prop('checked') || averageCheckboxeNo.prop('checked'))))) {
                    $.ajax({
                        type: "POST",
                        processData: false,
                        contentType: false,
                        url: url,
                        data: formData, // serializes the form's elements.
                        success: function (data) {

                            console.log(data);
                            // var action_buton ='<a class="btn btn-trigger btn-icon updateRecordButton" data-itemid="'+data.get_item.id+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Category"><em class="icon ni ni-pen2"></em></a>\n' +
                            //     '              <a class="btn btn-trigger btn-icon deleteRecordButton" data-itemid="'+data.get_item.id+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Category"><em class="icon ni ni-sign-xrp-new-alt"></em></a>'

                            var action_buton = '<a class="btn btn-trigger btn-icon updateRecordButton" data-itemid="'+data.get_item.id+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Category"><em class="icon ni ni-pen2"></em></a>\n' +
                               '\n' +
                               '                                        <div class="dropdown">\n' +
                               '                                            <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown" aria-expanded="false" title="Delete Category"><em class="icon ni ni-sign-xrp-new-alt"></em></a>\n' +
                               '                                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs" style="">\n' +
                               '                                                <ul class="link-list-plain">\n' +
                               '                                                    <li><a class="deleteRecordButton" data-itemid="'+data.get_item.id+'">Yes</a></li>\n' +
                               '                                                    <li><a>No</a></li>\n' +
                               '                                                </ul>\n' +
                               '                                            </div>\n' +
                               '                                        </div>';
                            var table_data = [data.get_item.utility_category_name,data.get_item.difference,data.get_item.average,data.get_item.point,data.get_item.guest,data.get_item.unit_price,data.get_item.range_date,data.get_item.monthly_charj,action_buton];
                            NioApp.DataTable.row(global_theRowObject).data(table_data).draw(false);

                            $('#modal-edit-category').modal('hide');

                            NioApp.Toast('Successfully Edit item', 'success',{position: 'top-right'});
                        }
                    });
                }
                else{
                    NioApp.Toast('Required All Fields', 'error', {position: 'top-right'});
                }

            });
        });
        let global_theRowObject;
        // let global_theRowObject2;
        let global_theRowObject3;
        $(document).ready( function () {
            var export_title = $('#Utility-table').data('export-title') ? $('#Utility-table').data('export-title') : 'Export';
            var attr =  {"responsive":{"details":true},"autoWidth":false,"dom":"<\"row justify-between g-2 with-export\"<\"col-7 col-sm-4 text-start\"f><\"col-5 col-sm-8 text-end\"<\"datatable-filter\"<\"d-flex justify-content-end g-2\"<\"dt-export-buttons d-flex align-center\"<\"dt-export-title d-none d-md-inline-block\">B>l>>>><\"datatable-wrap my-3\"t><\"row align-items-center\"<\"col-7 col-sm-12 col-md-9\"p><\"col-5 col-sm-12 col-md-3 text-start text-md-end\"i>>","language":{"search":"","searchPlaceholder":"Type in to Search","infoEmpty":"0","infoFiltered":"( Total MAX  )","paginate":{"first":"First","last":"Last","next":"Next","previous":"Prev"}},"buttons":["copy","excel","csv","pdf","colvis"]};
            NioApp.DataTable = $('#Utility-table').DataTable(attr);
            $.fn.DataTable.ext.pager.numbers_length = 7;
            $('.dt-export-title').text(export_title);

            // var export_title = $('#Location-table').data('export-title') ? $('#Location-table').data('export-title') : 'Export';
            // var attr =  {"responsive":{"details":true},"autoWidth":false,"dom":"<\"row justify-between g-2 with-export\"<\"col-7 col-sm-4 text-start\"f><\"col-5 col-sm-8 text-end\"<\"datatable-filter\"<\"d-flex justify-content-end g-2\"<\"dt-export-buttons d-flex align-center\"<\"dt-export-title d-none d-md-inline-block\">B>l>>>><\"datatable-wrap my-3\"t><\"row align-items-center\"<\"col-7 col-sm-12 col-md-9\"p><\"col-5 col-sm-12 col-md-3 text-start text-md-end\"i>>","language":{"search":"","searchPlaceholder":"Type in to Search","infoEmpty":"0","infoFiltered":"( Total MAX  )","paginate":{"first":"First","last":"Last","next":"Next","previous":"Prev"}},"buttons":["copy","excel","csv","pdf","colvis"]};
            // NioApp.DataTable2 = $('#Location-table').DataTable(attr);
            // $.fn.DataTable.ext.pager.numbers_length = 7;
            // $('.dt-export-title').text(export_title);

            // var export_title = $('#Status-table').data('export-title') ? $('#Status-table').data('export-title') : 'Export';
            // var attr =  {"responsive":{"details":true},"autoWidth":false,"dom":"<\"row justify-between g-2 with-export\"<\"col-7 col-sm-4 text-start\"f><\"col-5 col-sm-8 text-end\"<\"datatable-filter\"<\"d-flex justify-content-end g-2\"<\"dt-export-buttons d-flex align-center\"<\"dt-export-title d-none d-md-inline-block\">B>l>>>><\"datatable-wrap my-3\"t><\"row align-items-center\"<\"col-7 col-sm-12 col-md-9\"p><\"col-5 col-sm-12 col-md-3 text-start text-md-end\"i>>","language":{"search":"","searchPlaceholder":"Type in to Search","infoEmpty":"0","infoFiltered":"( Total MAX  )","paginate":{"first":"First","last":"Last","next":"Next","previous":"Prev"}},"buttons":["copy","excel","csv","pdf","colvis"]};
            // NioApp.DataTable3 = $('#Status-table').DataTable(attr);
            // $.fn.DataTable.ext.pager.numbers_length = 7;
            // $('.dt-export-title').text(export_title);


        });

        $("#add_category").submit(function(e) {

            e.preventDefault(); // avoid to execute the actual submit of the form.
            var form = $(this);
            var formData = new FormData($(this)[0]);
            var url = form.attr('action');

            var hotel_id =  $('#hotel_id_a').val();
            var utility_category_name =  $('#a_utility_category_name').val();
            var decimal_point =  $('#decimal_point').val();
            var range_date =  $('#range_date').val();
            var utility_category_monthly_charj = $('#a_utility_category_monthly_charj').val();

            var differenceCheckboxYes = $('#difference_yes');
            var differenceCheckboxNo = $('#difference_no');
            var averageCheckboxeYes = $('#average_yes');
            var averageCheckboxeNo = $('#average_no');
            var guestsCheckboxeYes = $('#guests_yes');
            var guestsCheckboxeNo = $('#guests_no');

            if(hotel_id != '' && utility_category_monthly_charj !='' && utility_category_name != '' && (guestsCheckboxeYes.prop('checked') || guestsCheckboxeNo.prop('checked')) && decimal_point != '' && range_date != '' && (differenceCheckboxNo.prop('checked') || (differenceCheckboxYes.prop('checked') && (averageCheckboxeYes.prop('checked') || averageCheckboxeNo.prop('checked'))))) {
                $.ajax({
                    type: "POST",
                    processData: false,
                    contentType: false,
                    url: url,
                    data: formData, // serializes the form's elements.
                    success: function (data) {
                        // $('#add_user_save input:checkbox').prop('checked',false).prop('disabled',true);
                        // $('.handle_disable').prop('disabled',false);
                        $(':input', '#add_category')
                            .not(':button, :submit, :reset, :hidden')
                            .val('')
                            .prop('selected', false);
                        console.log(data);

                        // var action_buton ='<a class="btn btn-trigger btn-icon updateRecordButton" data-itemid="'+data.utility_category.id+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Restaurant"><em class="icon ni ni-pen2"></em></a>\n' +
                        //     '              <a class="btn btn-trigger btn-icon deleteRecordButton" data-itemid="'+data.utility_category.id+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Restaurant"><em class="icon ni ni-sign-xrp-new-alt"></em></a>';

                        var action_buton ='<a class="btn btn-trigger btn-icon updateRecordButton" data-itemid="'+data.utility_category.id+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Category"><em class="icon ni ni-pen2"></em></a>\n' +
                            '\n' +
                            '                                        <div class="dropdown">\n' +
                            '                                            <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown" aria-expanded="false" title="Delete Category"><em class="icon ni ni-sign-xrp-new-alt"></em></a>\n' +
                            '                                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs" style="">\n' +
                            '                                                <ul class="link-list-plain">\n' +
                            '                                                    <li><a class="deleteRecordButton" data-itemid="'+data.utility_category.id+'">Yes</a></li>\n' +
                            '                                                    <li><a>No</a></li>\n' +
                            '                                                </ul>\n' +
                            '                                            </div>\n' +
                            '                                        </div>';
                        var table_data = [data.utility_category.utility_category_name,data.utility_category.difference,data.utility_category.average,data.utility_category.point,data.utility_category.guest,data.utility_category.unit_price,data.utility_category.range_date,data.utility_category.monthly_charj,action_buton];
                        // // console.log(table_data);
                        // //
                        NioApp.DataTable.row.add(table_data);
                        NioApp.DataTable.draw()

                        $('#modal-add-category').modal('hide');
                        NioApp.Toast('Successfully Add New Category', 'success',{position: 'top-right'});
                    }
                });
            }
            else{
                NioApp.Toast('Required All Fields', 'error', {position: 'top-right'});
            }

        });


        $('#Utility-table tbody').on('click', 'a', function () {
            if ( $(this).hasClass('updateRecordButton') ) {
                var data = NioApp.DataTable.row($(this).parents('tr')).data(); //Retrieve row data
                var tr = $(this).closest('tr'); //Find DataTables table row
                var theRowObject = NioApp.DataTable.row(tr); //Get DataTables row object
                var item_id = $(this).data('itemid');
                global_theRowObject=theRowObject;
                console.log(data);

                $.ajax({
                    type:'POST',
                    url:'{{ route('management/utility_category/get_edit_utility_category_details') }}',
                    headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                    data: {
                        'item_id' : item_id,
                    },
                    // success:function(data){
                    //     console.log(data);
                    //     $('#e_item_id').val(data.edit_item.id)
                    //     $('#edit_utility_category_name').val(data.edit_item.utility_category_name)
                    //
                    //     if(data.edit_item.difference == 'Yes'){
                    //         $('#e_difference_yes').prop('checked',true);
                    //         if(data.edit_item.average == 'Yes'){
                    //             $('#e_average_yes').prop('checked',true);
                    //         }
                    //         if(data.edit_item.average == 'No'){
                    //             $('#e_average_no').prop('checked',true);
                    //         }
                    //     }
                    //     if(data.edit_item.difference == 'No'){
                    //         $('#e_difference_no').prop('checked',true);
                    //     }
                    //
                    //     $('#modal-edit-category').modal('show');
                    // }

                    success: function(data) {
                        console.log(data);
                        $('#e_item_id').val(data.edit_item.id);
                        $('#edit_utility_category_name').val(data.edit_item.utility_category_name);
                        $('#e_utility_category_unit_price').val(data.edit_item.unit_price);
                        $('#e_utility_category_monthly_charj').val(data.edit_item.monthly_charj);

                        $('#e_difference_yes').prop('checked', false);
                        $('#e_difference_no').prop('checked', false);
                        $('#e_average_yes').prop('checked', false);
                        $('#e_average_no').prop('checked', false);
                        $('#e_guests_yes').prop('checked', false);
                        $('#e_guests_no').prop('checked', false);

                        if (data.edit_item.difference === 'Yes') {
                            $('#e_difference_yes').prop('checked', true);
                            if (data.edit_item.average === 'Yes') {
                                $('#e_average_yes').prop('checked', true);
                            } else if (data.edit_item.average === 'No') {
                                $('#e_average_no').prop('checked', true);
                            }
                            $('.Average').show(); // Show the "Average" section when the difference is "Yes"
                        } else if (data.edit_item.difference === 'No') {
                            $('#e_difference_no').prop('checked', true);
                            $('.Average').hide(); // Hide the "Average" section when the difference is "No"
                        }

                        if (data.edit_item.guest === 'Yes') {
                            $('#e_guests_yes').prop('checked', true);
                        } else if (data.edit_item.guest === 'No') {
                            $('#e_guests_no').prop('checked', true);
                        }

                        $('#e_decimal_point').val(data.edit_item.point).change();
                        $('#edit_range_date').val(data.edit_item.range_date).change();

                        $('#modal-edit-category').modal('show');
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
                    url:'{{ route('management/utility_category/delete') }}',
                    headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                    data: {
                        'item_id' : item_id,
                    },
                    success:function(data){
                        if(data.success){
                            NioApp.Toast('Successfully Deleted Item', 'success',{position: 'top-right'});
                            NioApp.DataTable.row(theRowObject).remove().draw();
                        }else{
                            NioApp.Toast('This Category is used ', 'warning',{position: 'top-right'});
                        }
                    }

                });

            }
        });


        $(document).ready(function() {
            $('.Average').hide(); // Hide the "Average" section initially

            $('.Difference .custom-control-input').on('change', function() {
                var differenceCheckbox = $(this);
                var averageSection = $('.Average');

                if (differenceCheckbox.val() === 'yes' && differenceCheckbox.prop('checked')) {
                    averageSection.show();
                } else {
                    averageSection.hide();
                }
            });
        });

        $('#add_c').on('click', function () {
            $('.Average').hide(); // Hide the "Average" section initially

            $('#difference_yes').prop('checked', false);
            $('#difference_no').prop('checked', false);

            $('.Difference .custom-control-input').on('change', function() {
                var differenceCheckbox = $(this);
                var averageSection = $('.Average');

                if (differenceCheckbox.val() === 'yes' && differenceCheckbox.prop('checked')) {
                    averageSection.show();
                } else {
                    averageSection.hide();
                }
            });
        });

        // document.getElementById('closeButton').addEventListener('click', function() {
        //     // Refresh the page
        // });


    </script>
    <script>

    </script>

@endsection
