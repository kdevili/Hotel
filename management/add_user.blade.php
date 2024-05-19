@extends('management.lay')


@section('title' , __(''))

@section('style')
    <style>
        @media (max-width: 768px) {
            .item-row-bg{
                background-color: #e5e9f2;
                padding-bottom: 1rem;
                padding-top: 1rem;
            }
        }
    </style>

@endsection

@section('content')

    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Add Users</h3>
                <div class="nk-block-des text-soft">
                    <p></p>
                </div>
            </div><!-- .nk-block-head-content -->
            <div class="nk-block-head-content">
                <div class="toggle-wrap nk-block-tools-toggle">
                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                    <div class="toggle-expand-content" data-content="pageMenu">
                        <ul class="nk-block-tools g-3">

                            {{--                            <li class="nk-block-tools-opt d-none d-sm-block">--}}
                            {{--                                <a href="{{route('hotel/grn/view')}}" type="button" class="btn btn-primary" ><em class="icon ni ni-activity"></em><span>Show Item</span></a>--}}
                            {{--                            </li>--}}
                            <li class="nk-block-tools-opt d-block d-sm-none">
                                <a href="#" class="btn btn-icon btn-primary"><em class="icon ni ni-plus"></em></a>
                            </li>
                        </ul>
                    </div>
                </div><!-- .toggle-wrap -->
            </div><!-- .nk-block-head-content -->
        </div><!-- .nk-block-between -->
    </div><!-- .nk-block -->
    <div class="nk-block">

        <div class="card card-bordered">
            <div class="card-inner">
                                <div class="card-head">
                                    <h5 class="card-title">Personal Information</h5>
                                </div>
                <form action="{{ route('hotel/user/save') }}" method="post" id="add-item-stock" enctype="multipart/form-data">
                    @csrf
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
                                            <label class="form-label" for="email-address-1">Select Hotel</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-select">
                                                    <select class="form-control" id="hotel_id" name="hotel_id">
                                                        @foreach($hotels as $hotel)
                                                        <option value="{{$hotel->id}}">{{$hotel->hotel_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item-row-bg">
                                <div class="row g-4">
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
                                    <div class="col-lg-6">
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
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <th scope="row">1</th>
                                                <td>Recipe</td>
                                                <td><div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="customCheck1" name="recipe_v">
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
                                                        <input type="checkbox" class="custom-control-input" id="customCheck5" name="stock_v">
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
                                                        <input type="checkbox" class="custom-control-input" id="customCheck9" name="grn_v">
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
                                            </tr>
                                            <tr>
                                                <th scope="row">4</th>
                                                <td>POS</td>
                                                <td><div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="customCheck13" name="pos_v">
                                                        <label class="custom-control-label" for="customCheck13"></label>
                                                    </div></td>
                                                <td> - </td>
                                                <td>
                                                    -
                                                </td>
                                                <td>
                                                    -
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">5</th>
                                                <td>Waste</td>
                                                <td><div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="customCheck17" name="waste_v">
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
                                                        <input type="checkbox" class="custom-control-input" id="customCheck21" name="past_v">
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
                                                        <input type="checkbox" class="custom-control-input" id="customCheck22" name="waste_v">
                                                        <label class="custom-control-label" for="customCheck22"></label>
                                                    </div></td>
                                                <td><div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="customCheck23" name="waste_a" disabled>
                                                        <label class="custom-control-label" for="customCheck23"></label>
                                                    </div></td>
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="customCheck24" name="waste_e" disabled>
                                                        <label class="custom-control-label" for="customCheck24"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="customCheck25" name="waste_d" disabled>
                                                        <label class="custom-control-label" for="customCheck25"></label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">7</th>
                                                <td>Inventory Bill/Category</td>
                                                <td><div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="customCheck22" name="waste_v">
                                                        <label class="custom-control-label" for="customCheck22"></label>
                                                    </div></td>
                                                <td><div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="customCheck23" name="waste_a" disabled>
                                                        <label class="custom-control-label" for="customCheck23"></label>
                                                    </div></td>
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="customCheck24" name="waste_e" disabled>
                                                        <label class="custom-control-label" for="customCheck24"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="customCheck25" name="waste_d" disabled>
                                                        <label class="custom-control-label" for="customCheck25"></label>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-4">
                            {{--                        <div class="col-lg-12">--}}
                            {{--                            <div class="form-group">--}}
                            {{--                                <button type="button" class="btn btn-dim btn-primary mt-2 float-end" onclick="addrow()">ADD</button>--}}
                            {{--                            </div>--}}
                            {{--                        </div>--}}
                            <div class="col-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-lg btn-primary">Save User</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection

@section('script')
    <script>
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
    </script>

@endsection
