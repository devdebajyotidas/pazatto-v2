@extends('layouts.app')
@section('content')

    <div class="container-fluid">
        <!-- row -->
        <div class="row m-t-20">
            <div class="col-md-4 col-xs-12 hidden">
                <div class="white-box">
                    <div class="user-bg">
                        <img width="100%" alt="user"
                             src="{{ ($vendor->featured_image)? asset('uploads/'.$vendor->featured_image) : 'http://sanarch.in/public/images/defaultAvatar.png' }}">
                    </div>
                    <div class="user-btm-box">
                        <!-- .row -->
                        <div class="row text-center m-t-10">
                            <div class="col-md-6 b-r"><strong>Name</strong>
                                <p>{{ $vendor->name }}</p>
                            </div>
                            <div class="col-md-6"><strong>Contact Person</strong>
                                <p>{{ $vendor->contact_person }}</p>
                            </div>
                        </div>
                        <!-- /.row -->
                        <hr>
                        <!-- .row -->
                        <div class="row text-center m-t-10">
                            <div class="col-md-6 b-r"><strong>Email ID</strong>
                                <p>{{ isset($vendor->user) ? $vendor->user->email : 'N/A' }}</p>
                            </div>
                            <div class="col-md-6"><strong>Phone</strong>
                                <p>{{ $vendor->phone }}</p>
                            </div>
                        </div>
                        <!-- /.row -->
                        <hr>
                        <!-- .row -->
                    {{--<div class="row text-center m-t-10">--}}
                    {{--<div class="col-md-12"><strong>Address</strong>--}}
                    {{--<p>E104, Dharti-2, Chandlodia Ahmedabad--}}
                    {{--<br/> Gujarat, India.</p>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--<hr>--}}
                    <!-- /.row -->
                        <div class="col-md-4 col-sm-4 text-center">
                            {{--<p class="text-purple"><i class="ti-facebook"></i></p>--}}
                            <p class="text-purple">Menu Items</p>
                            <h1>{{ $vendor->items()->count() }}</h1>
                        </div>
                        <div class="col-md-4 col-sm-4 text-center">
                            {{--<p class="text-blue"><i class="ti-twitter"></i></p>--}}
                            <p class="text-blue">Orders Received</p>
                            <h1>{{ $vendor->orders()->count()  }}</h1>
                        </div>
                        <div class="col-md-4 col-sm-4 text-center">
                            {{--<p class="text-danger"><i class="ti-dribbble"></i></p>--}}
                            <p class="text-info">Order Delivered</p>
                            <h1>{{ $vendor->orders()->where('status', '=', 5)->count() }}</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-xs-12">
                <div class="white-box p-0">
                    @include('vendors.form')
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->

    <script>
        window.onload = function () {
            initVendorForm();
        }
    </script>

@endsection