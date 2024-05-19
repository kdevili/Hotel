@extends('User.lay')

@section('title' , __('Ravan Resort Tangalle Food Menu'))

@section('metadata')
    <meta property="og:title" content="Ravan Resort Tangalle Food Menu">
    <meta property="og:description" content="Check out our delicious food menu at Ravan Resort Tangalle">
    <meta property="og:image" content="{{ asset('images/og-image.png') }}">
    <meta property="og:url" content="https://hms.ravantangalle.com/menu/1">

@endsection

@section('style')

    <style>
        .item-number {
            background-color: #8c862e;
            color: #fff;
            position: absolute;
            padding: 3px 6px;
            font-weight: 500;
        }
        .whatsappbtn{
            color: #25d366;
        }
        .whatsappbtn:hover{
            background-color: #25d366;
            color: #fff;
        }


    </style>

@endsection

@section('content')
    <div class="nk-block nk-block-middle nk-auth-body  wide-md" style="max-width: 95%">

        <div class="card card-bordered">
            <div class="card-inner card-inner-lg">
                <div class="nk-block-head">
                    <div class="nk-block-head-content">
                        <h4 class="nk-block-title text-center"> Ravan Menu</h4>
                        <div class="nk-block-des">
                            <p>{{--Access the Dashlite panel using your email and passcode.--}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 pb-5">
                    <div class="form-group">
                        <div class="form-control-wrap">
                            <div class="form-text-hint">
                                <span class="overline-title">Search</span>
                            </div>
                            <input type="text" class="form-control" id="search-input" placeholder="Search...">
                        </div>
                    </div>
                </div>
                <div class="row">
                @foreach($items as $item)
                    @if ($item->image != null)
                            <div class="col-lg-4 col-md-6 col-sm-12 pb-4 menu_item_list" data-item_name="{{$item->item_code}} {{$item->name}}">
                                <div class="card card-bordered">
                                    <div class="item-number">{{$item->item_code}}</div>
                                    <img src="{{ asset('storage/') }}/{{$item->image}}" class="card-img-top" alt="">
                                    <div class="card-inner">
                                        <p class="card-text"><b>{{$item->name}} - LKR {{$item->price}}/-</b></p>
                                        <p class="card-text">{{$item->special_note}}</p>
                                        <center><a href="https://wa.me/+94706522566?text=Hi, I'd like to order the [{{$item->item_code}}]-{{$item->name}}. Can you please let me know how long it will take to prepare? I need it by%2E%2E%2E" class="btn btn-outline-success whatsappbtn" ><em class="icon ni ni-whatsapp-round"></em><span>Order +94706522566</span></a></center>
                                    </div>
                                </div>
                            </div>
                    @endif

                @endforeach
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <p class="card-text small">* 10% service charge will be added to your bill</p>
                    </div>

                </div>

            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        $(document).ready(function(){
            // Listen for input changes in the search input field
            $('#search-input').on('input', function() {
                // Get the search query
                var query = $(this).val().toLowerCase();

                // Loop through each card and hide/show based on the search query
                $('.menu_item_list').each(function() {
                    var item_name = $(this).data('item_name').toLowerCase();
                    if (item_name.indexOf(query) === -1) {
                        $(this).hide();
                    } else {
                        $(this).show();
                    }
                });
            });
        });
    </script>
@endsection
