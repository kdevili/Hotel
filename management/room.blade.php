@extends('management.lay' )

@section('title' , __(''))

@section('style')

@endsection

@section('content')
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Rooms</h3>
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
                <div class="nk-block">
                    <div class="card card-bordered card-preview">
                        <div class="card-inner">

                            <table class="datatable-init-export nowrap table" data-export-title="Export" id="Room-table">
                                <thead>
                                <tr>
                                    <th>Room Number</th>
                                    <th>Room Type</th>
                                    <th>Room Category</th>
                                    <th>Checklist Layout</th>
                                     <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Room Reapair Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($rooms as $room)
                                    <tr>
                                        <td>{{$room->room_number}}</td>
                                        <td>{{$room->room_type}}</td>
                                        <td>
                                            {{$room->room_category->category}}
                                        </td>
                                        <td>
                                            {{isset($room->check_list_layout->name) ? $room->check_list_layout->name : '-'}}
                                        </td>

                                        <td>
                                            @php
                                                $firstRoomRepairEndDate = $room->room_repairs()
                                                    ->orderBy('start_date', 'desc')
                                                    ->first();
                                            @endphp

                                            @if($firstRoomRepairEndDate)
                                                {{$firstRoomRepairEndDate->start_date}}
                                            @else
                                                --
                                            @endif
                                        </td>

                                        <td>
                                            @php
                                                $firstRoomRepairEndDate = $room->room_repairs()
                                                    ->orderBy('end_date', 'desc')
                                                    ->first();
                                            @endphp

                                            @if($firstRoomRepairEndDate)
                                                {{$firstRoomRepairEndDate->end_date}}
                                                <a class="btn btn-trigger btn-icon updatereapairRecordButton" onclick="extend_end_date_load('{{ $firstRoomRepairEndDate->id }}','{{ $firstRoomRepairEndDate->end_date }}')" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Repair"><em class="icon ni ni-pen2"></em></a>
                                            @else
                                                --
                                            @endif
                                        </td>


                                        <td>


                                            @if($room->reapair == 'repair')
                                                <span class="badge badge-dot bg-danger">Repair</span>

                                            @elseif ($room->reapair == 'complete')
                                                <span class="badge badge-dot bg-success">Complete</span>
                                            @endif


                                        </td>


                                         <td class="nk-tb-col nk-tb-col-tools">
                                            <a class="btn btn-trigger btn-icon updateRecordButton" data-roomid="{{$room->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Room"><em class="icon ni ni-pen2"></em></a>
{{--                                            <a class="btn btn-trigger btn-icon deleteRecordButton" data-roomid="{{$room->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Room"><em class="icon ni ni-sign-xrp-new-alt"></em></a>--}}

                                            <div class="dropdown">
                                                <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown" aria-expanded="false"><em class="icon ni ni-sign-xrp-new-alt" title="Delete Room"></em></a>
                                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs" style="">
                                                    <ul class="link-list-plain">
                                                        <li><a class="deleteRecordButton" data-roomid="{{$room->id}}">Yes</a></li>
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
                    <div class="card-inner-group" id="room_category_list">
                        <div class="card-inner">
                            <div class="card-title-group">
                                <div class="card-title">
                                    <h6 class="title">Room Category</h6>
                                </div>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalDefault">Add</button>
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
                                            <ul class="link-list-opt no-bdr">
                                                <li><a onclick="edit_room_category('{{$room_category->id}}')"><em class="icon ni ni-setting"></em><span>Edit Room Category</span></a></li>
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

    <div class="modal hide fade" role="dialog" aria-hidden="true" id="modal-add-rooms">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title"> Add Rooms</h5>
                </div>
                <div class="modal-body" id="recipe_ingredient_edit">
                    <form action="{{ route('management/room/save') }}" method="post" id="add_rooms">
                        @csrf
                        <input type="hidden" value="{{$hotel->id}}" name="hotel_id_a" id="hotel_id_a">
                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="email-address-1">Room Number(name)</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="room_number" name="room_number" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="email-address-1">Room Type</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="room_type" name="room_type" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="full-name">Room Category</label>
                                        <div class="form-control-wrap">
                                            <select id="room_category" name="room_category" class="form-control pl-15" required>
                                                <option value="">--Select Room Category - </option>
                                                @foreach($room_categories as $room_category)
                                                    <option value="{{$room_category->id}}">{{$room_category->category}}</option>
                                                @endforeach
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
                                        <label class="form-label" for="full-name">Check List Layout</label>
                                        <div class="form-control-wrap">
                                            <select id="checkList_layout" name="checkList_layout" class="form-control pl-15" required>
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
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label" for="email-address-1">Room Reapair</label>
                                    <div class="form-control-wrap">
                                        <select id="repair_status" name="repair_status" class="form-control pl-15" required>
                                            <option value="">--Select--</option>
                                            <option value="complete">Complete</option>
                                            <option value="repair">Repair</option>
                                        </select>
                                    </div>
                                </div>

                                <div id="room_repair" style="display: none;">
                                <label  class="form-label" for="email-address-1">Select Date Range</label>
                                <div class="form-control-wrap">
                                    <input type="text" id="daterange1" name="daterange1" />
                                    <div class="form-control-wrap">
                                        <input type="hidden" id="a_start_date" name="a_start_date" value="">
                                        <input type="hidden" id="a_end_date" name="a_end_date" value="">

                                    </div>
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
                        <button type="button" onclick="$('#add_rooms').submit();" class="btn btn-lg btn-primary">Save Room</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal hide fade" role="dialog" aria-hidden="true" id="modal-edit-rooms">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title"> Edit Rooms</h5>
                </div>
                <div class="modal-body" id="">
                    <form action="{{route('management/edit_room/save')}}" method="post" id="edit_room_save">
                        @csrf
                        <input type="hidden" name="e_room_id" value="" id="e_room_id">

                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="email-address-1">Room Number(name)</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="e_room_number" name="e_room_number" required>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="email-address-1">Room Type</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="e_room_type" name="e_room_type" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="full-name">Room Category</label>
                                        <div class="form-control-wrap">
                                            <select name="e_room_category" id="e_room_category" class="form-control pl-15" required>
                                                <option value="">--Select Room Category - </option>
                                                @foreach($room_categories as $room_category)
                                                    <option value="{{$room_category->id}}">{{$room_category->category}}</option>
                                                @endforeach
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
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label" for="email-address-1">Room Repair</label>
                                    <div class="form-control-wrap">
                                        <select id="e_repair_status" name="e_repair_status" class="form-control pl-15" required>
                                            <option value="">--Select--</option>
                                            <option value="complete">Complete</option>
                                            <option value="repair">Repair</option>
                                        </select>
                                    </div>
                                </div>
                                <input type="button" data-roomid="0" class="btn btn-primary btn-sm add-room-repair" id="add_room_repair" value="Add Room Repair" style="display: none;" >
                            </div>
                            </div>
                        </div>


                    </form>
                </div>
                <div class="modal-footer bg-light">
                    <div class="form-group">
                        <button type="button" class="btn btn-danger btn-lg" data-bs-dismiss="modal">Close</button>
                        <button type="button" onclick="$('#edit_room_save').submit();" class="btn btn-lg btn-primary">Save Room</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="modalDefault">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title">Add Room Category</h5>
                </div>
                <div class="modal-body">
                    <form action="{{route('management/save-room-category')}}" method="post" id="add-room-category" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="{{$hotel->id}}" name="room_hotel_id" id="room_hotel_id">
                        <div class="row gy-4">
                            <div class="col-md-12 col-lg-12 col-xxl-12">
                                <div class="form-group">
                                    <label class="form-label">Upload Photo</label>
                                    <div class="form-control-wrap">
                                        <div class="form-file">
                                            <input type="file" multiple class="form-file-input" id="image" name="image">
                                            <label class="form-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div class="col-md-6 col-lg-6 col-xxl-6">
                        <div class="form-group">
                            <label class="form-label" for="full-name">Room Type</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="room_type" name="room_type" required>
                            </div>
                        </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-xxl-6">
                            <div class="form-group">
                                <label class="form-label" for="email-address-1">Room Name</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="room_name" name="room_name" required>
                                </div>
                            </div>
                        </div>
                            <div class="col-md-6 col-lg-6 col-xxl-6">
                            <div class="form-group">
                                <label class="form-label" for="email-address-1">Custom Name (optional)</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="custom_name" name="custom_name">
                                </div>
                            </div>
                        </div>
                            <div class="col-md-6 col-lg-6 col-xxl-6">
                                <div class="form-group">
                                    <label class="form-label">Smoking Policy</label>
                                    <div class="form-control-wrap">
                                        <select class="form-select js-select2" data-placeholder="Select multiple options" name="smoke">
                                            <option value="I have Smoking option">I have Smoking option</option>
                                            <option value="I have Non-Smoking option">I have Non-Smoking option</option>
                                            <option value="I have both Smoking and non-smoking options for this room type">I have both Smoking and non-smoking options for this room type</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-xxl-6">
                            <div class="form-group">
                                <label class="form-label" for="email-address-1">Number of Rooms (of this type)</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="room_count" name="room_count" required>
                                </div>
                            </div>
                        </div>
                            <div class="col-md-6 col-lg-6 col-xxl-6">
                                <div class="form-group">
                                    <label class="form-label" for="email-address-1">Price</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="price" name="price" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-xxl-6">
                                <div class="form-group">
                                    <label class="form-label" for="email-address-1">Number of Bedrooms</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="bed_count" name="bed_count" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-xxl-6">
                                <div class="form-group">
                                    <label class="form-label" for="email-address-1">Number of Living Rooms</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="living_count" name="living_count" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-xxl-6">
                                <div class="form-group">
                                    <label class="form-label" for="email-address-1">Number of Bathrooms</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="b_rooms_count" name="b_rooms_count" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="default-textarea">Note</label>
                                    <div class="form-control-wrap">
                                        <textarea class="form-control no-resize" id="note" name="note">note</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-danger btn-lg" data-bs-dismiss="modal">Close</button>
                    <input type="button" onclick="$('#add-room-category').submit();" class="btn btn-lg btn-primary" id="save_room" name="save_room" value="Save Room Category">
                </div>
            </div>
        </div>
    </div>

    <div class="modal hide fade" role="dialog" aria-hidden="true" id="modaledit_room_category">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title"> Edit Room Category</h5>
                </div>
                <div class="modal-body" id="">
                    <form action="{{route('management/edit_room_category/save')}}" method="post" id="edit_room_category_save" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="e_category_id" id="e_category_id">
                        <div class="row gy-4">
                            <div class="col-md-6 col-lg-6 col-xxl-6">
                                <div class="form-group">
                                    <label class="form-label" for="full-name">Room Type</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="ec_room_type" name="ec_room_type" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-xxl-6">
                                <div class="form-group">
                                    <label class="form-label" for="email-address-1">Room Name</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="e_room_name" name="e_room_name" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-xxl-6">
                                <div class="form-group">
                                    <label class="form-label" for="email-address-1">Custom Name (optional)</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="e_custom_name" name="e_custom_name">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-xxl-6">
                                <div class="form-group">
                                    <label class="form-label">Smoking Policy</label>
                                    <div class="form-control-wrap">
                                        <select class="form-select js-select2" data-placeholder="Select multiple options" name="e_smoke" id="e_smoke">
                                            <option value="I have Smoking option">I have Smoking option</option>
                                            <option value="I have Non-Smoking option">I have Non-Smoking option</option>
                                            <option value="I have both Smoking and non-smoking options for this room type">I have both Smoking and non-smoking options for this room type</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-xxl-6">
                                <div class="form-group">
                                    <label class="form-label" for="email-address-1">Number of Rooms (of this type)</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="e_room_count" name="e_room_count" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-xxl-6">
                                <div class="form-group">
                                    <label class="form-label" for="email-address-1">Price</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="e_price" name="e_price" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-xxl-6">
                                <div class="form-group">
                                    <label class="form-label" for="email-address-1">Number of Bedrooms</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="e_bed_count" name="e_bed_count" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-xxl-6">
                                <div class="form-group">
                                    <label class="form-label" for="email-address-1">Number of Living Rooms</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="e_living_count" name="e_living_count" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-xxl-6">
                                <div class="form-group">
                                    <label class="form-label" for="email-address-1">Number of Bathrooms</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="e_b_rooms_count" name="e_b_rooms_count" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="default-textarea">Note</label>
                                    <div class="form-control-wrap">
                                        <textarea class="form-control no-resize" id="e_note" name="e_note">note</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12" id="category-edit-attchment">
                                <div class="form-group">
                                    <label class="form-label" for="full-name-12">Upload Photo</label>
                                    <div class="col-sm-12" id="att-55">
                                        <img src="{{asset('images/gallery/thumb/15.jpg')}}" class="img-fluid" alt="">
                                        <br>
                                        <button type="button" class="waves-effect waves-light btn btn-dark btn-xs btn-block mb-5" onclick="category_attachment_change()"><i class="fa fa-trash"></i> Change</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer bg-light">
                    <div class="form-group">
                        <button type="button" class="btn btn-danger btn-lg" data-bs-dismiss="modal">Close</button>
                        <button type="button" onclick="$('#edit_room_category_save').submit();" class="btn btn-lg btn-primary">Save Category</button>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <div class="modal hide fade" role="dialog" aria-hidden="true" id="add_rooms_repairs">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title"> Room Rapair</h5>
                </div>
                <input type="hidden" value="{{$room->id}}" name="hotel_id_a" id="hotel_id_a">
                <div class="modal-body" id="">
                    <div class="row g-4">

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label" for="email-address-1">Select Date Range</label>
                                    <div class="form-control-wrap">
                                        <input type="text" id="daterange" name="daterange" />
                                        <div class="form-control-wrap">


                                        </div>

                                    </div>

                                </div>
                            </div>

                    </div>

                </div>
                <div class="modal-footer bg-light">
                    <div class="form-group">
                        <button type="button" class="btn btn-danger btn-lg" data-bs-dismiss="modal">Close</button>

                        <button type="button" id="checkRoomBookings"  class="btn btn-lg btn-primary" >Add Rapair </button>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <div class="modal fade" tabindex="-1" id="modal-edit-reapair_end_date">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title">Repair</h5>
                </div>
                <div class="modal-body">
                    <form action="{{ route('management/room/rapair/complete') }}" method="post" id="edit_repair_end_date" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="form-control" id="edit-r-id-input" name="edit-r-id-input">

                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label" for="card_chagers_lkr">Update End date</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control date-picker" data-date-format="yyyy-mm-dd" id="edit-r-date-input" name="edit-r-date-input" required readonly>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-light">
                    <div class="form-group">
                        <button type="button" class="btn btn-danger btn-lg" data-bs-dismiss="modal">Close</button>
                        <button type="button" onclick="$('#edit_repair_end_date').submit();" class="btn btn-lg btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>



{{--    <div class="modal hide fade" role="dialog" aria-hidden="true" id="modale_add_price_category">--}}
{{--        <div class="modal-dialog" role="document">--}}
{{--            <div class="modal-content">--}}
{{--                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">--}}
{{--                    <em class="icon ni ni-cross"></em>--}}
{{--                </a>--}}
{{--                <div class="modal-header">--}}
{{--                    <h5 class="modal-title"> Add Price Category</h5>--}}
{{--                </div>--}}
{{--                <div class="modal-body" id="">--}}
{{--                    <form action="{{route('management/edit_room_category/save')}}" method="post" id="edit_room_category_save" enctype="multipart/form-data">--}}
{{--                        @csrf--}}
{{--                        <input type="hidden" name="e_category_id" id="e_category_id">--}}
{{--                        <div class="row gy-4">--}}


{{--                            <div class="col-md-6 col-lg-6 col-xxl-6">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label class="form-label" for="email-address-1">Date Range</label>--}}
{{--                                    <div class="form-control-wrap">--}}
{{--                                        <input type="text" class="form-control" id="e_living_count" name="e_living_count" required>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-6 col-lg-6 col-xxl-6">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label class="form-label" for="email-address-1">Price</label>--}}
{{--                                    <div class="form-control-wrap">--}}
{{--                                        <input type="text" class="form-control" id="e_b_rooms_count" name="e_b_rooms_count" required>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                        </div>--}}

{{--                    </form>--}}
{{--                </div>--}}
{{--                <div class="modal-footer bg-light">--}}
{{--                    <div class="form-group">--}}
{{--                        <button type="button" class="btn btn-danger btn-lg" data-bs-dismiss="modal">Close</button>--}}
{{--                        <button type="button" onclick="$('#edit_room_category_save').submit();" class="btn btn-lg btn-primary">Save Category</button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

@endsection

@section('script')
    <script>

        $(document).ready(function(){
            $('#edit_room_save').on('submit', function(e){

                e.preventDefault();
                var selectedDateRange = $('#daterange').val();
                var dates = selectedDateRange.split(' - ');
                var startDate = dates[0]; // Contains the start date
                var endDate = dates[1];

                var form = $(this);
                var formData = new FormData($(this)[0]);
                var url = form.attr('action');

                var room_number =  $('#e_room_number').val();
                var room_type =  $('#e_room_type').val();
                var room_category =  $('#e_room_category').val();
                var repair_status = $('#e_repair_status').val();

                if(room_number != '' && room_type != '' && room_category != '') {
                    $.ajax({
                        type: "POST",
                        processData: false,
                        contentType: false,
                        url: url,
                        data: formData, // serializes the form's elements.
                        success: function (data) {

                            console.log(data);
                            var action_buton ='<a class="btn btn-trigger btn-icon updateRecordButton" data-roomid="'+data.get_room.id+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Room"><em class="icon ni ni-pen2"></em></a>\n' +
                                '\n' +
                                '                                            <div class="dropdown">\n' +
                                '                                                <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown" aria-expanded="false"><em class="icon ni ni-sign-xrp-new-alt" title="Delete Room"></em></a>\n' +
                                '                                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs" style="">\n' +
                                '                                                    <ul class="link-list-plain">\n' +
                                '                                                        <li><a class="deleteRecordButton" data-roomid="'+data.get_room.id+'">Yes</a></li>\n' +
                                '                                                        <li><a>No</a></li>\n' +
                                '                                                    </ul>\n' +
                                '                                                </div>\n' +
                                '                                            </div>';
                            // var action_buton ='<a class="btn btn-trigger btn-icon updateRecordButton" data-roomid="'+data.get_room.id+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Room"><em class="icon ni ni-pen2"></em></a>\n' +
                            //     '
                            //
                            //
                            //
                            //
                            //
                            //     <a class="btn btn-trigger btn-icon deleteRecordButton" data-roomid="'+data.get_room.id+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Room"><em class="icon ni ni-sign-xrp-new-alt"></em></a>';

                            var re_status = '';



                            if(data.get_room.reapair == 'repair'){

                                re_status = '<span class="badge badge-dot bg-danger">Repair</span>';
                            }else{
                                re_status = '<span class="badge badge-dot bg-success">complete</span>';
                            }




                            var s_date = (data.get_room.reapair === 'repair') ? startDate : '<span>--</span>';
                            var en_date = (data.get_room.reapair === 'repair') ? endDate : '<span>--</span>';





                            var table_data = [data.get_room.room_number,data.get_room.room_type,data.get_room.room_category.category,data.get_room.check_list_layout!=null?data.get_room.check_list_layout.name:'-',s_date,en_date,re_status, action_buton];
                            NioApp.DataTable.row(global_theRowObject).data(table_data).draw(false);

                            $('#modal-edit-rooms').modal('hide');
                            NioApp.Toast('Successfully Edit Room', 'success',{position: 'top-right'});
                            location.reload();
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
            NioApp.DataTable = $('#Room-table').DataTable(attr);
            $.fn.DataTable.ext.pager.numbers_length = 7;
            $('.dt-export-title').text(export_title);

        });
        $("#add_rooms").submit(function(e) {

            e.preventDefault();// avoid to execute the actual submit of the form.

            var selectedDateRange = $('#daterange1').val();
            var dates = selectedDateRange.split(' - ');
            var startDate = dates[0]; // Contains the start date
            var endDate = dates[1];
            $('#a_start_date').val(startDate);
            $('#a_end_date').val(endDate);
            console.log(startDate);


            var form = $(this);

            var formData = new FormData($(this)[0]);
            var url = form.attr('action');

            var room_number =  $('#room_number').val();
            var room_type =  $('#room_type').val();
            var room_category =  $('#room_category').val();
            var repair_status =  $('#repair_status').val();
            if(room_number != '' && room_type != '' && room_category != '') {
                $.ajax({
                    type: "POST",
                    processData: false,
                    contentType: false,
                    url: url,
                    data: formData, // serializes the form's elements.
                    success: function (data) {
                        // $('#add_user_save input:checkbox').prop('checked',false).prop('disabled',true);
                        // $('.handle_disable').prop('disabled',false);
                        $(':input', '#add_rooms')
                            .not(':button, :submit, :reset, :hidden')
                            .val('')
                            .prop('selected', false);
                        console.log(data);
                        var action_buton ='<a class="btn btn-trigger btn-icon updateRecordButton" data-roomid="'+data.rooms.id+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Room"><em class="icon ni ni-pen2"></em></a>\n' +
                            '\n' +
                            '                                            <div class="dropdown">\n' +
                            '                                                <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown" aria-expanded="false"><em class="icon ni ni-sign-xrp-new-alt" title="Delete Room"></em></a>\n' +
                            '                                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs" style="">\n' +
                            '                                                    <ul class="link-list-plain">\n' +
                            '                                                        <li><a class="deleteRecordButton" data-roomid="'+data.rooms.id+'">Yes</a></li>\n' +
                            '                                                        <li><a>No</a></li>\n' +
                            '                                                    </ul>\n' +
                            '                                                </div>\n' +
                            '                                            </div>';
                        // var action_buton ='<a class="btn btn-trigger btn-icon updateRecordButton" data-roomid="'+data.rooms.id+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Room"><em class="icon ni ni-pen2"></em></a>\n' +
                        //     '              <a class="btn btn-trigger btn-icon deleteRecordButton" data-roomid="'+data.rooms.id+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Room"><em class="icon ni ni-sign-xrp-new-alt"></em></a>';



                        var re_status = '';



                        if(data.rooms.reapair == 'repair'){
                            console.log(data.rooms.reapair);
                            re_status = '<span class="badge badge-dot bg-danger">Repair</span>';
                        }else {
                            re_status = '<span class="badge badge-dot bg-success">complete</span>';
                        }




                        var s_date = (data.rooms.reapair === 'repair') ? startDate : '<span>--</span>';
                        var en_date = (data.rooms.reapair === 'repair') ? endDate : '<span>--</span>';




                        var table_data = [data.rooms.room_number,data.rooms.room_type,data.rooms.room_category.category,data.rooms.check_list_layout!=null?data.rooms.check_list_layout.name:'-',s_date,en_date,re_status,action_buton];
                        {{--// // console.log(table_data);--}}
                        {{--// //--}}
                        NioApp.DataTable.row.add(table_data);
                        NioApp.DataTable.draw()

                        $('#modal-add-rooms').modal('hide');
                        NioApp.Toast('Successfully Add Room', 'success',{position: 'top-right'});
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
                var room_id = $(this).data('roomid');
                global_theRowObject=theRowObject;
                console.log(data);
                $.ajax({
                    type:'POST',
                    url:'{{ route('management/Room/get_edit_rooms_details') }}',
                    headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                    data: {
                        'room_id' : room_id,
                    },
                    success:function(data){
                        console.log(data);
                        $('#e_room_id').val(data.edit_room.id);
                        $('#add_room_repair').attr('data-roomid',data.edit_room.id);
                        $('#e_room_number').val(data.edit_room.room_number);
                        $('#e_room_type').val(data.edit_room.room_type);
                        $('#e_room_category').val(data.edit_room.room_category_id).change();
                        $('#e_checkList_layout').val(data.edit_room.check_list_layout_id).change();
                        $('#e_repair_status').val(data.edit_room.reapair);


                        $('#modal-edit-rooms').modal('show');
                    }
                });

            }
            if ( $(this).hasClass('deleteRecordButton') ) {
                var data = NioApp.DataTable.row($(this).parents('tr')).data(); //Retrieve row data
                var tr = $(this).closest('tr'); //Find DataTables table row
                var theRowObject = NioApp.DataTable.row(tr); //Get DataTables row object
                var room_id = $(this).data('roomid');
                // global_theRowObject2=theRowObject;
                $.ajax({
                    type:'POST',
                    url:'{{ route('management/room/delete') }}',
                    headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                    data: {
                        'room_id' : room_id,
                    },
                    success:function(data){
                        if(data.success){
                            NioApp.Toast('Successfully Deleted Room', 'success',{position: 'top-right'});
                            NioApp.DataTable.row(theRowObject).remove().draw();
                        }else{
                            NioApp.Toast(data.error, 'warning',{position: 'top-right'});
                        }
                    }

                });

            }
        });
        function category_attachment_change(){
            $('#category-edit-attchment').html('');

            var image_change =
                '                            <div class="form-group">\n' +
                '                                <label class="form-label" for="email-address-12">Upload Photo</label>\n' +
                '                                <div class="form-control-wrap">\n' +
                '                                    <input type="file" class="form-control" id="e_image" name="e_image">\n' +
                '                                </div>\n' +

                '                        </div>';

            $('#category-edit-attchment').html(image_change);
        }
        function edit_room_category(room_id) {
            $.ajax({
                type:'POST',
                url:'{{ route('management/room/get_edit_room_category_details') }}',
                headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                data: {
                    'room_id' : room_id,
                },
                success:function(data){
                    let category_att='';
                    $('#e_category_id').val(data.room_category.id);
                    $('#ec_room_type').val(data.room_category.room_type);
                    $('#e_room_name').val(data.room_category.category);
                    $('#e_custom_name').val(data.room_category.custome_name);
                    $('#e_smoke').val(data.room_category.smoking_policy);
                    $('#e_room_count').val(data.room_category.room_count);
                    $('#e_bed_count').val(data.room_category.num_of_bed);
                    $('#e_living_count').val(data.room_category.num_of_living_rooms);
                    $('#e_b_rooms_count').val(data.room_category.num_of_bathroom);
                    $('#e_price').val(data.room_category.price);
                    $('#e_note').val(data.room_category.note);
                    category_att += '<div class="col-sm-12" id="att-">\n' +
                        '        <img src="{{asset("storage")}}/' + data.room_category.image + '" class="img-fluid" alt="">\n' +
                        '        <br>\n' +
                        '        <button type="button" class="waves-effect waves-light btn btn-dark btn-xs btn-block mb-5" onclick="category_attachment_change();"><i class="fa fa-trash"></i> Change</button>\n' +
                        '        </div>';
                    $('#category-edit-attchment').html(category_att);
                    $('#modaledit_room_category').modal('show');
                }

            });
        }



        $("#add-room-category").submit(function(e) {

            e.preventDefault(); // avoid to execute the actual submit of the form.
            var form = $(this);
            var formData = new FormData($(this)[0]);
            var url = form.attr('action');

            var room_hotel_id =  $('#room_hotel_id').val();
            var category_name =  $('#category_name').val();

            if(room_hotel_id != '' && category_name != '') {
                $.ajax({
                    type: "POST",
                    processData: false,
                    contentType: false,
                    url: url,
                    data: formData, // serializes the form's elements.
                    success: function (data) {
                        // $('#add_user_save input:checkbox').prop('checked',false).prop('disabled',true);
                        // $('.handle_disable').prop('disabled',false);
                        $(':input', '#add-room-category')
                            .not(':button, :submit, :reset, :hidden')
                            .val('')
                            .prop('selected', false);
                        console.log(data);
                        var category_row ='<div class="card-inner card-inner-md">\n' +
                            '                            <div class="user-card">\n' +
                            '                                <div class="user-avatar bg-primary-dim">\n' +
                            '                                    <span>AB</span>\n' +
                            '                                </div>\n' +
                            '                                <div class="user-info">\n' +
                            '                                    <span class="lead-text">'+data.room_category.category+'</span>\n' +
                            '                                    <span class="sub-text">have '+data.room_category.room_count+' Rooms, And Assigned 0 Rooms</span>\n' +
                            '                                </div>\n' +
                            '                                <div class="user-action">\n' +
                            '                                    <div class="drodown">\n' +
                            '                                        <a href="#" class="dropdown-toggle btn btn-icon btn-trigger me-n1" data-bs-toggle="dropdown" aria-expanded="false"><em class="icon ni ni-more-h"></em></a>\n' +
                            '                                        <div class="dropdown-menu dropdown-menu-end">\n' +
                            '                                            <ul class="link-list-opt no-bdr">\n' +
                            '                                                <li><a onclick="edit_room_category(\''+data.room_category.id+'\')"><em class="icon ni ni-setting"></em><span>Edit Room Category</span></a></li>\n' +
                            '                                            </ul>\n' +
                            '                                        </div>\n' +
                            '                                    </div>\n' +
                            '                                </div>\n' +
                            '                            </div>\n' +
                            '                        </div>';

                        $('#room_category_list').append(category_row);

                        var category_add = '<option value="'+data.room_category.id+'">'+data.room_category.category+'</option>';
                        $('#room_category').append(category_add);
                        $('#e_room_category').append(category_add);

                        $('#modalDefault').modal('hide');
                        NioApp.Toast('Successfully Add Room Category', 'success',{position: 'top-right'});
                    }
                });
            }
            else{
                NioApp.Toast('Required All Fields', 'error', {position: 'top-right'});
            }
        });



        // document.getElementById("add_price_category").addEventListener("click", function() {
        //
        //     $('#modale_add_price_category').modal('show')
        //
        //
        // });

        $(document).ready(function () {
            // Function to display the modal and handle room ID logic
            function displaydaterange(roomId) {
                // Display the modal
                $('#add_rooms_repairs').modal('show');
                console.log('Selected Room ID:', roomId);

                // Initialize date range picker
                $('#daterange').daterangepicker({

                    // Date range picker configurations/options
                });

                // Event listener for checking room bookings
                $('#checkRoomBookings').on('click', function () {
                    var dateRange = $('#daterange').val().split(' - ');
                    var start_date = dateRange[0];
                    var end_date = dateRange[1];

                    // Perform AJAX request to check bookings within the selected range for the room
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('management/room/check_room_availble') }}',
                        headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                        data: {
                            'room_id': roomId,
                            'start_date': start_date,
                            'end_date': end_date
                        },
                        success: function (data) {
                            console.log('Room has bookings:', data.has_bookings);
                            // Handle the response data here (display a message or take action based on bookings)
                            if (!data.has_bookings) {
                                $('#addRepairButton').show();
                                NioApp.Toast('This Room Add Rapair', 'success',{position: 'top-right'});

                            } else {
                                $('#addRepairButton').hide();
                                NioApp.Toast('This Room Has Booking This Date', 'error',{position: 'top-right'});
                            }
                        },
                        error: function (error) {
                            console.error('Error checking room bookings:', error);
                        }
                    });
                });
            }

            // Event addbutton click
            $('.add-room-repair').on('click', function () {
                var room_id = $(this).data('roomid');
                displaydaterange(room_id);
                console.log(room_id)
            });




            $('.completed-room-repair').on('click', function () {
                var roomId = $(this).data('roomid');

                $.ajax({
                    type: 'POST',
                    url: '',
                    headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},// Replace with your server endpoint
                    data: {
                        room_id: roomId,

                    },
                    success: function(response) {

                        console.log('Data sent successfully');

                    },
                    error: function(error) {

                        console.error('Error sending data:', error);
                    }
                });
            });


        });
        $(document).ready(function() {
            $('#e_repair_status').change(function() {
                var selectedValue = $(this).val();

                // Show/hide button based on selected value
                if (selectedValue === 'complete') {
                    $('#add_room_repair').hide();
                } else {

                    $('#add_room_repair').show();
                }
            });

        });
        function extend_end_date_load(id, end_date){
            console.log("ID:", id);
            console.log("End Date:", end_date);
            $('#edit-r-id-input').val(id);
            $('#edit-r-date-input').val(end_date);
            $('#modal-edit-reapair_end_date').modal('show');
        }


        $(document).ready(function() {
            $('#repair_status').change(function() {
                var selectedValue = $(this).val();

                // Show/hide button based on selected value
                if (selectedValue === 'complete') {
                    $('#room_repair').hide();
                } else {

                    $('#room_repair').show();
                }
            });



        });

        $(document).ready(function() {
            $('#daterange1').daterangepicker({
                opens: 'top'
            });
        });



        $(document).ready(function() {
            $("#edit_repair_end_date").submit(function(e) {
                e.preventDefault(); // prevent the actual submit of the form
                var form = $(this);
                var formData = new FormData(form[0]); // simplified accessing form data

                var url = form.attr('action');

                $.ajax({
                    type: "POST",
                    processData: false,
                    contentType: false,
                    url: url,
                    headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                    data: formData,
                    success: function (data) {
                        $('#modal-edit-reapair_end_date').modal('hide');
                        location.reload();
                    }
                });
            });
        });

    </script>


@endsection

