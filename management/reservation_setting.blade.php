@extends('management.lay' )

@section('title' , __(''))

@section('style')

@endsection

@section('content')
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Reservation</h3>
                <div class="nk-block-des text-soft">
                    <p>You in <span class="text-warning">{{$hotel->hotel_chain->name}}</span>  <em class="icon ni ni-forward-arrow-fill"></em> <span class="text-success">{{$hotel->hotel_name}}</span></p>
                </div>
            </div><!-- .nk-block-head-content -->
            <div class="nk-block-head-content">
                <div class="toggle-wrap nk-block-tools-toggle">
                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                    <div class="toggle-expand-content" data-content="pageMenu">
                        <ul class="nk-block-tools g-3">
                            @php
                                if(isset($setting)){
                                $cash_payment = \App\Cashbook::find($setting->cash_payment);
                                $card_payment = \App\Cashbook::find($setting->card_payment);
                                $advance_payment = \App\Cashbook::find($setting->advance_payment);
                                }
                            @endphp
                            @if(!isset($setting))
                            <li class="nk-block-tools-opt d-none d-sm-block">
                                <a href="#" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add-reservation"><em class="icon ni ni-plus"></em><span>Add Setting</span></a>
                            </li>
                            <li class="nk-block-tools-opt d-block d-sm-none">
                                <a href="#" class="btn btn-icon btn-primary"><em class="icon ni ni-plus"></em></a>
                            </li>
                            @endif
                            @if(isset($setting))
                            <li class="nk-block-tools-opt d-none d-sm-block">
                                <a href="#" type="button" class="btn btn-primary" data-bs-toggle="modal" onclick="get_reservation_details('{{$setting->id}}')"><em class="icon ni ni-plus"></em><span>Edit Setting</span></a>
                            </li>
                            <li class="nk-block-tools-opt d-block d-sm-none">
                                <a href="#" class="btn btn-icon btn-primary"><em class="icon ni ni-plus"></em></a>
                            </li>
                            @endif
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
                    <div class="col-lg-12 col-sm-6">
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <div class="team">
                                    <div class="user-card user-card-s2">
                                        <div class="gallery-image popup-image">
                                            @if(isset($setting) and $setting->image != null)
                                            <img src="{{asset('storage')}}/{{$setting->image}}" alt="">
                                            @else
                                            <h4 class="text-warning">Please upload Logo</h4>
                                            @endif
                                        </div>
                                    </div>
                                    <ul class="pricing-features">
                                        <li><span class="w-50">Cash Payment Cash Book</span> - <span class="ms-auto">
                                                {{isset($cash_payment->name)?$cash_payment->name:'Choose Cash Book'}}
                                            </span>
                                        </li>
                                        <li><span class="w-50">Card Payment Cash Book</span> - <span class="ms-auto">
                                                {{isset($card_payment->name)?$card_payment->name:'Choose Cash Book'}}</span></li>
                                        <li><span class="w-50">Advance Payment Cash Book</span> - <span class="ms-auto">
                                                {{isset($advance_payment->name)?$advance_payment->name:'Choose Cash Book'}}</span></li>
                                    </ul>
                                </div><!-- .team -->
                            </div><!-- .card-inner -->
                        </div><!-- .card -->

                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal hide fade" role="dialog" aria-hidden="true" id="modal-add-reservation">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title"> Add Reservation Setting</h5>
                </div>
                <div class="modal-body" id="">
                    <form action="{{route('management/reservation_setting/save')}}" method="post" id="add_reservation_setting" enctype="multipart/form-data">
                        @csrf
                            <div class="row g-4" id="">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="default-06">Choose Hotel Logo</label>
                                        <div class="form-control-wrap">
                                            <div class="form-file">
                                                <input type="file" class="form-file-input" id="logo" name="logo">
                                                <label class="form-file-label" for="logo">Choose file</label>
                                            </div>
                                            </div>
                                        </div>
                                    </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="email-addeekjr">Select Cash Book For Card Payments</label>
                                        <div class="form-control-wrap">
                                            <select class="form-select js-select2" data-search="on" id="card-cashbook-id" name="card-cashbook-id">
                                                <option value="">Select Cash Book</option>
                                                @foreach($cash_books as $cash_book)
                                                    <option value="{{$cash_book->id}}">{{$cash_book->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="email-adjhjkwwdeer">Select Cash Book For Cash Payments</label>
                                        <div class="form-control-wrap">
                                            <select class="form-select js-select2" data-search="on" id="cash-cashbook-id" name="cash-cashbook-id">
                                                <option value="">Select Cash Book</option>
                                                @foreach($cash_books as $cash_book)
                                                    <option value="{{$cash_book->id}}">{{$cash_book->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="email-adwhkhwdeer">Select Cash Book For Advance Payments</label>
                                        <div class="form-control-wrap">
                                            <select class="form-select js-select2" data-search="on" id="advance-cashbook-id" name="advance-cashbook-id">
                                                <option value="">Select Cash Book</option>
                                                @foreach($cash_books as $cash_book)
                                                    <option value="{{$cash_book->id}}">{{$cash_book->name}}</option>
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
                        <button type="button" class="btn btn-danger btn-lg" data-bs-dismiss="modal">Close</button>
                        <button type="button" onclick="$('#add_reservation_setting').submit();" class="btn btn-lg btn-primary">Save Setting</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal hide fade" role="dialog" aria-hidden="true" id="modal-edit-reservation">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title"> Edit Reservation Setting</h5>
                </div>
                <div class="modal-body" id="">
                    <form action="{{route('management/reservation_setting_edit/save')}}" method="post" id="edit_reservation_setting" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="e_setting_id" id="e_setting_id">
                            <div class="row g-4" id="">
                                <div class="col-lg-6" id="setting-edit-attchment">
                                    <div class="form-group">
                                        <label class="form-label" for="full-name-12">LOGO</label>
                                        <div class="col-sm-12" id="att-55">
                                            <img src="{{asset('images/gallery/thumb/15.jpg')}}" class="img-fluid" alt="">
                                            <br>
                                            <button type="button" class="waves-effect waves-light btn btn-dark btn-xs btn-block mb-5" onclick="logo_attachment_change()"><i class="fa fa-trash"></i> Change</button>
                                        </div>
                                    </div>
                                    </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="email-addeewwwkjr">Select Cash Book For Card Payments</label>
                                        <div class="form-control-wrap">
                                            <select class="form-select js-select2" data-search="on" id="e_card-cashbook-id" name="e_card-cashbook-id">
                                                <option value="">Select Cash Book</option>
                                                @foreach($cash_books as $cash_book)
                                                    <option value="{{$cash_book->id}}">{{$cash_book->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="email-awwdjhjkwwdeer">Select Cash Book For Cash Payments</label>
                                        <div class="form-control-wrap">
                                            <select class="form-select js-select2" data-search="on" id="e_cash-cashbook-id" name="e_cash-cashbook-id">
                                                <option value="">Select Cash Book</option>
                                                @foreach($cash_books as $cash_book)
                                                    <option value="{{$cash_book->id}}">{{$cash_book->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="email-fffadwhkhwdeer">Select Cash Book For Advance Payments</label>
                                        <div class="form-control-wrap">
                                            <select class="form-select js-select2" data-search="on" id="e_advance-cashbook-id" name="e_advance-cashbook-id">
                                                <option value="">Select Cash Book</option>
                                                @foreach($cash_books as $cash_book)
                                                    <option value="{{$cash_book->id}}">{{$cash_book->name}}</option>
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
                        <button type="button" class="btn btn-danger btn-lg" data-bs-dismiss="modal">Close</button>
                        <button type="button" onclick="$('#edit_reservation_setting').submit();" class="btn btn-lg btn-primary">Save Setting</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')
    <script>
        function logo_attachment_change(){
            $('#setting-edit-attchment').html('');

            var image_chage =
                '                            <div class="form-group">\n' +
                '                                <label class="form-label" for="email-addqwqwdqdress-12">Choose Logo</label>\n' +
                '                                <div class="form-control-wrap">\n' +
                '                                    <input type="file" class="form-control" id="e_image" name="e_image">\n' +
                '                                </div>\n' +

                '                        </div>';


            $('#setting-edit-attchment').html(image_chage);
        }
    function get_reservation_details(setting_id) {
        $.ajax({
            type:'POST',
            url:'{{ route('management/reservation_setting/get_details') }}',
            headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
            data: {
                'setting_id' : setting_id,
            },
            success: function (data) {
               var logo_att = '';
                logo_att += '<div class="col-sm-12" id="att-">\n' +
                    '        <img src="{{asset("storage")}}/'+ data.setting.image+'" class="img-fluid w-100" alt="">\n' +
                    '        <br>\n' +
                    '        <button type="button" class="waves-effect waves-light btn btn-dark btn-xs btn-block mb-5" onclick="logo_attachment_change();"><i class="fa fa-trash"></i> Change</button>\n' +
                    '        </div>';
                $('#setting-edit-attchment').html(logo_att);
                $('#e_card-cashbook-id').val(data.setting.card_payment).trigger("change");
                $('#e_cash-cashbook-id').val(data.setting.cash_payment).trigger("change");
                $('#e_advance-cashbook-id').val(data.setting.advance_payment).trigger("change");
                $('#e_setting_id').val(data.setting.id);
                $('#modal-edit-reservation').modal('show');
            }
        });

    }
        {{--$('#restarants-table tbody').on('click',--}}
        {{--    'a',--}}
        {{--    function () {--}}
        {{--        if ( $(this).hasClass('updateRecordButton') ) {--}}
        {{--            var data = NioApp.DataTable.row($(this).parents('tr')).data(); //Retrieve row data--}}
        {{--            var tr = $(this).closest('tr'); //Find DataTables table row--}}
        {{--            var theRowObject = NioApp.DataTable.row(tr); //Get DataTables row object--}}
        {{--            var restaurant_id = $(this).data('restaurantid');--}}
        {{--            global_theRowObject=theRowObject;--}}
        {{--            console.log(data);--}}
        {{--            $.ajax({--}}
        {{--                type:'POST',--}}
        {{--                url:'{{ route('management/restaurant/get_edit_restaurant_details') }}',--}}
        {{--                headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},--}}
        {{--                data: {--}}
        {{--                    'restaurant_id' : restaurant_id,--}}
        {{--                },--}}
        {{--                success:function(data){--}}
        {{--                    console.log(data);--}}
        {{--                    $('#e_restaurant_id').val(data.restaurant.id)--}}
        {{--                    $('#e_restaurant_name').val(data.restaurant.name)--}}
        {{--                    $('#e_cash-cashbook-id').val(data.restaurant.cash_payment).trigger("change");--}}
        {{--                    $('#e_card-cashbook-id').val(data.restaurant.card_payment).trigger("change");--}}

        {{--                    $('#modal-edit-restaurant').modal('show');--}}

        {{--                }--}}

        {{--            });--}}

        {{--        }--}}
        {{--        if ( $(this).hasClass('deleteRecordButton') ) {--}}
        {{--            var data = NioApp.DataTable.row($(this).parents('tr')).data(); //Retrieve row data--}}
        {{--            var tr = $(this).closest('tr'); //Find DataTables table row--}}
        {{--            var theRowObject = NioApp.DataTable.row(tr); //Get DataTables row object--}}
        {{--            var restaurant_id = $(this).data('restaurantid');--}}
        {{--            // global_theRowObject2=theRowObject;--}}
        {{--            $.ajax({--}}
        {{--                type:'POST',--}}
        {{--                url:'{{ route('management/restaurant/delete') }}',--}}
        {{--                headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},--}}
        {{--                data: {--}}
        {{--                    'restaurant_id' : restaurant_id,--}}
        {{--                },--}}
        {{--                success:function(data){--}}
        {{--                    if(data.success){--}}
        {{--                        NioApp.Toast('Successfully Deleted Restaurant', 'success',{position: 'top-right'});--}}
        {{--                        NioApp.DataTable.row(theRowObject).remove().draw();--}}
        {{--                    }else{--}}
        {{--                        NioApp.Toast(data.error, 'warning',{position: 'top-right'});--}}
        {{--                    }--}}
        {{--                }--}}

        {{--            });--}}

        {{--        }--}}
        {{--    });--}}




    </script>


@endsection
