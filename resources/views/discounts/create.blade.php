@extends('layouts.app')
@section('content')

    <div class="container-fluid">
        <!-- row -->
        <div class="row m-t-20">
            <div class="col-md-12">
                <div class="white-box">
                    <!-- .left-right-aside-column-->
                    <div class="page-aside">

                        <form role="form" id="discount-form" action="{{url('api/v1/discounts')}}" method="post">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" class="form-control" name="title" id="title" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control" name="description" required></textarea>
                                    </div>


                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Type</label>
                                                <div class="radio radio-success">
                                                    <input type="radio" value="3" name="type" id="offer">
                                                    <label for="offer">Offer</label>
                                                </div>
                                                <div class="radio radio-success">
                                                    <input type="radio" checked="checked" value="2" name="type"
                                                           id="coupon">
                                                    <label for="coupon">Coupon</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Code</label>
                                                <input type="text" id="code" name="code" class="form-control">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label>Max Use/Customer:</label>
                                        <input type="text" class="form-control" name="max_use_customer" id="max_user"
                                               value="0" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Max Use/Device:</label>
                                        <input type="text" class="form-control" name="max_use_device"
                                               id="max_device_use" value="1" required>
                                    </div>
                                </div>

                                <div class="col-md-4">


                                    {{--<div class="row" id="customer_section">--}}
                                    {{--<br/>--}}
                                    {{--<label data-placement='center'><b>Select Customer</b></label><br/>--}}
                                    {{--<select id="select_customer" name="customer" class="full-width">--}}

                                    {{--<option value="">All Customers</option>--}}
                                    {{----}}
                                    {{--@foreach ($allCustomerList as $customer)--}}
                                    {{----}}
                                    {{--<option value="{{$customer->id}}">{{$customer->name}}</option>--}}
                                    {{--@endforeach--}}

                                    {{--</select>--}}
                                    {{--</div>--}}

                                    <div class="form-group">
                                        <label>Valid For</label>
                                        <div class="radio radio-success">
                                            <input type="radio" checked="checked" value="FOOD" name="valid_for"
                                                   id="food">
                                            <label for="food">Food</label>
                                            <input type="radio" value="WATER" name="valid_for" id="water">
                                            <label for="water">Water</label>
                                        </div>
                                    </div>


                                    <div class="form-group" id="restaurant_section" style="margin-bottom: 5%;">
                                        <label data-placement='center'><b>Select Restaurant</b></label><br/>
                                        <select id="select_restaurant" name="restaurant" class="full-width">
                                            <option value="all_restaurants">All Restaurants</option>
                                        </select>
                                    </div>

                                    <label><b>Applicable On:</b></label>
                                    <br/>
                                    <div class="radio radio-success">
                                        <input type="radio" checked="checked" value="1" name="applicable_on" id="orders"
                                               data-value="orders" restaurant-id="0">
                                        <label for="orders">Orders</label>
                                        <input type="radio" value="2" name="applicable_on" id="catagories"
                                               data-value="categories">
                                        <label for="catagories">Catagories</label>
                                        <input type="radio" value="3" name="applicable_on" id="items"
                                               data-value="items">
                                        <label for="items">Items</label>
                                    </div>
                                    <input type="hidden" id="hidden_restaurant_id">


                                    <div class="row" id="extra_apply" style="display: none;">
                                        <br/>
                                        <label data-placement='center'><b id="innr_txt"></b></label><br/>
                                        <select id="multi" class="full-width" name="selected_menu_type" multiple>
                                        </select>
                                    </div>

                                    <br/>
                                    <div class="row">

                                        <div class="col-sm-7">
                                            <div class="form-group form-group-default ">
                                                <label>Min Order Amount:</label>
                                                <input type="text" class="form-control" value="0" id="min_order"
                                                       name="min_order" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-5">
                                            <div class="form-group form-group-default ">
                                                <label>Min Quantity:</label>
                                                <input type="text" class="form-control" id="min_quantity" value="0"
                                                       name="min_quantity" required>
                                            </div>
                                        </div>

                                    </div>

                                    <br/>
                                    <label for="datepicker-range">Validity:</label>
                                    <div class="input-daterange input-group" id="datepicker-range">
                                        <input type="text" class="timer input-sm form-control" name="start"
                                               id="val_from"/>
                                        <span class="input-group-addon">to</span>
                                        <input type="text" class="timer input-sm form-control" name="end" id="val_to"/>
                                    </div>


                                </div>

                                <div class="col-md-4">
                                    <div class="padding-30 ">


                                        <br/>

                                        <div class="row">
                                            <div class="col-sm-8">
                                                <label><b>Discounted Amount:</b></label>
                                                <br/>
                                                <div class="radio radio-success">
                                                    <input type="radio" checked="checked" value="1" name="discount"
                                                           id="Percentage">
                                                    <label for="Percentage">Percentage</label>
                                                    <input type="radio" value="2" name="discount" id="Fixed">
                                                    <label for="Fixed">Fixed</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group form-group-default ">
                                                    <label><b>value:</b></label>
                                                    <input type="text" class="form-control" id="item_value"
                                                           name="item_value" placeholder="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="checkbox-iblock checkbox check-success checkbox-circle">
                                            <input type="checkbox" name="featured" value="" id="featured">
                                            <label for="featured">Is Featured</label>
                                        </div>

                                        <div class="padding-30">
                                            <label><b>Image</b></label>
                                            <input type="hidden" name="images"
                                                   value="@if(isset($restaurantDetails->image_ids)){{$restaurantDetails->image_ids}}@endif">
                                            <div id='coupon-image' class="dropzone">
                                                <div class="dz-default dz-message"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                        <div style="margin-left: 33%;">
                                            <button id="submit" type="submit" onclick=""
                                                    class="btn btn-primary btn-cons"><i class="fa fa-plus"></i> Create
                                                Coupon
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-4"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>

        <script>
            window.onload = function () {

                $('form').submit(function (e) {
                    e.preventDefault();

                    alert(1);

                    console.log(e);
                    return false;
                });

                var buttons = [
                    {
                        text: 'Add New Item',
//                    className : 'btn btn-info',
                        action: function (e, dt, node, config) {
                            $('#add-item').modal('show');
                        }
                    },
                    {
                        text: 'Add New Category',
//                    className : 'btn btn-info',
                        action: function (e, dt, node, config) {
                            $('#add-category').modal('show');
                        }
                    }
                ];
                var table = initDataTable('#items-table', buttons);

                setTimeout(function () {
                    $('.dataTables_wrapper').removeClass('form-inline');
                    $('.dataTables_wrapper .modal form').css('display', 'block');
                }, 500);

                $(document).on('click', '.item-action', function (event) {
                    var that = this;
                    swal.queue([{
                        title: $(that).data('action') + ' Item',
                        text: "Are you sure?",
                        confirmButtonText: $(that).data('action') + ' Item',
                        confirmButtonColor: '#f55753',
                        showCancelButton: true,
                        showLoaderOnConfirm: true,
                        preConfirm: function () {
                            console.log();
                            return new Promise(function (resolve) {
                                $(that).parent('form').submit();
                            })
                        }
                    }]);
                });
            }
        </script>
@endsection