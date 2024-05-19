@extends('management.lay' )

@section('title' , __(''))

@section('style')

@endsection

@section('content')
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Users</h3>
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
                                <a href="#" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add-user"><em class="icon ni ni-plus"></em><span>Add User</span></a>
                            </li>
                            <li class="nk-block-tools-opt d-block d-sm-none">
                                <a href="#" class="btn btn-icon btn-primary"><em class="icon ni ni-plus"></em></a>
                            </li>
                            <li class="nk-block-tools-opt d-none d-sm-block">
                                <a href="#" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-assign-user"><em class="icon ni ni-plus"></em><span>Assign User</span></a>
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

                <table class="datatable-init-export nowrap table" data-export-title="Export" id="user-table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Hotel Chain</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($hotel->privilege as $privilege)
                        @if($privilege->user->status == 'Active')
                        <tr>
                            <td>{{$privilege->user->name}} {{$privilege->user->lname}}</td>
                            <td>{{$privilege->user->email}}</td>
                            <td>{{$hotel->hotel_chain->name}}</td>
                            <td class="nk-tb-col nk-tb-col-tools">
                                <a class="btn btn-trigger btn-icon updateRecordButton" data-privilegeid="{{$privilege->id}}" data-userid="{{$privilege->user->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit User"><em class="icon ni ni-pen2"></em></a>
                                <a class="btn btn-trigger btn-icon deleteRecordButton" data-privilegeid="{{$privilege->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete User"><em class="icon ni ni-sign-xrp-new-alt"></em></a>
                                <a class="btn btn-trigger btn-icon" onclick="view_privilege_details('{{$privilege->user->id}}','{{$hotel->id}}');" data-bs-toggle="tooltip" data-bs-placement="top" title="View Privilege"><em class="icon ni ni-list-index-fill"></em></a>
                            </td>
                        </tr>
                        @endif
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="modal-view-privileges">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h6 class="modal-title" id="modal-view-grn-item-title">Privileges</h6>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Features</th>
                            <th scope="col">View</th>
                            <th scope="col">Add</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                            <th scope="col">Widgets</th>
                        </tr>
                        </thead>
                        <tbody id="modal-view-privileges-body">
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer bg-light">
                    <div class="form-group">
                        <button type="button" class="btn btn-danger btn-lg" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal hide fade" role="dialog" aria-hidden="true" id="modal-add-user">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title"> Add User</h5>
                </div>
                <div class="modal-body" id="recipe_ingredient_edit">
                    <div class="card-head">
                        <h5 class="card-title">Personal Information</h5>
                    </div>
                    <form action="{{ route('management/user/save') }}" method="post" id="add_user_save" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="{{$hotel->id}}" name="hotel_id_a" id="hotel_id_a">
                        <input type="hidden" value="{{$hotel->hotel_chain_id}}" name="hotel_chain_id_a" id="hotel_chain_id_a">
                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="email-address-1">First Name</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="fname" name="fname" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="email-address-1">Last Name</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="lname" name="lname" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-row-bg">
                                    <div class="row g-4">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="email-address-1">Email</label>
                                                <div class="form-control-wrap">
                                                    <input type="email" class="form-control" id="email" name="email" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="email-address-1">Password</label>
                                                <div class="form-control-wrap">
                                                    <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password">
                                                        <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                        <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                                    </a>
                                                    <input type="password" class="form-control" id="password" name="password" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-row-bg">
                                    <div class="row g-4">
                                        <div class="col-lg-12">
                                            <div class="card-head">
                                                <h5 class="card-title">Add Privilege</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-row-bg">
                                    <div class="row g-4">
                                        <div class="col-lg-12">
                                            <table class="table">
                                                <thead class="thead-dark">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Features</th>
                                                    <th scope="col">View</th>
                                                    <th scope="col">Add</th>
                                                    <th scope="col">Edit</th>
                                                    <th scope="col">Delete</th>
                                                    <th scope="col">Widget</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td>Recipe</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="customCheck1" name="recipe_v">
                                                            <label class="custom-control-label" for="customCheck1"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck2" name="recipe_a" disabled>
                                                            <label class="custom-control-label" for="customCheck2"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck3" name="recipe_e" disabled>
                                                            <label class="custom-control-label" for="customCheck3"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck4" name="recipe_d" disabled>
                                                            <label class="custom-control-label" for="customCheck4"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">2</th>
                                                    <td>Stock</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="customCheck5" name="stock_v">
                                                            <label class="custom-control-label" for="customCheck5"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck6" name="stock_a" disabled>
                                                            <label class="custom-control-label" for="customCheck6"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck7" name="stock_e" disabled>
                                                            <label class="custom-control-label" for="customCheck7"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck8" name="stock_d" disabled>
                                                            <label class="custom-control-label" for="customCheck8"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">3</th>
                                                    <td>GRN</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="customCheck9" name="grn_v">
                                                            <label class="custom-control-label" for="customCheck9"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck10" name="grn_a" disabled>
                                                            <label class="custom-control-label" for="customCheck10"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck11" name="grn_e" disabled>
                                                            <label class="custom-control-label" for="customCheck11"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck12" name="grn_d" disabled>
                                                            <label class="custom-control-label" for="customCheck12"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck65" name="grn_w">
                                                            <label class="custom-control-label" for="customCheck65"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">4</th>
                                                    <td>POS</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="customCheck13" name="pos_v">
                                                            <label class="custom-control-label" for="customCheck13"></label>
                                                        </div></td>
                                                    <td> - </td>
                                                    <td> - </td>
                                                    <td> - </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck63" name="pos_w">
                                                            <label class="custom-control-label" for="customCheck63"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">5</th>
                                                    <td>Waste</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="customCheck17" name="waste_v">
                                                            <label class="custom-control-label" for="customCheck17"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck18" name="waste_a" disabled>
                                                            <label class="custom-control-label" for="customCheck18"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck19" name="waste_e" disabled>
                                                            <label class="custom-control-label" for="customCheck19"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck20" name="waste_d" disabled>
                                                            <label class="custom-control-label" for="customCheck20"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">6</th>
                                                    <td>Past orders</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="customCheck21" name="past_v">
                                                            <label class="custom-control-label" for="customCheck21"></label>
                                                        </div></td>
                                                    <td> - </td>
                                                    <td> -
                                                    </td>
                                                    <td> -
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">7</th>
                                                    <td>Inventory Bill/Category</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="customCheck22" name="inventory_v">
                                                            <label class="custom-control-label" for="customCheck22"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck23" name="inventory_a" disabled>
                                                            <label class="custom-control-label" for="customCheck23"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck24" name="inventory_e" disabled>
                                                            <label class="custom-control-label" for="customCheck24"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                      -
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">8</th>
                                                    <td>Inventory Damage</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="customCheck25" name="inventory_damage_v">
                                                            <label class="custom-control-label" for="customCheck25"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck26" name="inventory_damage_a" disabled>
                                                            <label class="custom-control-label" for="customCheck26"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck27" name="inventory_damage_e" disabled>
                                                            <label class="custom-control-label" for="customCheck27"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck28" name="inventory_damage_d" disabled>
                                                            <label class="custom-control-label" for="customCheck28"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">9</th>
                                                    <td>KOT</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="customCheck29" name="kot_v">
                                                            <label class="custom-control-label" for="customCheck29"></label>
                                                        </div></td>
                                                    <td> - </td>
                                                    <td> -
                                                    </td>
                                                    <td> -
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">10</th>
                                                    <td>Reservation</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="customCheck30" name="reservation_v">
                                                            <label class="custom-control-label" for="customCheck30"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck31" name="reservation_a" disabled>
                                                            <label class="custom-control-label" for="customCheck31"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck32" name="reservation_e" disabled>
                                                            <label class="custom-control-label" for="customCheck32"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck33" name="reservation_d" disabled>
                                                            <label class="custom-control-label" for="customCheck33"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck64" name="reservation_w">
                                                            <label class="custom-control-label" for="customCheck64"></label>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">11</th>
                                                    <td>Maintenance</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="customCheck34" name="maintenance_v">
                                                            <label class="custom-control-label" for="customCheck34"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck35" name="maintenance_a" disabled>
                                                            <label class="custom-control-label" for="customCheck35"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck36" name="maintenance_e" disabled>
                                                            <label class="custom-control-label" for="customCheck36"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck37" name="maintenance_d" disabled>
                                                            <label class="custom-control-label" for="customCheck37"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck60" name="maintenance_w">
                                                            <label class="custom-control-label" for="customCheck60"></label>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">12</th>
                                                    <td>House Keeping</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="customCheck38" name="housekeeping_v">
                                                            <label class="custom-control-label" for="customCheck38"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck39" name="housekeeping_a" disabled>
                                                            <label class="custom-control-label" for="customCheck39"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck40" name="housekeeping_e" disabled>
                                                            <label class="custom-control-label" for="customCheck40"></label>
                                                        </div>
                                                    </td>
                                                    <td> -
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck61" name="housekeeping_w">
                                                            <label class="custom-control-label" for="customCheck61"></label>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">13</th>
                                                    <td>Expenses</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="customCheck41" name="expenses_v">
                                                            <label class="custom-control-label" for="customCheck41"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck42" name="expenses_a" disabled>
                                                            <label class="custom-control-label" for="customCheck42"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck43" name="expenses_e" disabled>
                                                            <label class="custom-control-label" for="customCheck43"></label>
                                                        </div>
                                                    </td>
                                                    <td> -
                                                    </td>

                                                </tr>

                                                <tr>
                                                    <th scope="row">14</th>
                                                    <td>Cashbooks</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="customCheck44" name="cashbook_v">
                                                            <label class="custom-control-label" for="customCheck44"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck45" name="cashbook_a" disabled>
                                                            <label class="custom-control-label" for="customCheck45"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck46" name="cashbook_e" disabled>
                                                            <label class="custom-control-label" for="customCheck46"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck47" name="cashbook_d" disabled>
                                                            <label class="custom-control-label" for="customCheck47"></label>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <tr>
                                                    <th scope="row">15</th>
                                                    <td>Utilities</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="customCheck48" name="utility_v">
                                                            <label class="custom-control-label" for="customCheck48"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck49" name="utility_a" disabled>
                                                            <label class="custom-control-label" for="customCheck49"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck50" name="utility_e" disabled>
                                                            <label class="custom-control-label" for="customCheck50"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck51" name="utility_d" disabled>
                                                            <label class="custom-control-label" for="customCheck51"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck59" name="utility_w">
                                                            <label class="custom-control-label" for="customCheck59"></label>
                                                        </div>
                                                    </td>
                                                </tr>

                                                 <tr>
                                                    <th scope="row">16</th>
                                                    <td>Booking</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="customCheck52" name="booking_v">
                                                            <label class="custom-control-label" for="customCheck52"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck53" name="booking_a" disabled>
                                                            <label class="custom-control-label" for="customCheck53"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck54" name="booking_e" disabled>
                                                            <label class="custom-control-label" for="customCheck54"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck55" name="booking_d" disabled>
                                                            <label class="custom-control-label" for="customCheck55"></label>
                                                        </div>
                                                    </td>
                                                     <td>
                                                         <div class="custom-control custom-checkbox">
                                                             <input type="checkbox" class="custom-control-input" id="customCheck62" name="booking_w">
                                                             <label class="custom-control-label" for="customCheck62"></label>
                                                         </div>
                                                     </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">17</th>
                                                    <td>Invoice</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="customCheck56" name="invoice_v">
                                                            <label class="custom-control-label" for="customCheck56"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck57" name="invoice_a" disabled>
                                                            <label class="custom-control-label" for="customCheck57"></label>
                                                        </div></td>
                                                    <td>
                                                       -
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck58" name="invoice_d" disabled>
                                                            <label class="custom-control-label" for="customCheck58"></label>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">18</th>
                                                    <td>Supplier</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="customCheck66" name="supplier_v">
                                                            <label class="custom-control-label" for="customCheck66"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck67" name="supplier_a" disabled>
                                                            <label class="custom-control-label" for="customCheck67"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck68" name="supplier_e" disabled>
                                                            <label class="custom-control-label" for="customCheck68"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck69" name="supplier_d" disabled>
                                                            <label class="custom-control-label" for="customCheck69"></label>
                                                        </div>
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <th scope="row">19</th>
                                                    <td>Agency & Guide</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="customCheck70" name="agencyGuide_v">
                                                            <label class="custom-control-label" for="customCheck70"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck71" name="agencyGuide_a" disabled>
                                                            <label class="custom-control-label" for="customCheck71"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck72" name="agencyGuide_e" disabled>
                                                            <label class="custom-control-label" for="customCheck72"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck73" name="agencyGuide_d" disabled>
                                                            <label class="custom-control-label" for="customCheck73"></label>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">20</th>
                                                    <td>Customer</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="customCheck80" name="customer_v">
                                                            <label class="custom-control-label" for="customCheck80"></label>
                                                        </div></td>
                                                    <td>
                                                        -
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck81" name="customer_e" disabled>
                                                            <label class="custom-control-label" for="customCheck81"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        -
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">21</th>
                                                    <td>Other Income</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="customCheck76" name="other_income_v">
                                                            <label class="custom-control-label" for="customCheck76"></label>
                                                        </div></td>
                                                    <td>
                                                         <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck77" name="other_income_a" disabled>
                                                            <label class="custom-control-label" for="customCheck77"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck78" name="other_income_e" disabled>
                                                            <label class="custom-control-label" for="customCheck78"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck79" name="other_income_d" disabled>
                                                            <label class="custom-control-label" for="customCheck79"></label>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">22</th>
                                                    <td>Resturant</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="customCheck80" name="resturent_v">
                                                            <label class="custom-control-label" for="customCheck83"></label>
                                                        </div></td>
                                                    <td>
                                                        -
                                                    </td>
                                                    <td>
                                                        -
                                                    </td>
                                                    <td>
                                                        -
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">23</th>
                                                    <td>Promotions</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="customCheck85" name="promotions_v">
                                                            <label class="custom-control-label" for="customCheck85"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck86" name="promotions_a" disabled>
                                                            <label class="custom-control-label" for="customCheck86"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck87" name="promotions_e" disabled>
                                                            <label class="custom-control-label" for="customCheck87"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck88" name="promotions_d" disabled>
                                                            <label class="custom-control-label" for="customCheck88"></label>
                                                        </div>
                                                    </td>
                                                </tr>




                                                </tbody>
                                            </table>
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
                        <button type="button" onclick="$('#add_user_save').submit();" class="btn btn-lg btn-primary">Save User</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal hide fade" role="dialog" aria-hidden="true" id="modal-edit-user">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title"> Edit User</h5>
                </div>
                <div class="modal-body" id="recipe_ingredient_edit">
                    <form action="{{route('management/edit_user/save')}}" method="post" id="edit_user_save">
                        @csrf
                        <input type="hidden" name="edit_user_id" value="" id="edit_user_id">
                        <input type="hidden" name="edit_user_privilege_id" value="" id="edit_user_privilege_id">
                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="email-address-1">First Name</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="e_fname" name="e_fname" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="email-address-1">Last Name</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="e_lname" name="e_lname" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-row-bg">
                                    <div class="row g-4">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="email-address-1">Email</label>
                                                <div class="form-control-wrap">
                                                    <input type="email" class="form-control" id="e_email" name="e_email" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-row-bg">
                                    <div class="row g-4">
                                        <div class="col-lg-12">
                                            <div class="card-head">
                                                <h5 class="card-title">Edit Privilege</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-row-bg">
                                    <div class="row g-4">
                                        <div class="col-lg-12">
                                            <table class="table">
                                                <thead class="thead-dark">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Features</th>
                                                    <th scope="col">View</th>
                                                    <th scope="col">Add</th>
                                                    <th scope="col">Edit</th>
                                                    <th scope="col">Delete</th>
                                                    <th scope="col">Widget</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td>Recipe</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="e_customCheck1" name="e_recipe_v">
                                                            <label class="custom-control-label" for="e_customCheck1"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck2" name="e_recipe_a" disabled>
                                                            <label class="custom-control-label" for="e_customCheck2"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck3" name="e_recipe_e" disabled>
                                                            <label class="custom-control-label" for="e_customCheck3"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck4" name="e_recipe_d" disabled>
                                                            <label class="custom-control-label" for="e_customCheck4"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">2</th>
                                                    <td>Stock</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="e_customCheck5" name="e_stock_v">
                                                            <label class="custom-control-label" for="e_customCheck5"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck6" name="e_stock_a" disabled>
                                                            <label class="custom-control-label" for="e_customCheck6"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck7" name="e_stock_e" disabled>
                                                            <label class="custom-control-label" for="e_customCheck7"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck8" name="e_stock_d" disabled>
                                                            <label class="custom-control-label" for="e_customCheck8"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">3</th>
                                                    <td>GRN</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="e_customCheck9" name="e_grn_v">
                                                            <label class="custom-control-label" for="e_customCheck9"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck10" name="e_grn_a" disabled>
                                                            <label class="custom-control-label" for="e_customCheck10"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck11" name="e_grn_e" disabled>
                                                            <label class="custom-control-label" for="e_customCheck11"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck12" name="e_grn_d" disabled>
                                                            <label class="custom-control-label" for="e_customCheck12"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck65" name="e_grn_w">
                                                            <label class="custom-control-label" for="e_customCheck65"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">4</th>
                                                    <td>POS</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="e_customCheck13" name="e_pos_v">
                                                            <label class="custom-control-label" for="e_customCheck13"></label>
                                                        </div></td>
                                                    <td> - </td>
                                                    <td> - </td>
                                                    <td> - </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck63" name="e_pos_w">
                                                            <label class="custom-control-label" for="e_customCheck63"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">5</th>
                                                    <td>Waste</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="e_customCheck17" name="e_waste_v">
                                                            <label class="custom-control-label" for="e_customCheck17"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck18" name="e_waste_a" disabled>
                                                            <label class="custom-control-label" for="e_customCheck18"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck19" name="e_waste_e" disabled>
                                                            <label class="custom-control-label" for="e_customCheck19"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck20" name="e_waste_d" disabled>
                                                            <label class="custom-control-label" for="e_customCheck20"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">6</th>
                                                    <td>Past orders</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="e_customCheck21" name="e_past_v">
                                                            <label class="custom-control-label" for="e_customCheck21"></label>
                                                        </div></td>
                                                    <td> - </td>
                                                    <td> -
                                                    </td>
                                                    <td> -
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">7</th>
                                                    <td>Inventory Bill/Category</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="e_customCheck22" name="e_inventory_v">
                                                            <label class="custom-control-label" for="e_customCheck22"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck23" name="e_inventory_a" disabled>
                                                            <label class="custom-control-label" for="e_customCheck23"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck24" name="e_inventory_e" disabled>
                                                            <label class="custom-control-label" for="e_customCheck24"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        -
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">8</th>
                                                    <td>Inventory Damage</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="e_customCheck25" name="e_inventory_damage_v">
                                                            <label class="custom-control-label" for="e_customCheck25"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck26" name="e_inventory_damage_a" disabled>
                                                            <label class="custom-control-label" for="e_customCheck26"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck27" name="e_inventory_damage_e" disabled>
                                                            <label class="custom-control-label" for="e_customCheck27"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck28" name="e_inventory_damage_d" disabled>
                                                            <label class="custom-control-label" for="e_customCheck28"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">9</th>
                                                    <td>KOT</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="e_customCheck29" name="e_kot_v">
                                                            <label class="custom-control-label" for="e_customCheck29"></label>
                                                        </div></td>
                                                    <td> - </td>
                                                    <td> -
                                                    </td>
                                                    <td> -
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">10</th>
                                                    <td>Reservation</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="e_customCheck30" name="e_reservation_v">
                                                            <label class="custom-control-label" for="e_customCheck30"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck31" name="e_reservation_a" disabled>
                                                            <label class="custom-control-label" for="e_customCheck31"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck32" name="e_reservation_e" disabled>
                                                            <label class="custom-control-label" for="e_customCheck32"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck33" name="e_reservation_d" disabled>
                                                            <label class="custom-control-label" for="e_customCheck33"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck64" name="e_reservation_w">
                                                            <label class="custom-control-label" for="e_customCheck64"></label>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">11</th>
                                                    <td>Maintenance</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="e_customCheck34" name="e_maintenance_v">
                                                            <label class="custom-control-label" for="e_customCheck34"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck35" name="e_maintenance_a" disabled>
                                                            <label class="custom-control-label" for="e_customCheck35"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck36" name="e_maintenance_e" disabled>
                                                            <label class="custom-control-label" for="e_customCheck36"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck37" name="e_maintenance_d" disabled>
                                                            <label class="custom-control-label" for="e_customCheck37"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck60" name="e_maintenance_w">
                                                            <label class="custom-control-label" for="e_customCheck60"></label>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">12</th>
                                                    <td>House Keeping</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="e_customCheck38" name="e_housekeeping_v">
                                                            <label class="custom-control-label" for="e_customCheck38"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck39" name="e_housekeeping_a" disabled>
                                                            <label class="custom-control-label" for="e_customCheck39"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck40" name="e_housekeeping_e" disabled>
                                                            <label class="custom-control-label" for="e_customCheck40"></label>
                                                        </div>
                                                    </td>
                                                    <td> - </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck61" name="e_housekeeping_w">
                                                            <label class="custom-control-label" for="e_customCheck61"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">13</th>
                                                    <td>Expenses</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="e_customCheck41" name="e_expenses_v">
                                                            <label class="custom-control-label" for="e_customCheck41"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck42" name="e_expenses_a" disabled>
                                                            <label class="custom-control-label" for="e_customCheck42"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck43" name="e_expenses_e" disabled>
                                                            <label class="custom-control-label" for="e_customCheck43"></label>
                                                        </div>
                                                    </td>
                                                    <td> -
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <th scope="row">14</th>
                                                    <td>Cashbooks</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="e_customCheck44" name="e_cashbook_v">
                                                            <label class="custom-control-label" for="e_customCheck44"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck45" name="e_cashbook_a" disabled>
                                                            <label class="custom-control-label" for="e_customCheck45"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck46" name="e_cashbook_e" disabled>
                                                            <label class="custom-control-label" for="e_customCheck46"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck47" name="e_cashbook_d" disabled>
                                                            <label class="custom-control-label" for="e_customCheck47"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">15</th>
                                                    <td>Utilities</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="e_customCheck48" name="e_utility_v">
                                                            <label class="custom-control-label" for="e_customCheck48"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck49" name="e_utility_a" disabled>
                                                            <label class="custom-control-label" for="e_customCheck49"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck50" name="e_utility_e" disabled>
                                                            <label class="custom-control-label" for="e_customCheck50"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck51" name="e_utility_d" disabled>
                                                            <label class="custom-control-label" for="e_customCheck51"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck59" name="e_utility_w">
                                                            <label class="custom-control-label" for="e_customCheck59"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">16</th>
                                                    <td>Booking</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="e_customCheck52" name="e_booking_v">
                                                            <label class="custom-control-label" for="e_customCheck52"></label>
                                                        </div>
                                                    </td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck53" name="e_booking_a" disabled>
                                                            <label class="custom-control-label" for="e_customCheck53"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck54" name="e_booking_e" disabled>
                                                            <label class="custom-control-label" for="e_customCheck54"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck55" name="e_booking_d" disabled>
                                                            <label class="custom-control-label" for="e_customCheck55"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck62" name="e_booking_w">
                                                            <label class="custom-control-label" for="e_customCheck62"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">17</th>
                                                    <td>Invoice</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="e_customCheck56" name="e_invoice_v">
                                                            <label class="custom-control-label" for="e_customCheck56"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck57" name="e_invoice_a" disabled>
                                                            <label class="custom-control-label" for="e_customCheck57"></label>
                                                        </div></td>
                                                    <td>
                                                        -
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck58" name="e_invoice_d" disabled>
                                                            <label class="custom-control-label" for="e_customCheck58"></label>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">18</th>
                                                    <td>Supplier</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="e_customCheck66" name="e_supplier_v">
                                                            <label class="custom-control-label" for="e_customCheck66"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck67" name="e_supplier_a" disabled>
                                                            <label class="custom-control-label" for="e_customCheck67"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck68" name="e_supplier_e" disabled>
                                                            <label class="custom-control-label" for="e_customCheck68"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck69" name="e_supplier_d" disabled>
                                                            <label class="custom-control-label" for="e_customCheck69"></label>
                                                        </div>
                                                    </td>

                                                </tr>


                                                <tr>
                                                    <th scope="row">19</th>
                                                    <td>Agency & Guide</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="e_customCheck70" name="e_agencyGuide_v">
                                                            <label class="custom-control-label" for="e_customCheck70"></label>
                                                        </div></td>
                                                    <td>-</td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck72" name="e_agencyGuide_e" disabled>
                                                            <label class="custom-control-label" for="e_customCheck72"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck73" name="e_agencyGuide_d" disabled>
                                                            <label class="custom-control-label" for="e_customCheck73"></label>
                                                        </div>
                                                    </td>

                                                </tr>


                                                <tr>
                                                    <th scope="row">20</th>
                                                    <td>Customer</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="e_customCheck88" name="e_customer_v">
                                                            <label class="custom-control-label" for="e_customCheck88"></label>
                                                        </div></td>
                                                    <td>-</td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck89" name="e_customer_e" disabled>
                                                            <label class="custom-control-label" for="e_customCheck89"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                       -
                                                    </td>

                                                </tr>


                                                <tr>
                                                    <th scope="row">21</th>
                                                    <td>Other Income</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="e_customCheck84" name="e_other_income_v">
                                                            <label class="custom-control-label" for="e_customCheck84"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="e_customCheck85" name="e_other_income_a">
                                                            <label class="custom-control-label" for="e_customCheck85"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck86" name="e_other_income_e" disabled>
                                                            <label class="custom-control-label" for="e_customCheck86"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck87" name="e_other_income_d" disabled>
                                                            <label class="custom-control-label" for="e_customCheck87"></label>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <tr>
                                                    <th scope="row">22</th>
                                                    <td>Resturant</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="e_customCheck90" name="e_resturant_v">
                                                            <label class="custom-control-label" for="e_customCheck90"></label>
                                                        </div></td>
                                                    <td>-</td>
                                                    <td>
                                                       -
                                                    </td>
                                                    <td>
                                                        -
                                                    </td>

                                                </tr>

                                                <tr>
                                                    <th scope="row">23</th>
                                                    <td>Promotions</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="e_customCheck95" name="e_promotions_v">
                                                            <label class="custom-control-label" for="e_customCheck95"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="e_customCheck96" name="e_promotions_a">
                                                            <label class="custom-control-label" for="e_customCheck96"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck97" name="e_promotions_e" disabled>
                                                            <label class="custom-control-label" for="e_customCheck97"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="e_customCheck98" name="e_promotions_d" disabled>
                                                            <label class="custom-control-label" for="e_customCheck98"></label>
                                                        </div>
                                                    </td>

                                                </tr>



                                                </tbody>
                                            </table>
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
                        <button type="button" onclick="$('#edit_user_save').submit();" class="btn btn-lg btn-primary">Save User</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal hide fade" role="dialog" aria-hidden="true" id="modal-assign-user">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title"> Assign User</h5>
                </div>
                <div class="modal-body" id="recipe_ingredient_edit">
                    <form action="{{route('management/assign_user/save')}}" method="post" id="assign_user_save">
                        @csrf
                        <input type="hidden" value="{{$hotel->id}}" name="a_hotel_id_a" id="a_hotel_id_a">
                        <input type="hidden" value="{{$hotel->hotel_chain_id}}" name="a_hotel_chain_id_a" id="a_hotel_chain_id_a">
                        <div class="row g-4">
                            <div class="row g-4" id="">
                                <div class="col-lg-12">
                                    @php($assigned_users_id = \App\Privilege::select('user_id')->where('hotel_id',$hotel->id)->get()->pluck('user_id'))
                                    @php( $users = \App\User::where('hotel_chain_id',$hotel->hotel_chain->id)->where('status','Active')->where('role','Staff')->whereNotIn('id', $assigned_users_id)->get())

                                    <div class="form-group">
                                        <label class="form-label" for="email-address-1">Select User</label>
                                        <div class="form-control-wrap">
                                            <div class="form-control-select">
                                                <select class="form-control" id="assign_user_id" name="assign_user_id" required>
                                                    <option value="default_option"> - Select User - </option>
                                                    @foreach($users as $user)
                                                    <option value="{{$user->id}}">{{$user->name}} {{$user->lname}}</option>

                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-row-bg">
                                    <div class="row g-4">
                                        <div class="col-lg-12">
                                            <div class="card-head">
                                                <h5 class="card-title">Add Privilege</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-row-bg">
                                    <div class="row g-4">
                                        <div class="col-lg-12">
                                            <table class="table">
                                                <thead class="thead-dark">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Features</th>
                                                    <th scope="col">View</th>
                                                    <th scope="col">Add</th>
                                                    <th scope="col">Edit</th>
                                                    <th scope="col">Delete</th>
                                                    <th scope="col">Widget</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td>Recipe</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="a_customCheck1" name="a_recipe_v">
                                                            <label class="custom-control-label" for="a_customCheck1"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck2" name="a_recipe_a" disabled>
                                                            <label class="custom-control-label" for="a_customCheck2"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck3" name="a_recipe_e" disabled>
                                                            <label class="custom-control-label" for="a_customCheck3"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck4" name="a_recipe_d" disabled>
                                                            <label class="custom-control-label" for="a_customCheck4"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">2</th>
                                                    <td>Stock</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="a_customCheck5" name="a_stock_v">
                                                            <label class="custom-control-label" for="a_customCheck5"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck6" name="a_stock_a" disabled>
                                                            <label class="custom-control-label" for="a_customCheck6"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck7" name="a_stock_e" disabled>
                                                            <label class="custom-control-label" for="a_customCheck7"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck8" name="a_stock_d" disabled>
                                                            <label class="custom-control-label" for="a_customCheck8"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">3</th>
                                                    <td>GRN</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="a_customCheck9" name="a_grn_v">
                                                            <label class="custom-control-label" for="a_customCheck9"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck10" name="a_grn_a" disabled>
                                                            <label class="custom-control-label" for="a_customCheck10"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck11" name="a_grn_e" disabled>
                                                            <label class="custom-control-label" for="a_customCheck11"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck12" name="a_grn_d" disabled>
                                                            <label class="custom-control-label" for="a_customCheck12"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck65" name="a_grn_w">
                                                            <label class="custom-control-label" for="a_customCheck65"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">4</th>
                                                    <td>POS</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="a_customCheck13" name="a_pos_v">
                                                            <label class="custom-control-label" for="a_customCheck13"></label>
                                                        </div></td>
                                                    <td> - </td>
                                                    <td> - </td>
                                                    <td> - </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck63" name="a_pos_w">
                                                            <label class="custom-control-label" for="a_customCheck63"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">5</th>
                                                    <td>Waste</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="a_customCheck17" name="a_waste_v">
                                                            <label class="custom-control-label" for="a_customCheck17"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck18" name="a_waste_a" disabled>
                                                            <label class="custom-control-label" for="a_customCheck18"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck19" name="a_waste_e" disabled>
                                                            <label class="custom-control-label" for="a_customCheck19"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck20" name="a_waste_d" disabled>
                                                            <label class="custom-control-label" for="a_customCheck20"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">6</th>
                                                    <td>Past orders</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="a_customCheck21" name="a_past_v">
                                                            <label class="custom-control-label" for="a_customCheck21"></label>
                                                        </div></td>
                                                    <td> - </td>
                                                    <td> -
                                                    </td>
                                                    <td> -
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">7</th>
                                                    <td>Inventory Bill/Category</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="a_customCheck22" name="a_inventory_v">
                                                            <label class="custom-control-label" for="a_customCheck22"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck23" name="a_inventory_a" disabled>
                                                            <label class="custom-control-label" for="a_customCheck23"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck24" name="a_inventory_e" disabled>
                                                            <label class="custom-control-label" for="a_customCheck24"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        -
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">8</th>
                                                    <td>Inventory Damage</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="a_customCheck25" name="a_inventory_damage_v">
                                                            <label class="custom-control-label" for="a_customCheck25"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck26" name="a_inventory_damage_a" disabled>
                                                            <label class="custom-control-label" for="a_customCheck26"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck27" name="a_inventory_damage_e" disabled>
                                                            <label class="custom-control-label" for="a_customCheck27"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck28" name="a_inventory_damage_d" disabled>
                                                            <label class="custom-control-label" for="a_customCheck28"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">9</th>
                                                    <td>KOT</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="a_customCheck29" name="a_kot_v">
                                                            <label class="custom-control-label" for="a_customCheck29"></label>
                                                        </div></td>
                                                    <td> - </td>
                                                    <td> -
                                                    </td>
                                                    <td> -
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">10</th>
                                                    <td>Reservation</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="a_customCheck30" name="a_reservation_v">
                                                            <label class="custom-control-label" for="a_customCheck30"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck31" name="a_reservation_a" disabled>
                                                            <label class="custom-control-label" for="a_customCheck31"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck32" name="a_reservation_e" disabled>
                                                            <label class="custom-control-label" for="a_customCheck32"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck33" name="a_reservation_d" disabled>
                                                            <label class="custom-control-label" for="a_customCheck33"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck64" name="a_reservation_w">
                                                            <label class="custom-control-label" for="a_customCheck64"></label>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">11</th>
                                                    <td>Maintenance</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="a_customCheck34" name="a_maintenance_v">
                                                            <label class="custom-control-label" for="a_customCheck34"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck35" name="a_maintenance_a" disabled>
                                                            <label class="custom-control-label" for="a_customCheck35"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck36" name="a_maintenance_e" disabled>
                                                            <label class="custom-control-label" for="a_customCheck36"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck37" name="a_maintenance_d" disabled>
                                                            <label class="custom-control-label" for="a_customCheck37"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck60" name="a_maintenance_w">
                                                            <label class="custom-control-label" for="a_customCheck60"></label>
                                                        </div>
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <th scope="row">12</th>
                                                    <td>House Keeping</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="a_customCheck38" name="a_housekeeping_v">
                                                            <label class="custom-control-label" for="a_customCheck38"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck39" name="a_housekeeping_a" disabled>
                                                            <label class="custom-control-label" for="a_customCheck39"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck40" name="a_housekeeping_e" disabled>
                                                            <label class="custom-control-label" for="a_customCheck40"></label>
                                                        </div>
                                                    </td>
                                                    <td> - </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck61" name="a_housekeeping_w">
                                                            <label class="custom-control-label" for="a_customCheck61"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">13</th>
                                                    <td>Expenses</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="a_customCheck41" name="a_expenses_v">
                                                            <label class="custom-control-label" for="a_customCheck41"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck42" name="a_expenses_a" disabled>
                                                            <label class="custom-control-label" for="a_customCheck42"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck43" name="a_expenses_e" disabled>
                                                            <label class="custom-control-label" for="a_customCheck43"></label>
                                                        </div>
                                                    </td>
                                                    <td> -
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <th scope="row">14</th>
                                                    <td>Cashbooks</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="a_customCheck44" name="a_cashbook_v">
                                                            <label class="custom-control-label" for="a_customCheck44"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck45" name="a_cashbook_a" disabled>
                                                            <label class="custom-control-label" for="a_customCheck45"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck46" name="a_cashbook_e" disabled>
                                                            <label class="custom-control-label" for="a_customCheck46"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck47" name="a_cashbook_d" disabled>
                                                            <label class="custom-control-label" for="a_customCheck47"></label>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <tr>
                                                    <th scope="row">15</th>
                                                    <td>Utilities</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="a_customCheck48" name="a_utility_v">
                                                            <label class="custom-control-label" for="a_customCheck48"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck49" name="a_utility_a" disabled>
                                                            <label class="custom-control-label" for="a_customCheck49"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck50" name="a_utility_e" disabled>
                                                            <label class="custom-control-label" for="a_customCheck50"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck51" name="a_utility_d" disabled>
                                                            <label class="custom-control-label" for="a_customCheck51"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck59" name="a_utility_w">
                                                            <label class="custom-control-label" for="a_customCheck59"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">16</th>
                                                    <td>Booking</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="a_customCheck52" name="a_booking_v">
                                                            <label class="custom-control-label" for="a_customCheck52"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck53" name="a_booking_a" disabled>
                                                            <label class="custom-control-label" for="a_customCheck53"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck54" name="a_booking_e" disabled>
                                                            <label class="custom-control-label" for="a_customCheck54"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck55" name="a_booking_d" disabled>
                                                            <label class="custom-control-label" for="a_customCheck55"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck62" name="a_booking_w">
                                                            <label class="custom-control-label" for="a_customCheck62"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">17</th>
                                                    <td>Invoice</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="a_customCheck56" name="a_invoice_v">
                                                            <label class="custom-control-label" for="a_customCheck56"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck57" name="a_invoice_a" disabled>
                                                            <label class="custom-control-label" for="a_customCheck57"></label>
                                                        </div></td>
                                                    <td>
                                                        -
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck58" name="a_invoice_d" disabled>
                                                            <label class="custom-control-label" for="a_customCheck58"></label>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">18</th>
                                                    <td>Supplier</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="a_customCheck66" name="a_supplier_v">
                                                            <label class="custom-control-label" for="a_customCheck66"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck67" name="a_supplier_a" disabled>
                                                            <label class="custom-control-label" for="a_customCheck67"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck68" name="a_supplier_e" disabled>
                                                            <label class="custom-control-label" for="a_customCheck68"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck69" name="a_supplier_d" disabled>
                                                            <label class="custom-control-label" for="a_customCheck69"></label>
                                                        </div>
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <th scope="row">19</th>
                                                    <td>Agency & Guide</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="a_customCheck70" name="a_agencyGuide_v">
                                                            <label class="custom-control-label" for="a_customCheck70"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck71" name="a_agencyGuide_a" disabled>
                                                            <label class="custom-control-label" for="a_customCheck71"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck72" name="a_agencyGuide_e" disabled>
                                                            <label class="custom-control-label" for="a_customCheck72"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck73" name="a_agencyGuide_d" disabled>
                                                            <label class="custom-control-label" for="a_customCheck73"></label>
                                                        </div>
                                                    </td>
                                                </tr>



                                                <tr>
                                                    <th scope="row">20</th>
                                                    <td>Customer</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="a_customCheck74" name="a_customer_v">
                                                            <label class="custom-control-label" for="a_customCheck74"></label>
                                                        </div></td>
                                                    <td>-</td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck75" name="a_customer_e" disabled>
                                                            <label class="custom-control-label" for="a_customCheck75"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        -
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <th scope="row">21</th>
                                                    <td>Other Income</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="a_customCheck80" name="a_other_income_v">
                                                            <label class="custom-control-label" for="a_customCheck80"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="a_customCheck81" name="a_other_income_a">
                                                            <label class="custom-control-label" for="a_customCheck81"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck82" name="a_other_income_e" disabled>
                                                            <label class="custom-control-label" for="a_customCheck82"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck83" name="a_other_income_d" disabled>
                                                            <label class="custom-control-label" for="a_customCheck83"></label>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">22</th>
                                                    <td>Resturant</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="a_customCheck84" name="a_resturant_v">
                                                            <label class="custom-control-label" for="a_customCheck74"></label>
                                                        </div></td>
                                                    <td>-</td>
                                                    <td>
                                                   -
                                                    </td>
                                                    <td>
                                                        -
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">23</th>
                                                    <td>Promotions</td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="a_customCheck90" name="a_promotions_v">
                                                            <label class="custom-control-label" for="a_customCheck90"></label>
                                                        </div></td>
                                                    <td><div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input handle_disable" id="a_customCheck91" name="a_promotions_a">
                                                            <label class="custom-control-label" for="a_customCheck91"></label>
                                                        </div></td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck92" name="a_promotions_e" disabled>
                                                            <label class="custom-control-label" for="a_customCheck92"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="a_customCheck93" name="a_promotions_d" disabled>
                                                            <label class="custom-control-label" for="a_customCheck93"></label>
                                                        </div>
                                                    </td>
                                                </tr>











                                                </tbody>
                                            </table>
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
                        <button type="button" onclick="$('#assign_user_save').submit();" class="btn btn-lg btn-primary">Save User</button>
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
            var export_title = $('#user-table').data('export-title') ? $('#user-table').data('export-title') : 'Export';
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
            NioApp.DataTable = $('#user-table').DataTable(attr);
            $.fn.DataTable.ext.pager.numbers_length = 7;
            $('.dt-export-title').text(export_title);
        });

        function view_privilege_details(user_id,hotel_id){
            $.ajax({
                type:'POST',
                url:'{{ route('management/privilege/get_privilege_details') }}',
                headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                data: {
                    'user_id' : user_id,
                    'hotel_id' : hotel_id,
                },
                success:function(data){
                    var privileges = '';

                    privileges = ' <tr>\n' +
                        '                            <th scope="row">1</th>\n' +
                        '                            <td>Recipe</td>\n' +
                        '                            <td>'+data.privileges.recipe_view+'</td>\n' +
                        '                            <td>'+data.privileges.recipe_add+'</td>\n' +
                        '                            <td>'+data.privileges.recipe_edit+'</td>\n' +
                        '                            <td>'+data.privileges.recipe_delete+'</td>\n' +
                        '                        </tr><tr>\n' +
                        '                            <th scope="row">2</th>\n' +
                        '                            <td>Stock</td>\n' +
                        '                            <td>'+data.privileges.stock_view+'</td>\n' +
                        '                            <td>'+data.privileges.stock_add+'</td>\n' +
                        '                            <td>'+data.privileges.stock_edit+'</td>\n' +
                        '                            <td>'+data.privileges.stock_delete+'</td>\n' +
                        '                        </tr><tr>\n' +
                        '                            <th scope="row">3</th>\n' +
                        '                            <td>GRN</td>\n' +
                        '                            <td>'+data.privileges.grn_view+'</td>\n' +
                        '                            <td>'+data.privileges.grn_add+'</td>\n' +
                        '                            <td>'+data.privileges.grn_edit+'</td>\n' +
                        '                            <td>'+data.privileges.grn_delete+'</td>\n' +
                        '                            <td>'+data.privileges.grn_widget+'</td>\n' +
                        '                        </tr><tr>\n' +
                        '                            <th scope="row">4</th>\n' +
                        '                            <td>POS</td>\n' +
                        '                            <td>'+data.privileges.pos_view+'</td>\n' +
                        '                            <td> - </td>\n' +
                        '                            <td> - </td>\n' +
                        '                            <td> - </td>\n' +
                        '                            <td>'+data.privileges.pos_widget+'</td>\n' +
                        '                        </tr><tr>\n' +
                        '                            <th scope="row">5</th>\n' +
                        '                            <td>Waste</td>\n' +
                        '                            <td>'+data.privileges.waste_view+'</td>\n' +
                        '                            <td>'+data.privileges.waste_add+'</td>\n' +
                        '                            <td>'+data.privileges.waste_edit+'</td>\n' +
                        '                            <td>'+data.privileges.waste_delete+'</td>\n' +
                        '                        </tr>' +
                        '<tr>\n' +

                        '                            <th scope="row">6</th>\n' +
                        '                            <td>Past orders</td>\n' +
                        '                            <td>'+data.privileges.past_view+'</td>\n' +
                        '                            <td> - </td>\n' +
                        '                            <td> - </td>\n' +
                        '                            <td> - </td>\n' +
                        '                        </tr>\n'+
                    '<tr>\n' +
                    '                            <th scope="row">7</th>\n' +
                    '                            <td>Inventory/Category</td>\n' +
                    '                            <td>'+data.privileges.inventory_view+'</td>\n' +
                    '                            <td> '+data.privileges.inventory_add+' </td>\n' +
                    '                            <td> '+data.privileges.inventory_edit+' </td>\n' +
                    '                            <td> - </td>\n' +
                    '                        </tr>\n'+
                    '<tr>\n' +
                    '                            <th scope="row">8</th>\n' +
                    '                            <td>Inventory Damage</td>\n' +
                    '                            <td>'+data.privileges.inventory_damage_view+'</td>\n' +
                    '                            <td>'+data.privileges.inventory_damage_add+'</td>\n' +
                    '                            <td>'+data.privileges.inventory_damage_edit+'</td>\n' +
                    '                            <td>'+data.privileges.inventory_damage_delete+'</td>\n' +
                    '                        </tr>\n'+
                    '<tr>\n' +
                    '                            <th scope="row">9</th>\n' +
                    '                            <td>KOT</td>\n' +
                    '                            <td>'+data.privileges.kot_view+'</td>\n' +
                    '                            <td> - </td>\n' +
                    '                            <td> - </td>\n' +
                    '                            <td> - </td>\n' +
                    '                        </tr>\n'+
                    '<tr>\n' +
                        '                        <th scope="row">10</th>\n' +
                        '                            <td>Reservation</td>\n' +
                        '                            <td>'+data.privileges.reservation_view+'</td>\n' +
                        '                            <td>'+data.privileges.reservation_add+'</td>\n' +
                        '                            <td>'+data.privileges.reservation_edit+'</td>\n' +
                        '                            <td>'+data.privileges.reservation_delete+'</td>\n' +
                        '                            <td>'+data.privileges.reservation_widget+'</td>\n' +
                        '                        </tr>\n'+
                        '<tr>\n' +
                        '                       <th scope="row">11</th>\n' +
                        '                            <td>Maintenance</td>\n' +
                        '                            <td>'+data.privileges.maintenance_view+'</td>\n' +
                        '                            <td>'+data.privileges.maintenance_add+'</td>\n' +
                        '                            <td>'+data.privileges.maintenance_edit+'</td>\n' +
                        '                            <td>'+data.privileges.maintenance_delete+'</td>\n' +
                        '                            <td>'+data.privileges.maintenance_widget+'</td>\n' +
                        '                        </tr>\n'+
                        '<tr>\n' +
                    '                            <th scope="row">12</th>\n' +
                    '                            <td>House Keeping</td>\n' +
                    '                            <td>'+data.privileges.housekeeping_view+'</td>\n' +
                    '                            <td>'+data.privileges.housekeeping_add+'</td>\n' +
                    '                            <td>'+data.privileges.housekeeping_edit+'</td>\n' +
                    '                            <td> - </td>\n' +
                    '                            <td>'+data.privileges.housekeeping_widget+'</td>\n' +
                    '                        </tr>\n'+
                    '<tr>\n' +
                    '                            <th scope="row">13</th>\n' +
                    '                            <td>Expenses</td>\n' +
                    '                            <td>'+data.privileges.expenses_view+'</td>\n' +
                    '                            <td>'+data.privileges.expenses_add+'</td>\n' +
                    '                            <td>'+data.privileges.expenses_edit+'</td>\n' +
                    '                            <td> - </td>\n' +
                    '                        </tr>\n'+
                    '<tr>\n' +
                    '                            <th scope="row">14</th>\n' +
                    '                            <td>Cashbooks</td>\n' +
                    '                            <td>'+data.privileges.cashbook_view+'</td>\n' +
                    '                            <td>'+data.privileges.cashbook_add+'</td>\n' +
                    '                            <td>'+data.privileges.cashbook_edit+'</td>\n' +
                    '                            <td>'+data.privileges.cashbook_delete+'</td>\n' +
                    '                            <td> - </td>\n' +
                    '                        </tr>\n'+
                        '<tr>\n' +
                        '                            <th scope="row">15</th>\n' +
                        '                            <td>Utilities</td>\n' +
                        '                            <td>'+data.privileges.utility_view+'</td>\n' +
                        '                            <td>'+data.privileges.utility_add+'</td>\n' +
                        '                            <td>'+data.privileges.utility_edit+'</td>\n' +
                        '                            <td>'+data.privileges.utility_delete+'</td>\n' +
                        '                            <td>'+data.privileges.utility_widget+'</td>\n' +
                        '                        </tr>\n'+
                    '<tr>\n' +
                        '                            <th scope="row">16</th>\n' +
                        '                            <td>Booking</td>\n' +
                        '                            <td>'+data.privileges.booking_view+'</td>\n' +
                        '                            <td>'+data.privileges.booking_add+'</td>\n' +
                        '                            <td>'+data.privileges.booking_edit+'</td>\n' +
                        '                            <td>'+data.privileges.booking_delete+'</td>\n' +
                        '                            <td>'+data.privileges.booking_widget+'</td>\n' +
                        '                        </tr>\n'+
                    '<tr>\n' +
                        '                            <th scope="row">17</th>\n' +
                        '                            <td>Invoice</td>\n' +
                        '                            <td>'+data.privileges.invoice_view+'</td>\n' +
                        '                            <td>'+data.privileges.invoice_add+'</td>\n' +
                        '                            <td> - </td>\n' +
                        '                            <td>'+data.privileges.invoice_delete+'</td>\n' +
                        '                            <td> - </td>\n' +
                        '                        </tr>\n'+
                        '<tr>\n' +
                        '                            <th scope="row">18</th>\n' +
                        '                            <td>Spplier</td>\n' +
                        '                            <td>'+data.privileges.supplier_view+'</td>\n' +
                        '                            <td>'+data.privileges.supplier_add+'</td>\n' +
                        '                            <td>'+data.privileges.supplier_edit+'</td>\n' +
                        '                            <td>'+data.privileges.supplier_delete+'</td>\n' +
                        '                        </tr>\n'+
                        '<tr>\n' +
                        '                            <th scope="row">19</th>\n' +
                        '                            <td>Agency & Guides</td>\n' +
                        '                            <td>'+data.privileges.agencyGuide_view+'</td>\n' +
                        '                            <td> - </td>\n' +
                        '                            <td>'+data.privileges.agencyGuide_edit+'</td>\n' +
                        '                            <td>'+data.privileges.agencyGuide_delete+'</td>\n' +

                    '                        </tr>\n'+
                    '<tr>\n' +

                    '                            <th scope="row">20</th>\n' +
                    '                            <td>Customer</td>\n' +
                    '                            <td>'+data.privileges.customer_view+'</td>\n' +
                    '                            <td>-</td>\n' +
                    '                            <td>'+data.privileges.customer_edit+'</td>\n' +
                    '                            <td>-</td>\n' +
                    '                        </tr>'+
                        '<tr>\n' +
                        '                            <th scope="row">21</th>\n' +
                        '                            <td>Other Income</td>\n' +
                        '                            <td>'+data.privileges.other_income_view+'</td>\n' +
                        '                            <td>'+data.privileges.other_income_add+'</td>\n' +
                        '                            <td>'+data.privileges.other_income_edit+'</td>\n' +
                        '                            <td>'+data.privileges.other_income_delete+'</td>\n' +
                        '                        </tr>'+
                        '<tr>\n' +
                        '                            <th scope="row">22</th>\n' +
                        '                            <td>Resturant</td>\n' +
                        '                            <td>'+data.privileges.resturant_view+'</td>\n' +
                        '                            <td>-</td>\n' +
                        '                            <td>-</td>\n' +
                        '                            <td>-</td>\n' +
                        '                        </tr>'+
                        '<tr>\n' +
                        '                            <th scope="row">23</th>\n' +
                        '                            <td>Promotions</td>\n' +
                        '                            <td>'+data.privileges.promotions_view+'</td>\n' +
                        '                            <td>'+data.privileges.promotions_add+'</td>\n' +
                        '                            <td>'+data.privileges.promotions_edit+'</td>\n' +
                        '                            <td>'+data.privileges.promotions_delete+'</td>\n' +
                        '                        </tr>';


                    $('#modal-view-privileges-body').empty();
                    $('#modal-view-privileges-body').append(privileges);

                    $('#modal-view-privileges').modal('show');

                }

            });

        }

        $('#user-table tbody').on('click',
            'a',
            function () {
                if ( $(this).hasClass('updateRecordButton') ) {
                    var data = NioApp.DataTable.row($(this).parents('tr')).data(); //Retrieve row data
                    var tr = $(this).closest('tr'); //Find DataTables table row
                    var theRowObject = NioApp.DataTable.row(tr); //Get DataTables row object
                    var user_id = $(this).data('userid');
                    var privilege_id = $(this).data('privilegeid');
                    global_theRowObject=theRowObject;
                    console.log(data);
                    $.ajax({
                        type:'POST',
                        url:'{{ route('management/user/get_edit_user_details') }}',
                        headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                        data: {
                            'user_id' : user_id,
                            'privilege_id' : privilege_id,
                        },
                        success:function(data){
                            console.log(data);
                            $('#edit_user_save input:checkbox').prop('checked',false).prop('disabled',true);
                            $('.handle_disable').prop('disabled',false);
                            $('#edit_user_id').val(data.edit_user.id)
                            $('#edit_user_privilege_id').val(data.edit_privilege.id)
                            $('#e_fname').val(data.edit_user.name)
                            $('#e_lname').val(data.edit_user.lname)
                            $('#e_email').val(data.edit_user.email)
                            if(data.edit_privilege.recipe_view == 'Allow'){
                                $('#e_customCheck1').prop('checked',true);
                                $('#e_customCheck2').prop('disabled',false);
                                $('#e_customCheck3').prop('disabled',false);
                                $('#e_customCheck4').prop('disabled',false);
                            }
                            if(data.edit_privilege.recipe_add == 'Allow'){
                                $('#e_customCheck2').prop('checked',true);
                            }
                            if(data.edit_privilege.recipe_edit == 'Allow'){
                                $('#e_customCheck3').prop('checked',true);
                            }
                            if(data.edit_privilege.recipe_delete == 'Allow'){
                                $('#e_customCheck4').prop('checked',true);
                            }
                            if(data.edit_privilege.stock_view == 'Allow'){
                                $('#e_customCheck5').prop('checked',true);
                                $('#e_customCheck6').prop('disabled',false);
                                $('#e_customCheck7').prop('disabled',false);
                                $('#e_customCheck8').prop('disabled',false);
                            }
                            if(data.edit_privilege.stock_add == 'Allow'){
                                $('#e_customCheck6').prop('checked',true);
                            }
                            if(data.edit_privilege.stock_edit == 'Allow'){
                                $('#e_customCheck7').prop('checked',true);
                            }
                            if(data.edit_privilege.stock_delete == 'Allow'){
                                $('#e_customCheck8').prop('checked',true);
                            }
                            if(data.edit_privilege.grn_view == 'Allow'){
                                $('#e_customCheck9').prop('checked',true);
                                $('#e_customCheck10').prop('disabled',false);
                                $('#e_customCheck11').prop('disabled',false);
                                $('#e_customCheck12').prop('disabled',false);
                            }
                            if(data.edit_privilege.grn_add == 'Allow'){
                                $('#e_customCheck10').prop('checked',true);
                            }
                            if(data.edit_privilege.grn_edit == 'Allow'){
                                $('#e_customCheck11').prop('checked',true);
                            }
                            if(data.edit_privilege.grn_delete == 'Allow'){
                                $('#e_customCheck12').prop('checked',true);
                            }
                            if(data.edit_privilege.grn_widget == 'Allow'){
                                $('#e_customCheck65').prop('checked',true).prop('disabled',false);
                            }
                            else{
                                $('#e_customCheck65').prop('disabled',false);
                            }

                            if(data.edit_privilege.pos_view == 'Allow'){
                                $('#e_customCheck13').prop('checked',true);
                            }
                            if(data.edit_privilege.pos_widget == 'Allow'){
                                $('#e_customCheck63').prop('checked',true).prop('disabled',false);
                            }
                            else{
                                $('#e_customCheck63').prop('disabled',false);
                            }

                            if(data.edit_privilege.waste_view == 'Allow'){
                                $('#e_customCheck17').prop('checked',true);
                                $('#e_customCheck18').prop('disabled',false);
                                $('#e_customCheck19').prop('disabled',false);
                                $('#e_customCheck20').prop('disabled',false);
                            }
                            if(data.edit_privilege.waste_add == 'Allow'){
                                $('#e_customCheck18').prop('checked',true);
                            }
                            if(data.edit_privilege.waste_edit == 'Allow'){
                                $('#e_customCheck19').prop('checked',true);
                            }
                            if(data.edit_privilege.waste_delete == 'Allow'){
                                $('#e_customCheck20').prop('checked',true);
                            }
                            if(data.edit_privilege.past_view == 'Allow'){
                                $('#e_customCheck21').prop('checked',true);
                            }
                            if(data.edit_privilege.inventory_view == 'Allow'){
                                $('#e_customCheck22').prop('checked',true);
                                $('#e_customCheck23').prop('disabled',false);
                                $('#e_customCheck24').prop('disabled',false);
                            }
                            if(data.edit_privilege.inventory_add == 'Allow'){
                                $('#e_customCheck23').prop('checked',true);
                            }
                            if(data.edit_privilege.inventory_edit == 'Allow'){
                                $('#e_customCheck24').prop('checked',true);
                            }
                            if(data.edit_privilege.inventory_damage_view == 'Allow'){
                                $('#e_customCheck25').prop('checked',true);
                                $('#e_customCheck26').prop('disabled',false);
                                $('#e_customCheck27').prop('disabled',false);
                                $('#e_customCheck28').prop('disabled',false);
                            }
                            if(data.edit_privilege.inventory_damage_add == 'Allow'){
                                $('#e_customCheck26').prop('checked',true);
                            }
                            if(data.edit_privilege.inventory_damage_edit == 'Allow'){
                                $('#e_customCheck27').prop('checked',true);
                            }
                            if(data.edit_privilege.inventory_damage_delete == 'Allow'){
                                $('#e_customCheck28').prop('checked',true);
                            }
                            if(data.edit_privilege.kot_view == 'Allow'){
                                $('#e_customCheck29').prop('checked',true);
                            }
                            if(data.edit_privilege.reservation_view == 'Allow'){
                                $('#e_customCheck30').prop('checked',true);
                                $('#e_customCheck31').prop('disabled',false);
                                $('#e_customCheck32').prop('disabled',false);
                                $('#e_customCheck33').prop('disabled',false);
                            }
                            if(data.edit_privilege.reservation_add == 'Allow'){
                                $('#e_customCheck31').prop('checked',true);
                            }
                            if(data.edit_privilege.reservation_edit == 'Allow'){
                                $('#e_customCheck32').prop('checked',true);
                            }
                            if(data.edit_privilege.reservation_delete == 'Allow'){
                                $('#e_customCheck33').prop('checked',true);
                            }
                            if(data.edit_privilege.reservation_widget == 'Allow'){
                                $('#e_customCheck64').prop('checked',true).prop('disabled',false);
                            }
                            else{
                                $('#e_customCheck64').prop('disabled',false);
                            }

                            if(data.edit_privilege.maintenance_view == 'Allow'){
                                $('#e_customCheck34').prop('checked',true);
                                $('#e_customCheck35').prop('disabled',false);
                                $('#e_customCheck36').prop('disabled',false);
                                $('#e_customCheck37').prop('disabled',false);
                            }
                            if(data.edit_privilege.maintenance_add == 'Allow'){
                                $('#e_customCheck35').prop('checked',true);
                            }
                            if(data.edit_privilege.maintenance_edit == 'Allow'){
                                $('#e_customCheck36').prop('checked',true);
                            }
                            if(data.edit_privilege.maintenance_delete == 'Allow'){
                                $('#e_customCheck37').prop('checked',true);
                            }
                            if(data.edit_privilege.maintenance_widget == 'Allow'){
                                $('#e_customCheck60').prop('checked',true).prop('disabled',false);
                            }
                            else{
                                $('#e_customCheck60').prop('disabled',false);
                            }

                            if(data.edit_privilege.housekeeping_view == 'Allow'){
                                $('#e_customCheck38').prop('checked',true);
                                $('#e_customCheck39').prop('disabled',false);
                                $('#e_customCheck40').prop('disabled',false);
                            }
                            if(data.edit_privilege.housekeeping_add == 'Allow'){
                                $('#e_customCheck39').prop('checked',true);
                            }
                            if(data.edit_privilege.housekeeping_edit == 'Allow'){
                                $('#e_customCheck40').prop('checked',true);
                            }
                            if(data.edit_privilege.housekeeping_widget == 'Allow'){
                                $('#e_customCheck61').prop('checked',true).prop('disabled',false);
                            }
                            else{
                                $('#e_customCheck61').prop('disabled',false);
                            }

                            if(data.edit_privilege.expenses_view == 'Allow'){
                                $('#e_customCheck41').prop('checked',true);
                                $('#e_customCheck42').prop('disabled',false);
                                $('#e_customCheck43').prop('disabled',false);
                            }
                            if(data.edit_privilege.expenses_add == 'Allow'){
                                $('#e_customCheck42').prop('checked',true);
                            }
                            if(data.edit_privilege.expenses_edit == 'Allow'){
                                $('#e_customCheck43').prop('checked',true);
                            }
                            if(data.edit_privilege.cashbook_view == 'Allow'){
                                $('#e_customCheck44').prop('checked',true);
                                $('#e_customCheck45').prop('disabled',false);
                                $('#e_customCheck46').prop('disabled',false);
                                $('#e_customCheck47').prop('disabled',false);
                            }
                            if(data.edit_privilege.cashbook_add == 'Allow'){
                                $('#e_customCheck45').prop('checked',true);
                            }
                            if(data.edit_privilege.cashbook_edit == 'Allow'){
                                $('#e_customCheck46').prop('checked',true);
                            }
                            if(data.edit_privilege.cashbook_delete == 'Allow'){
                                $('#e_customCheck47').prop('checked',true);
                            }
                            if(data.edit_privilege.utility_view == 'Allow'){
                                $('#e_customCheck48').prop('checked',true);
                                $('#e_customCheck49').prop('disabled',false);
                                $('#e_customCheck50').prop('disabled',false);
                                $('#e_customCheck51').prop('disabled',false);
                                // $('#e_customCheck59').prop('disabled',false);
                            }
                            if(data.edit_privilege.utility_add == 'Allow'){
                                $('#e_customCheck49').prop('checked',true);
                            }
                            if(data.edit_privilege.utility_edit == 'Allow'){
                                $('#e_customCheck50').prop('checked',true);
                            }
                            if(data.edit_privilege.utility_delete == 'Allow'){
                                $('#e_customCheck51').prop('checked',true);
                            }
                            if(data.edit_privilege.utility_widget == 'Allow'){
                                $('#e_customCheck59').prop('checked',true).prop('disabled',false);
                            }
                            else{
                                $('#e_customCheck59').prop('disabled',false);
                            }

                            if(data.edit_privilege.booking_view == 'Allow'){
                                $('#e_customCheck52').prop('checked',true);
                                $('#e_customCheck53').prop('disabled',false);
                                $('#e_customCheck54').prop('disabled',false);
                                $('#e_customCheck55').prop('disabled',false);
                            }
                            if(data.edit_privilege.booking_add == 'Allow'){
                                $('#e_customCheck53').prop('checked',true);
                            }
                            if(data.edit_privilege.booking_edit == 'Allow'){
                                $('#e_customCheck54').prop('checked',true);
                            }
                            if(data.edit_privilege.booking_delete == 'Allow'){
                                $('#e_customCheck55').prop('checked',true);
                            }
                            if(data.edit_privilege.booking_widget == 'Allow'){
                                $('#e_customCheck62').prop('checked',true).prop('disabled',false);
                            }
                            else{
                                $('#e_customCheck62').prop('disabled',false);
                            }

                            if(data.edit_privilege.invoice_view == 'Allow'){
                                $('#e_customCheck56').prop('checked',true);
                                $('#e_customCheck57').prop('disabled',false);
                                $('#e_customCheck58').prop('disabled',false);
                            }
                            if(data.edit_privilege.invoice_add == 'Allow'){
                                $('#e_customCheck57').prop('checked',true);
                            }
                            if(data.edit_privilege.invoice_delete == 'Allow'){
                                $('#e_customCheck58').prop('checked',true);
                            }


                            if(data.edit_privilege.supplier_view == 'Allow'){
                                $('#e_customCheck66').prop('checked',true);
                                $('#e_customCheck67').prop('disabled',false);
                                $('#e_customCheck68').prop('disabled',false);
                                $('#e_customCheck69').prop('disabled',false);
                            }
                            if(data.edit_privilege.supplier_add == 'Allow'){
                                $('#e_customCheck67').prop('checked',true);
                            }
                            if(data.edit_privilege.supplier_edit == 'Allow'){
                                $('#e_customCheck68').prop('checked',true);
                            }
                            if(data.edit_privilege.supplier_delete == 'Allow'){
                                $('#e_customCheck69').prop('checked',true);
                            }

                            if(data.edit_privilege.customer_view == 'Allow'){
                                $('#e_customCheck88').prop('checked',true);
                                $('#e_customCheck89').prop('disabled',false);
                            }

                            if(data.edit_privilege.customer_edit =='Allow'){
                                $('#e_customCheck89').prop('checked',true).prop('disabled',false);
                            }
                            else{
                                $('#e_customCheck89').prop('disabled',false);
                            }



                            if(data.edit_privilege.agencyGuide_view == 'Allow'){
                                $('#e_customCheck70').prop('checked',true);
                                $('#e_customCheck71').prop('disabled',false);
                                $('#e_customCheck72').prop('disabled',false);
                                $('#e_customCheck73').prop('disabled',false);
                            }
                            if(data.edit_privilege.agencyGuide_add == 'Allow'){
                                $('#e_customCheck71').prop('checked',true);
                            }
                            if(data.edit_privilege.agencyGuide_edit == 'Allow'){
                                $('#e_customCheck72').prop('checked',true);
                            }
                            if(data.edit_privilege.agencyGuide_delete == 'Allow'){
                                $('#e_customCheck73').prop('checked',true);
                            }

                            if(data.edit_privilege.other_income_view == 'Allow'){
                                $('#e_customCheck84').prop('checked',true);
                                $('#e_customCheck85').prop('disabled',false);
                                $('#e_customCheck86').prop('disabled',false);
                                $('#e_customCheck87').prop('disabled',false);
                            }
                            if(data.edit_privilege.other_income_add == 'Allow'){
                                $('#e_customCheck85').prop('checked',true);
                            }
                            if(data.edit_privilege.other_income_edit == 'Allow'){
                                $('#e_customCheck86').prop('checked',true);
                            }
                            if(data.edit_privilege.other_income_delete == 'Allow'){
                                $('#e_customCheck87').prop('checked',true);
                            }
                            if(data.edit_privilege.resturant_view == 'Allow'){
                                $('#e_customCheck90').prop('checked',true)
                            }
                            if(data.edit_privilege.promotions_view == 'Allow'){
                                $('#e_customCheck95').prop('checked',true);
                                $('#e_customCheck96').prop('disabled',false);
                                $('#e_customCheck97').prop('disabled',false);
                                $('#e_customCheck98').prop('disabled',false);
                            }
                            if(data.edit_privilege.promotions_add == 'Allow'){
                                $('#e_customCheck96').prop('checked',true);
                            }
                            if(data.edit_privilege.promotions_edit == 'Allow'){
                                $('#e_customCheck97').prop('checked',true);
                            }
                            if(data.edit_privilege.promotions_delete == 'Allow'){
                                $('#e_customCheck98').prop('checked',true);
                            }





                            $('#modal-edit-user').modal('show');

                        }

                    });

                }
                if ( $(this).hasClass('deleteRecordButton') ) {
                    var data = NioApp.DataTable.row($(this).parents('tr')).data(); //Retrieve row data
                    var tr = $(this).closest('tr'); //Find DataTables table row
                    var theRowObject = NioApp.DataTable.row(tr); //Get DataTables row object
                    var privilege_id = $(this).data('privilegeid');
                    // global_theRowObject2=theRowObject;
                    $.ajax({
                        type:'POST',
                        url:'{{ route('management/user/delete/from_hotel') }}',
                        headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                        data: {
                            'privilege_id' : privilege_id,
                        },
                        success:function(data){
                            if(data.success){
                                NioApp.Toast('Successfully Deleted User', 'success',{position: 'top-right'});
                                NioApp.DataTable.row(theRowObject).remove().draw();
                            }else{
                                NioApp.Toast(data.error, 'warning',{position: 'top-right'});
                            }
                        }

                    });

                }
            });

        $("#add_user_save").submit(function(e) {

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
                    $('#add_user_save input:checkbox').prop('checked',false).prop('disabled',true);
                    $('.handle_disable').prop('disabled',false);
                    $(':input', '#add_user_save')
                        .not(':button, :submit, :reset, :hidden')
                        .val('')
                        .prop('selected', false);
                    console.log(data);
                    var action_buton ='<a class="btn btn-trigger btn-icon updateRecordButton" data-privilegeid="'+data.privilege.id+'"  data-userid="'+data.save_user.id+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit User"><em class="icon ni ni-pen2"></em></a>\n' +
                        '                                 <a class="btn btn-trigger btn-icon deleteRecordButton" data-privilegeid="'+data.privilege.id+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete User"><em class="icon ni ni-sign-xrp-new-alt"></em></a>\n' +
                        '                                <a class="btn btn-trigger btn-icon" onclick="view_privilege_details(\''+data.save_user.id+'\',\''+data.privilege.hotel_id+'\');" data-bs-toggle="tooltip" data-bs-placement="top" title="View Privilege"><em class="icon ni ni-list-index-fill"></em></a>';
                    var table_data = [data.save_user.name +' '+ data.save_user.lname,data.save_user.email,'{{$hotel->hotel_chain->name}}',action_buton];
                    // // console.log(table_data);
                    // //
                    NioApp.DataTable.row.add(table_data);
                    NioApp.DataTable.draw();
                    $('#modal-add-user').modal('hide');
                    NioApp.Toast('Successfully Add User', 'success',{position: 'top-right'});
                }
            });
        });
        $("#assign_user_save").submit(function(e) {

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
                    $('#assign_user_save input:checkbox').prop('checked',false).prop('disabled',true);
                    $('.handle_disable').prop('disabled',false);
                    $(':input', '#assign_user_save')
                        .not(':button, :submit, :reset, :hidden')
                        .val('')
                        .prop('selected', false);
                    console.log(data);
                    var action_buton ='<a class="btn btn-trigger btn-icon updateRecordButton" data-privilegeid="'+data.privilege.id+'" data-userid="'+data.save_user.id+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit User"><em class="icon ni ni-pen2"></em></a>\n' +
                        '                                 <a class="btn btn-trigger btn-icon deleteRecordButton" data-privilegeid="'+data.privilege.id+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete User"><em class="icon ni ni-sign-xrp-new-alt"></em></a>\n' +
                        '                                <a class="btn btn-trigger btn-icon" onclick="view_privilege_details(\''+data.save_user.id+'\',\''+data.privilege.hotel_id+'\');" data-bs-toggle="tooltip" data-bs-placement="top" title="View Privilege"><em class="icon ni ni-list-index-fill"></em></a>';
                    var table_data = [data.save_user.name +' '+ data.save_user.lname,data.save_user.email,'{{$hotel->hotel_chain->name}}',action_buton];
                    // // console.log(table_data);
                    // //
                    NioApp.DataTable.row.add(table_data);
                    NioApp.DataTable.draw();
                    $('#modal-assign-user').modal('hide');
                    NioApp.Toast('Successfully Assign User', 'success',{position: 'top-right'});
                }
            });
        });
        $("#edit_user_save").submit(function(e) {

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
                    var action_buton ='<a class="btn btn-trigger btn-icon updateRecordButton" data-privilegeid="'+data.privilege_id+'" data-userid="'+data.edit_user.id+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit User"><em class="icon ni ni-pen2"></em></a>\n' +
                        '                                 <a class="btn btn-trigger btn-icon deleteRecordButton" data-privilegeid="'+data.privilege_id+'" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete User"><em class="icon ni ni-sign-xrp-new-alt"></em></a>\n' +
                        '                                <a class="btn btn-trigger btn-icon" onclick="view_privilege_details(\''+data.edit_user.id+'\',\''+data.hotel_id+'\');" data-bs-toggle="tooltip" data-bs-placement="top" title="View Privilege"><em class="icon ni ni-list-index-fill"></em></a>';
                    var table_data = [data.edit_user.name +' '+ data.edit_user.lname,data.edit_user.email,'{{$hotel->hotel_chain->name}}',action_buton];
                    // // console.log(table_data);
                    // //
                   NioApp.DataTable.row(global_theRowObject).data(table_data).draw(false);
                    $('#modal-edit-user').modal('hide');
                    NioApp.Toast('Successfully Edit User', 'success',{position: 'top-right'});
                }
            });
        });
        $('#customCheck1').change(function() {
            if ($('#customCheck1').prop('checked') == true) {
                $('#customCheck2').prop('disabled',false);
                $('#customCheck3').prop('disabled',false);
                $('#customCheck4').prop('disabled',false);
            }
            else{
                $('#customCheck2').prop('disabled',true).prop('checked',false);
                $('#customCheck3').prop('disabled',true).prop('checked',false);
                $('#customCheck4').prop('disabled',true).prop('checked',false);

            }
        });



        $('#customCheck70').change(function() {
            if ($('#customCheck70').prop('checked') == true) {
                $('#customCheck71').prop('disabled',false);
                $('#customCheck72').prop('disabled',false);
                $('#customCheck73').prop('disabled',false);


            }
            else{
                $('#customCheck71').prop('disabled',true).prop('checked',false);
                $('#customCheck72').prop('disabled',true).prop('checked',false);
                $('#customCheck73').prop('disabled',true).prop('checked',false);


            }
        });
        $('#customCheck5').change(function() {
            if ($('#customCheck5').prop('checked') == true) {
                $('#customCheck6').prop('disabled',false);
                $('#customCheck7').prop('disabled',false);
                $('#customCheck8').prop('disabled',false);
            }
            else{
                $('#customCheck6').prop('disabled',true).prop('checked',false);
                $('#customCheck7').prop('disabled',true).prop('checked',false);
                $('#customCheck8').prop('disabled',true).prop('checked',false);

            }
        });
        $('#customCheck9').change(function() {
            if ($('#customCheck9').prop('checked') == true) {
                $('#customCheck10').prop('disabled',false);
                $('#customCheck11').prop('disabled',false);
                $('#customCheck12').prop('disabled',false);



            }
            else{
                $('#customCheck10').prop('disabled',true).prop('checked',false);
                $('#customCheck11').prop('disabled',true).prop('checked',false);
                $('#customCheck12').prop('disabled',true).prop('checked',false);




            }
        });
        $('#customCheck17').change(function() {
            if ($('#customCheck17').prop('checked') == true) {
                $('#customCheck18').prop('disabled',false);
                $('#customCheck19').prop('disabled',false);
                $('#customCheck20').prop('disabled',false);
            }
            else{
                $('#customCheck18').prop('disabled',true).prop('checked',false);
                $('#customCheck19').prop('disabled',true).prop('checked',false);
                $('#customCheck20').prop('disabled',true).prop('checked',false);
            }
        });
        $('#customCheck22').change(function() {
            if ($('#customCheck22').prop('checked') == true) {
                $('#customCheck23').prop('disabled',false);
                $('#customCheck24').prop('disabled',false);}
            else{
                $('#customCheck23').prop('disabled',true).prop('checked',false);
                $('#customCheck24').prop('disabled',true).prop('checked',false);
            }
        });
        $('#customCheck25').change(function() {
            if ($('#customCheck25').prop('checked') == true) {
                $('#customCheck26').prop('disabled',false);
                $('#customCheck27').prop('disabled',false);
                $('#customCheck28').prop('disabled',false);}
            else{
                $('#customCheck26').prop('disabled',true).prop('checked',false);
                $('#customCheck27').prop('disabled',true).prop('checked',false);
                $('#customCheck28').prop('disabled',true).prop('checked',false);
            }
        });
        $('#customCheck30').change(function() {
            if ($('#customCheck30').prop('checked') == true) {
                $('#customCheck31').prop('disabled',false);
                $('#customCheck32').prop('disabled',false);
                $('#customCheck33').prop('disabled',false);}
            else{
                $('#customCheck31').prop('disabled',true).prop('checked',false);
                $('#customCheck32').prop('disabled',true).prop('checked',false);
                $('#customCheck33').prop('disabled',true).prop('checked',false);
            }
        });
        $('#customCheck34').change(function() {
            if ($('#customCheck34').prop('checked') == true) {
                $('#customCheck35').prop('disabled',false);
                $('#customCheck36').prop('disabled',false);
                $('#customCheck37').prop('disabled',false);}
            else{
                $('#customCheck35').prop('disabled',true).prop('checked',false);
                $('#customCheck36').prop('disabled',true).prop('checked',false);
                $('#customCheck37').prop('disabled',true).prop('checked',false);
            }
        });
        $('#customCheck38').change(function() {
            if ($('#customCheck38').prop('checked') == true) {
                $('#customCheck39').prop('disabled', false);
                $('#customCheck40').prop('disabled', false);
                $('#customCheck61').prop('disabled', false);
            }

            else{
                $('#customCheck39').prop('disabled',true).prop('checked',false);
                $('#customCheck40').prop('disabled',true).prop('checked',false);
                $('#customCheck61').prop('disabled',true).prop('checked',false);

            }
        });

        $('#customCheck41').change(function() {
            if ($('#customCheck41').prop('checked') == true) {
                $('#customCheck42').prop('disabled', false);
                $('#customCheck43').prop('disabled', false);
            }
            else{
                $('#customCheck42').prop('disabled',true).prop('checked',false);
                $('#customCheck43').prop('disabled',true).prop('checked',false);
            }
        });
        $('#customCheck44').change(function() {
            if ($('#customCheck44').prop('checked') == true) {
                $('#customCheck45').prop('disabled', false);
                $('#customCheck46').prop('disabled', false);
                $('#customCheck47').prop('disabled', false);
            }
            else{
                $('#customCheck45').prop('disabled',true).prop('checked',false);
                $('#customCheck46').prop('disabled',true).prop('checked',false);
                $('#customCheck47').prop('disabled',true).prop('checked',false);
            }
        });
        $('#customCheck48').change(function() {
            if ($('#customCheck48').prop('checked') == true) {
                $('#customCheck49').prop('disabled', false);
                $('#customCheck50').prop('disabled', false);
                $('#customCheck51').prop('disabled', false);
                // $('#customCheck59').prop('disabled', false);
            }
            else{
                $('#customCheck49').prop('disabled',true).prop('checked',false);
                $('#customCheck50').prop('disabled',true).prop('checked',false);
                $('#customCheck51').prop('disabled',true).prop('checked',false);
                // $('#customCheck59').prop('disabled',true).prop('checked',false);
            }
        });
        $('#customCheck52').change(function() {
            if ($('#customCheck52').prop('checked') == true) {
                $('#customCheck53').prop('disabled', false);
                $('#customCheck54').prop('disabled', false);
                $('#customCheck55').prop('disabled', false);
            }
            else{
                $('#customCheck53').prop('disabled',true).prop('checked',false);
                $('#customCheck54').prop('disabled',true).prop('checked',false);
                $('#customCheck55').prop('disabled',true).prop('checked',false);
            }
        });
        $('#customCheck56').change(function() {
            if ($('#customCheck56').prop('checked') == true) {
                $('#customCheck57').prop('disabled', false);
                $('#customCheck58').prop('disabled', false);
            }
            else{
                $('#customCheck57').prop('disabled',true).prop('checked',false);
                $('#customCheck58').prop('disabled',true).prop('checked',false);
            }
        });
        $('#customCheck66').change(function() {
            if ($('#customCheck66').prop('checked') == true) {
                $('#customCheck67').prop('disabled', false);
                $('#customCheck68').prop('disabled', false);
                $('#customCheck69').prop('disabled', false);
            }
            else{
                $('#customCheck67').prop('disabled',true).prop('checked',false);
                $('#customCheck68').prop('disabled',true).prop('checked',false);
                $('#customCheck69').prop('disabled',true).prop('checked',false);
            }
        });

        $('#customCheck76').change(function() {
            if ($('#customCheck76').prop('checked') == true) {
                $('#customCheck77').prop('disabled', false);
                $('#customCheck78').prop('disabled', false);
                $('#customCheck79').prop('disabled', false);

            }
            else{
                $('#customCheck77').prop('disabled',true).prop('checked',false);
                $('#customCheck78').prop('disabled',true).prop('checked',false);
                $('#customCheck79').prop('disabled',true).prop('checked',false);
            }
        });

        $('#customCheck80').change(function() {
            if ($('#customCheck80').prop('checked') == true) {
                $('#customCheck81').prop('disabled', false);


            }
            else{
                $('#customCheck81').prop('disabled',true).prop('checked',false);

            }
        });









        $('#a_customCheck1').change(function() {
            if ($('#a_customCheck1').prop('checked') == true) {
                $('#a_customCheck2').prop('disabled',false);
                $('#a_customCheck3').prop('disabled',false);
                $('#a_customCheck4').prop('disabled',false);
            }
            else{
                $('#a_customCheck2').prop('disabled',true).prop('checked',false);
                $('#a_customCheck3').prop('disabled',true).prop('checked',false);
                $('#a_customCheck4').prop('disabled',true).prop('checked',false);

            }
        });
        $('#a_customCheck5').change(function() {
            if ($('#a_customCheck5').prop('checked') == true) {
                $('#a_customCheck6').prop('disabled',false);
                $('#a_customCheck7').prop('disabled',false);
                $('#a_customCheck8').prop('disabled',false);
            }
            else{
                $('#a_customCheck6').prop('disabled',true).prop('checked',false);
                $('#a_customCheck7').prop('disabled',true).prop('checked',false);
                $('#a_customCheck8').prop('disabled',true).prop('checked',false);

            }
        });
        $('#a_customCheck9').change(function() {
            if ($('#a_customCheck9').prop('checked') == true) {
                $('#a_customCheck10').prop('disabled',false);
                $('#a_customCheck11').prop('disabled',false);
                $('#a_customCheck12').prop('disabled',false);
            }
            else{
                $('#a_customCheck10').prop('disabled',true).prop('checked',false);
                $('#a_customCheck11').prop('disabled',true).prop('checked',false);
                $('#a_customCheck12').prop('disabled',true).prop('checked',false);

            }
        });
        $('#a_customCheck17').change(function() {
            if ($('#a_customCheck17').prop('checked') == true) {
                $('#a_customCheck18').prop('disabled',false);
                $('#a_customCheck19').prop('disabled',false);
                $('#a_customCheck20').prop('disabled',false);
            }
            else{
                $('#a_customCheck18').prop('disabled',true).prop('checked',false);
                $('#a_customCheck19').prop('disabled',true).prop('checked',false);
                $('#a_customCheck20').prop('disabled',true).prop('checked',false);

            }
        });
        $('#a_customCheck22').change(function() {
            if ($('#a_customCheck22').prop('checked') == true) {
                $('#a_customCheck23').prop('disabled',false);
                $('#a_customCheck24').prop('disabled',false);
            }
            else{
                $('#a_customCheck23').prop('disabled',true).prop('checked',false);
                $('#a_customCheck24').prop('disabled',true).prop('checked',false);
            }
        });
        $('#a_customCheck25').change(function() {
            if ($('#a_customCheck25').prop('checked') == true) {
                $('#a_customCheck26').prop('disabled',false);
                $('#a_customCheck27').prop('disabled',false);
                $('#a_customCheck28').prop('disabled',false);
            }
            else{
                $('#a_customCheck26').prop('disabled',true).prop('checked',false);
                $('#a_customCheck27').prop('disabled',true).prop('checked',false);
                $('#a_customCheck28').prop('disabled',true).prop('checked',false);
            }
        });
        $('#a_customCheck30').change(function() {
            if ($('#a_customCheck30').prop('checked') == true) {
                $('#a_customCheck31').prop('disabled',false);
                $('#a_customCheck32').prop('disabled',false);
                $('#a_customCheck33').prop('disabled',false);
            }
            else{
                $('#a_customCheck31').prop('disabled',true).prop('checked',false);
                $('#a_customCheck32').prop('disabled',true).prop('checked',false);
                $('#a_customCheck33').prop('disabled',true).prop('checked',false);
            }
        });
        $('#a_customCheck34').change(function() {
            if ($('#a_customCheck34').prop('checked') == true) {
                $('#a_customCheck35').prop('disabled',false);
                $('#a_customCheck36').prop('disabled',false);
                $('#a_customCheck37').prop('disabled',false);
            }
            else{
                $('#a_customCheck35').prop('disabled',true).prop('checked',false);
                $('#a_customCheck36').prop('disabled',true).prop('checked',false);
                $('#a_customCheck37').prop('disabled',true).prop('checked',false);
            }
        });
        $('#a_customCheck38').change(function() {
            if ($('#a_customCheck38').prop('checked') == true) {
                $('#a_customCheck39').prop('disabled',false);
                $('#a_customCheck40').prop('disabled',false);
            }
            else{
                $('#a_customCheck39').prop('disabled',true).prop('checked',false);
                $('#a_customCheck40').prop('disabled',true).prop('checked',false);

            }
        });
        $('#a_customCheck41').change(function() {
            if ($('#a_customCheck41').prop('checked') == true) {
                $('#a_customCheck42').prop('disabled',false);
                $('#a_customCheck43').prop('disabled',false);
            }
            else{
                $('#a_customCheck42').prop('disabled',true).prop('checked',false);
                $('#a_customCheck43').prop('disabled',true).prop('checked',false);
            }
        });
        $('#a_customCheck44').change(function() {
            if ($('#a_customCheck44').prop('checked') == true) {
                $('#a_customCheck45').prop('disabled',false);
                $('#a_customCheck46').prop('disabled',false);
                $('#a_customCheck47').prop('disabled',false);
            }
            else{
                $('#a_customCheck45').prop('disabled',true).prop('checked',false);
                $('#a_customCheck46').prop('disabled',true).prop('checked',false);
                $('#a_customCheck47').prop('disabled',true).prop('checked',false);
            }
        });
        $('#a_customCheck48').change(function() {
            if ($('#a_customCheck48').prop('checked') == true) {
                $('#a_customCheck49').prop('disabled',false);
                $('#a_customCheck50').prop('disabled',false);
                $('#a_customCheck51').prop('disabled',false);
                // $('#a_customCheck59').prop('disabled',false);
            }
            else{
                $('#a_customCheck49').prop('disabled',true).prop('checked',false);
                $('#a_customCheck50').prop('disabled',true).prop('checked',false);
                $('#a_customCheck51').prop('disabled',true).prop('checked',false);
                // $('#a_customCheck59').prop('disabled',true).prop('checked',false);
            }
        });
        $('#a_customCheck52').change(function() {
            if ($('#a_customCheck52').prop('checked') == true) {
                $('#a_customCheck53').prop('disabled',false);
                $('#a_customCheck54').prop('disabled',false);
                $('#a_customCheck55').prop('disabled',false);
            }
            else{
                $('#a_customCheck53').prop('disabled',true).prop('checked',false);
                $('#a_customCheck54').prop('disabled',true).prop('checked',false);
                $('#a_customCheck55').prop('disabled',true).prop('checked',false);
            }
        });
        $('#a_customCheck56').change(function() {
            if ($('#a_customCheck56').prop('checked') == true) {
                $('#a_customCheck57').prop('disabled',false);
                $('#a_customCheck58').prop('disabled',false);
            }
            else{
                $('#a_customCheck57').prop('disabled',true).prop('checked',false);
                $('#a_customCheck58').prop('disabled',true).prop('checked',false);
            }
        });
        $('#a_customCheck66').change(function() {
            if ($('#a_customCheck66').prop('checked') == true) {
                $('#a_customCheck67').prop('disabled',false);
                $('#a_customCheck68').prop('disabled',false);
                $('#a_customCheck69').prop('disabled',false);
            }
            else{
                $('#a_customCheck67').prop('disabled',true).prop('checked',false);
                $('#a_customCheck68').prop('disabled',true).prop('checked',false);
                $('#a_customCheck69').prop('disabled',true).prop('checked',false);

            }
        });

        $('#a_customCheck70').change(function() {
            if ($('#a_customCheck70').prop('checked') == true) {
                $('#a_customCheck71').prop('disabled',false);
                $('#a_customCheck72').prop('disabled',false);
                $('#a_customCheck73').prop('disabled',false);
            }
            else{
                $('#a_customCheck71').prop('disabled',true).prop('checked',false);
                $('#a_customCheck72').prop('disabled',true).prop('checked',false);
                $('#a_customCheck73').prop('disabled',true).prop('checked',false);

            }
        });
















        $('#a_customCheck74').change(function() {
            if ($('#a_customCheck74').prop('checked') == true) {
                $('#a_customCheck75').prop('disabled',false);
            }
            else{
                $('#a_customCheck75').prop('disabled',true).prop('checked',false);


            }
        });

        $('#a_customCheck80').change(function() {
            if ($('#a_customCheck80').prop('checked') == true) {
                $('#a_customCheck81').prop('disabled',false);
                $('#a_customCheck82').prop('disabled',false);
                $('#a_customCheck83').prop('disabled',false);
            }
            else{
                $('#a_customCheck81').prop('disabled',true).prop('checked',false);
                $('#a_customCheck82').prop('disabled',true).prop('checked',false);
                $('#a_customCheck83').prop('disabled',true).prop('checked',false);

            }
        });




        $('#e_customCheck1').change(function() {
            if ($('#e_customCheck1').prop('checked') == true) {
                $('#e_customCheck2').prop('disabled',false);
                $('#e_customCheck3').prop('disabled',false);
                $('#e_customCheck4').prop('disabled',false);
            }
            else{
                $('#e_customCheck2').prop('disabled',true).prop('checked',false);
                $('#e_customCheck3').prop('disabled',true).prop('checked',false);
                $('#e_customCheck4').prop('disabled',true).prop('checked',false);

            }
        });
        $('#e_customCheck5').change(function() {
            if ($('#e_customCheck5').prop('checked') == true) {
                $('#e_customCheck6').prop('disabled',false);
                $('#e_customCheck7').prop('disabled',false);
                $('#e_customCheck8').prop('disabled',false);
            }
            else{
                $('#e_customCheck6').prop('disabled',true).prop('checked',false);
                $('#e_customCheck7').prop('disabled',true).prop('checked',false);
                $('#e_customCheck8').prop('disabled',true).prop('checked',false);

            }
        });
        $('#e_customCheck9').change(function() {
            if ($('#e_customCheck9').prop('checked') == true) {
                $('#e_customCheck10').prop('disabled',false);
                $('#e_customCheck11').prop('disabled',false);
                $('#e_customCheck12').prop('disabled',false);
            }
            else{
                $('#e_customCheck10').prop('disabled',true).prop('checked',false);
                $('#e_customCheck11').prop('disabled',true).prop('checked',false);
                $('#e_customCheck12').prop('disabled',true).prop('checked',false);

            }
        });
        $('#e_customCheck17').change(function() {
            if ($('#e_customCheck17').prop('checked') == true) {
                $('#e_customCheck18').prop('disabled',false);
                $('#e_customCheck19').prop('disabled',false);
                $('#e_customCheck20').prop('disabled',false);
            }
            else{
                $('#e_customCheck18').prop('disabled',true).prop('checked',false);
                $('#e_customCheck19').prop('disabled',true).prop('checked',false);
                $('#e_customCheck20').prop('disabled',true).prop('checked',false);
            }
        });
        $('#e_customCheck22').change(function() {
            if ($('#e_customCheck22').prop('checked') == true) {
                $('#e_customCheck23').prop('disabled',false);
                $('#e_customCheck24').prop('disabled',false);
            }
            else{
                $('#e_customCheck23').prop('disabled',true).prop('checked',false);
                $('#e_customCheck24').prop('disabled',true).prop('checked',false);
            }
        });
        $('#e_customCheck25').change(function() {
            if ($('#e_customCheck25').prop('checked') == true) {
                $('#e_customCheck26').prop('disabled',false);
                $('#e_customCheck27').prop('disabled',false);
                $('#e_customCheck28').prop('disabled',false);
            }
            else{
                $('#e_customCheck26').prop('disabled',true).prop('checked',false);
                $('#e_customCheck27').prop('disabled',true).prop('checked',false);
                $('#e_customCheck28').prop('disabled',true).prop('checked',false);
            }
        });
        $('#e_customCheck30').change(function() {
            if ($('#e_customCheck30').prop('checked') == true) {
                $('#e_customCheck31').prop('disabled',false);
                $('#e_customCheck32').prop('disabled',false);
                $('#e_customCheck33').prop('disabled',false);
            }
            else{
                $('#e_customCheck31').prop('disabled',true).prop('checked',false);
                $('#e_customCheck32').prop('disabled',true).prop('checked',false);
                $('#e_customCheck33').prop('disabled',true).prop('checked',false);
            }
        });
        $('#e_customCheck34').change(function() {
            if ($('#e_customCheck34').prop('checked') == true) {
                $('#e_customCheck35').prop('disabled',false);
                $('#e_customCheck36').prop('disabled',false);
                $('#e_customCheck37').prop('disabled',false);
            }
            else{
                $('#e_customCheck35').prop('disabled',true).prop('checked',false);
                $('#e_customCheck36').prop('disabled',true).prop('checked',false);
                $('#e_customCheck37').prop('disabled',true).prop('checked',false);
            }
        });
        $('#e_customCheck38').change(function() {
            if ($('#e_customCheck38').prop('checked') == true) {
                $('#e_customCheck39').prop('disabled',false);
                $('#e_customCheck40').prop('disabled',false);
                $('#e_customCheck61').prop('disabled',false);
            }
            else{
                $('#e_customCheck39').prop('disabled',true).prop('checked',false);
                $('#e_customCheck40').prop('disabled',true).prop('checked',false);
                $('#e_customCheck61').prop('disabled',true).prop('checked',false);
            }
        });
        $('#e_customCheck41').change(function() {
            if ($('#e_customCheck41').prop('checked') == true) {
                $('#e_customCheck42').prop('disabled',false);
                $('#e_customCheck43').prop('disabled',false);
            }
            else{
                $('#e_customCheck42').prop('disabled',true).prop('checked',false);
                $('#e_customCheck43').prop('disabled',true).prop('checked',false);
            }
        });
        $('#e_customCheck44').change(function() {
            if ($('#e_customCheck44').prop('checked') == true) {
                $('#e_customCheck45').prop('disabled',false);
                $('#e_customCheck46').prop('disabled',false);
                $('#e_customCheck47').prop('disabled',false);
            }
            else{
                $('#e_customCheck45').prop('disabled',true).prop('checked',false);
                $('#e_customCheck46').prop('disabled',true).prop('checked',false);
                $('#e_customCheck47').prop('disabled',true).prop('checked',false);
            }
        });
        $('#e_customCheck48').change(function() {
            if ($('#e_customCheck48').prop('checked') == true) {
                $('#e_customCheck49').prop('disabled',false);
                $('#e_customCheck50').prop('disabled',false);
                $('#e_customCheck51').prop('disabled',false);
                // $('#e_customCheck59').prop('disabled',false);
            }
            else{
                $('#e_customCheck49').prop('disabled',true).prop('checked',false);
                $('#e_customCheck50').prop('disabled',true).prop('checked',false);
                $('#e_customCheck51').prop('disabled',true).prop('checked',false);
                // $('#e_customCheck59').prop('disabled',true).prop('checked',false);
            }
        });
        $('#e_customCheck52').change(function() {
            if ($('#e_customCheck52').prop('checked') == true) {
                $('#e_customCheck53').prop('disabled',false);
                $('#e_customCheck54').prop('disabled',false);
                $('#e_customCheck55').prop('disabled',false);
            }
            else{
                $('#e_customCheck53').prop('disabled',true).prop('checked',false);
                $('#e_customCheck54').prop('disabled',true).prop('checked',false);
                $('#e_customCheck55').prop('disabled',true).prop('checked',false);
            }
        });
        $('#e_customCheck56').change(function() {
            if ($('#e_customCheck56').prop('checked') == true) {
                $('#e_customCheck57').prop('disabled',false);
                $('#e_customCheck58').prop('disabled',false);
            }
            else{
                $('#e_customCheck57').prop('disabled',true).prop('checked',false);
                $('#e_customCheck58').prop('disabled',true).prop('checked',false);
            }
        });
        $('#e_customCheck66').change(function() {
            if ($('#e_customCheck66').prop('checked') == true) {
                $('#e_customCheck67').prop('disabled',false);
                $('#e_customCheck68').prop('disabled',false);
                $('#e_customCheck69').prop('disabled',false);
            }
            else{
                $('#e_customCheck67').prop('disabled',true).prop('checked',false);
                $('#e_customCheck68').prop('disabled',true).prop('checked',false);
                $('#e_customCheck69').prop('disabled',true).prop('checked',false);
            }
        });



        $('#e_customCheck88').change(function() {
            if ($('#e_customCheck88').prop('checked') == true) {
                $('#e_customCheck89').prop('disabled',false);

            }
            else{
                $('#e_customCheck89').prop('disabled',true).prop('checked',false);

            }
        });

        $('#e_customCheck84').change(function() {
            if ($('#e_customCheck84').prop('checked') == true) {
                $('#e_customCheck85').prop('disabled',false);
                $('#e_customCheck86').prop('disabled',false);
                $('#e_customCheck87').prop('disabled',false);
            }
            else{
                $('#e_customCheck85').prop('disabled',true).prop('checked',false);
                $('#e_customCheck86').prop('disabled',true).prop('checked',false);
                $('#e_customCheck87').prop('disabled',true).prop('checked',false);
            }
        });














        $('#e_customCheck70').change(function() {
            if ($('#e_customCheck70').prop('checked') == true) {
                $('#e_customCheck71').prop('disabled',false);
                $('#e_customCheck72').prop('disabled',false);
                $('#e_customCheck73').prop('disabled',false);
            }
            else{
                $('#e_customCheck71').prop('disabled',true).prop('checked',false);
                $('#e_customCheck72').prop('disabled',true).prop('checked',false);
                $('#e_customCheck73').prop('disabled',true).prop('checked',false);
            }
        });
    </script>
@endsection
