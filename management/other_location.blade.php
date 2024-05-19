@extends('management.lay' )

@section('title' , __(''))

@section('style')

@endsection

@section('content')
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Other Location</h3>
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
                                <a href="#" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add-other-location"><em class="icon ni ni-plus"></em><span>Add Other Location</span></a>
                            </li>
                            <li class="nk-block-tools-opt d-block d-sm-none">
                                <a href="#" class="btn btn-icon btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add-other-location"><em class="icon ni ni-plus"></em><span>Other Location &nbsp;&nbsp;</span></a>
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
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Checklist Layout</th>
                                    <th>Durty Frequency</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($other_location as $other_locations)
                                    <tr>
                                        <td>{{$other_locations->name}}</td>
                                        <td>{{$other_locations->category}}</td>
                                        <td>
                                            {{isset($other_locations->check_list_layout->name) ? $other_locations->check_list_layout->name : '-'}}
                                        </td>
                                        <td>
                                            @if(($other_locations->duration!=null)&&($other_locations->frequency!=null))
                                            After {{$other_locations->frequency}} {{$other_locations->duration}}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="nk-tb-col nk-tb-col-tools">
                                            <a class="btn btn-trigger btn-icon updateRecordButton" data-locationid="{{$other_locations->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Location"><em class="icon ni ni-pen2"></em></a>

                                            <div class="dropdown">
                                                <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown" aria-expanded="false"><em class="icon ni ni-sign-xrp-new-alt" title="Delete Location"></em></a>
                                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs" style="">
                                                    <ul class="link-list-plain">
                                                        <li><a class="deleteRecordButton" data-locationid="{{$other_locations->id}}">Yes</a></li>
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

    <div class="modal hide fade" role="dialog" aria-hidden="true" id="modal-add-other-location">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title"> Add Other Location</h5>
                </div>
                <div class="modal-body" id="recipe_ingredient_edit">
                    <form action="{{ route('management/other_location/save') }}" method="post" id="add_location">
                        @csrf
                        <input type="hidden" value="{{$hotel->id}}" name="hotel_id_a" id="hotel_id_a">
                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="email-address-1">Name</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="location_name" name="location_name" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

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

                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="full-name">Check List Layout</label>
                                        <div class="form-control-wrap">
                                            <select id="a_checkList_layout" name="a_checkList_layout" class="form-control pl-15" required>
                                                <option value="">--Select Room CheckList Layout - </option>
                                                @foreach($checkList_layout as $checkList_layouts)
                                                    <option value="{{$checkList_layouts->id}}">{{$checkList_layouts->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="full-name">Time to get dirty</label>
                                        <div class="form-control-wrap">
                                            <select id="duration" name="duration" class="form-control pl-15" required>
                                                <option value="">--Select Duration-- </option>
                                                <option value="hours">Hours</option>
                                                <option value="days">Days</option>
                                                <option value="weeks">Weeks</option>
                                                <option value="months">Months</option>
                                                <option value="years">Years</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="full-name">&nbsp;</label>
                                        <div class="form-control-wrap">
                                            <select id="frequency" name="frequency" class="form-control pl-15" required>
                                                <option value="">--Select Frequency-- </option>
                                                <option value=""></option>
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
                        <button type="button" onclick="$('#add_location').submit();" class="btn btn-lg btn-primary">Save Location</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal hide fade" role="dialog" aria-hidden="true" id="modal-edit-other-location">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title"> Edit Other Location</h5>
                </div>
                <div class="modal-body" id="">
                    <form action="{{route('management/other_location_edit/save')}}" method="post" id="edit_other-location_save">
                        @csrf
                        <input type="hidden" name="e_location_id" value="" id="e_location_id">

                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="email-address-1">Name</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="e_name" name="e_name" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

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

                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="full-name">Check List Layout</label>
                                        <div class="form-control-wrap">
                                            <select id="e_checkList_layout" name="e_checkList_layout" class="form-control pl-15" required>
                                                <option value="">--Select Room CheckList Layout - </option>
                                                @foreach($checkList_layout as $checkList_layouts)
                                                    <option value="{{$checkList_layouts->id}}">{{$checkList_layouts->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="full-name">Time to get dirty</label>
                                        <div class="form-control-wrap">
                                            <select id="e_duration" name="e_duration" class="form-control pl-15" required>
                                                <option value="">--Select Duration-- </option>
                                                <option value="hours">Hours</option>
                                                <option value="days">Days</option>
                                                <option value="weeks">Weeks</option>
                                                <option value="months">Months</option>
                                                <option value="years">Years</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="full-name">&nbsp;</label>
                                        <div class="form-control-wrap">
                                            <select id="e_frequency" name="e_frequency" class="form-control pl-15" required>
                                                <option value="">--Select Frequency-- </option>
                                                <option value=""></option>
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
                        <button type="button" onclick="$('#edit_other-location_save').submit();" class="btn btn-lg btn-primary">Save Location</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')
    <script>

        $(document).ready(function(){
            $('#edit_other-location_save').on('submit', function(e){

                e.preventDefault();
                var form = $(this);
                var formData = new FormData($(this)[0]);
                var url = form.attr('action');

                var location_name =  $('#e_name').val();
                var category =  $('#e_category').val();
                var checkList_layout =  $('#e_checkList_layout').val();
                var duration =  $('#e_duration').val();
                var frequency =  $('#e_frequency').val();

                var flag = false;

                if(location_name != '' && category != '') {
                    if (checkList_layout != '') {
                        if(duration != '' && frequency != '') {
                            flag = true;
                        }else{
                            flag = false;
                            NioApp.Toast('Required Duration and Frequency Fields', 'error', {position: 'top-right'});
                        }
                    }else{
                        flag = true;
                    }
                }else{
                    flag = false;
                    NioApp.Toast('Required All Fields', 'error', {position: 'top-right'});
                    //all feeld req
                }

                if(flag){
                    $.ajax({
                        type: "POST",
                        processData: false,
                        contentType: false,
                        url: url,
                        data: formData, // serializes the form's elements.
                        success: function (data) {

                            console.log(data);
                            var action_buton ='<a class="btn btn-trigger btn-icon updateRecordButton" data-locationid="'+data.get_location.id+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Location"><em class="icon ni ni-pen2"></em></a>\n' +
                                '\n' +
                                '                                            <div class="dropdown">\n' +
                                '                                                <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown" aria-expanded="false"><em class="icon ni ni-sign-xrp-new-alt" title="Delete Location"></em></a>\n' +
                                '                                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs" style="">\n' +
                                '                                                    <ul class="link-list-plain">\n' +
                                '                                                        <li><a class="deleteRecordButton" data-locationid="'+data.get_location.id+'">Yes</a></li>\n' +
                                '                                                        <li><a>No</a></li>\n' +
                                '                                                    </ul>\n' +
                                '                                                </div>\n' +
                                '                                            </div>';
                            // var action_buton ='<a class="btn btn-trigger btn-icon updateRecordButton" data-roomid="'+data.get_room.id+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Room"><em class="icon ni ni-pen2"></em></a>\n' +
                            //     '              <a class="btn btn-trigger btn-icon deleteRecordButton" data-roomid="'+data.get_room.id+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Room"><em class="icon ni ni-sign-xrp-new-alt"></em></a>';
                            var durty_frequency= data.get_location.frequency!=null && data.get_location.duration!=null?'After '+data.get_location.frequency+' '+data.get_location.duration:'-'
                            var table_data = [data.get_location.name,data.get_location.category,data.get_location.check_list_layout!=null?data.get_location.check_list_layout.name:'-',durty_frequency,action_buton];
                            // var table_data = [data.get_location.name,data.get_location.category,data.get_location.check_list_layout.name,action_buton];
                            NioApp.DataTable.row(global_theRowObject).data(table_data).draw(false);

                            $('#modal-edit-other-location').modal('hide');
                            NioApp.Toast('Successfully Edit Location', 'success',{position: 'top-right'});
                        }
                    });
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

        $("#add_location").submit(function(e) {

            e.preventDefault(); // avoid to execute the actual submit of the form.
            var form = $(this);
            var formData = new FormData($(this)[0]);
            var url = form.attr('action');

            var location_name =  $('#location_name').val();
            var category =  $('#category').val();
            var checkList_layout =  $('#a_checkList_layout').val();
            var duration =  $('#duration').val();
            var frequency =  $('#frequency').val();

            // if(isset(checkList_layout)){
            //     if(location_name != '' && category != '' && duration != '' && frequency != '') {
            //
            //     }
            // }
            var flag = false;

            if(location_name != '' && category != '') {
                if (checkList_layout != '') {
                    if(duration != '' && frequency != '') {
                        flag = true;
                    }else{
                        flag = false;
                        NioApp.Toast('Required Duration and Frequency Fields', 'error', {position: 'top-right'});
                    }
                }else{
                    flag = true;
                }
            }else{
                flag = false;
                NioApp.Toast('Required All Fields', 'error', {position: 'top-right'});
                //all feeld req
            }

            if(flag){
                $.ajax({
                    type: "POST",
                    processData: false,
                    contentType: false,
                    url: url,
                    data: formData, // serializes the form's elements.
                    success: function (data) {
                        // $('#add_user_save input:checkbox').prop('checked',false).prop('disabled',true);
                        // $('.handle_disable').prop('disabled',false);
                        $(':input', '#add_location')
                            .not(':button, :submit, :reset, :hidden')
                            .val('')
                            .prop('selected', false);
                        console.log(data);
                        var action_buton ='<a class="btn btn-trigger btn-icon updateRecordButton" data-locationid="'+data.location.id+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Location"><em class="icon ni ni-pen2"></em></a>\n' +
                            '\n' +
                            '                                            <div class="dropdown">\n' +
                            '                                                <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown" aria-expanded="false"><em class="icon ni ni-sign-xrp-new-alt" title="Delete Location"></em></a>\n' +
                            '                                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs" style="">\n' +
                            '                                                    <ul class="link-list-plain">\n' +
                            '                                                        <li><a class="deleteRecordButton" data-locationid="'+data.location.id+'">Yes</a></li>\n' +
                            '                                                        <li><a>No</a></li>\n' +
                            '                                                    </ul>\n' +
                            '                                                </div>\n' +
                            '                                            </div>';
                        // var table_data = [data.location.name,data.location.category,data.location.check_list_layout!=null?data.location.check_list_layout.name:'-',data.location.frequency!=null?data.location.frequency:'-',data.location.duration!=null?data.location.duration:'-',action_buton];
                        var durty_frequency= data.location.frequency!=null && data.location.duration!=null?'After '+data.location.frequency+' '+data.location.duration:'-'
                        var table_data = [data.location.name,data.location.category,data.location.check_list_layout!=null?data.location.check_list_layout.name:'-',durty_frequency,action_buton];
                        {{--// // console.log(table_data);--}}
                        {{--// //--}}
                        NioApp.DataTable.row.add(table_data);
                        NioApp.DataTable.draw()

                        $('#modal-add-other-location').modal('hide');
                        NioApp.Toast('Successfully Add Location', 'success',{position: 'top-right'});
                    }
                });
            }

        });

        $('#Room-table tbody').on('click', 'a', function () {
            if ( $(this).hasClass('updateRecordButton') ) {
                var data = NioApp.DataTable.row($(this).parents('tr')).data(); //Retrieve row data
                var tr = $(this).closest('tr'); //Find DataTables table row
                var theRowObject = NioApp.DataTable.row(tr); //Get DataTables row object
                var location_id = $(this).data('locationid');
                global_theRowObject=theRowObject;
                console.log(data);
                $.ajax({
                    type:'POST',
                    url:'{{ route('management/other_location_get_edit_details') }}',
                    headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                    data: {
                        'location_id' : location_id,
                    },
                    success:function(data){
                        console.log(data);
                        $('#e_location_id').val(data.edit_location.id);
                        $('#e_name').val(data.edit_location.name);
                        $('#e_category').val(data.edit_location.category);
                        $('#e_checkList_layout').val(data.edit_location.check_list_layout_id).change();
                        $('#e_duration').val(data.edit_location.duration).change();
                        $('#e_frequency').val(data.edit_location.frequency).change();

                        $('#modal-edit-other-location').modal('show');
                    }
                });

            }
            if ( $(this).hasClass('deleteRecordButton') ) {
                var data = NioApp.DataTable.row($(this).parents('tr')).data(); //Retrieve row data
                var tr = $(this).closest('tr'); //Find DataTables table row
                var theRowObject = NioApp.DataTable.row(tr); //Get DataTables row object
                var location_id = $(this).data('locationid');
                // global_theRowObject2=theRowObject;
                $.ajax({
                    type:'POST',
                    url:'{{ route('management/other_location/delete') }}',
                    headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                    data: {
                        'location_id' : location_id,
                    },
                    success:function(data){
                        if(data.success){
                            NioApp.Toast('Successfully Deleted Location', 'success',{position: 'top-right'});
                            NioApp.DataTable.row(theRowObject).remove().draw();
                        }else{
                            NioApp.Toast(data.error, 'warning',{position: 'top-right'});
                        }
                    }

                });

            }
        });

        var cahnge_hours_frequency = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23];
        var cahnge_days_frequency = [1,2,3,4,5,6];
        var cahnge_weeks_frequency = [1,2,3];
        var cahnge_months_frequency = [1,2,3,4,5,6,7,8,9,10,11];
        var cahnge_years_frequency = [1,2];

        $('#duration').change(function() {
            var duration_id = $(this).val();

            if (duration_id == 'hours') {
                change_frequency(cahnge_hours_frequency,'#frequency');
            }
            else if(duration_id == 'days') {
                change_frequency(cahnge_days_frequency,'#frequency');
            }
            else if(duration_id == 'weeks') {
                change_frequency(cahnge_weeks_frequency,'#frequency');
            }
            else if(duration_id == 'months') {
                change_frequency(cahnge_months_frequency,'#frequency');
            }
            else{
                change_frequency(cahnge_years_frequency,'#frequency');
            }
        });

        $('#e_duration').change(function() {
            var duration_id = $(this).val();

            if (duration_id == 'hours') {
                change_frequency(cahnge_hours_frequency,'#e_frequency');
            }
            else if(duration_id == 'days') {
                change_frequency(cahnge_days_frequency,'#e_frequency');
            }
            else if(duration_id == 'weeks') {
                change_frequency(cahnge_weeks_frequency,'#e_frequency');
            }
            else if(duration_id == 'months') {
                change_frequency(cahnge_months_frequency,'#e_frequency');
            }
            else{
                change_frequency(cahnge_years_frequency,'#e_frequency');
            }
        });

        function change_frequency(frequency,select_id){
            var select_frequency = $(select_id);
            select_frequency.empty();
            select_frequency.append(
                $('<option></option>').val('').html('--Select Frequency--')
            );
            $.each(frequency, function (index, val) {
                // console.log (val);
                select_frequency.append(
                    $('<option></option>').val(val).html(val)
                 );
            })
        }

    </script>


@endsection

