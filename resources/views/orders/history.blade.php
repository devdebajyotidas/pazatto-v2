{{--{{ dd(count($errors->service->all()))  }}--}}
@extends('layouts.app')
@section('content')

    <div class="container-fluid">
        <!-- row -->
        <div class="row m-t-20">
            <div class="col-md-12">
                <div class="white-box p-0">
                    <!-- .left-right-aside-column-->
                    <div class="page-aside">
                        <!-- .left-aside-column-->
                        <div class="left-aside">
                            <div class="scrollable">
                                <ul id="service-list" class="list-style-none">
                                    <li class="box-label">
                                        <a href="javascript:void(0)" class="service" data-id="" data-name="">
                                            All Orders
                                            <span> {{ count($orders) }} </span>
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    @if(isset($services))
                                        @foreach($services as $service)
                                            <li>
                                                <a href="javascript:void(0)" class="service"
                                                   data-id="{{ $service->id }}" data-name="{{ $service->name }}">
                                                    {{ $service->name }}
                                                    <span class="vendor-count">{{ $service->orders_count  }}</span>
                                                </a>
                                            </li>
                                        @endforeach
                                    @endif
                                    <li class="divider"></li>
                                </ul>
                            </div>
                        </div>
                        <!-- /.left-aside-column-->
                        <div class="right-aside">
                            <div class="right-page-header">
                            </div>
                            <div class="clearfix"></div>
                            <div class="scrollable">
                                <div class="table-responsive">
                                    <table id="orders-table" class="display responsive nowrap table m-t-30 table-hover contact-list"
                                           data-page-size="10" data-filter="#search-learner">
                                        <thead>
                                        <tr>
                                            <th data-visible="false">Service</th>
                                            <th data-priority="1" width="5%">ID</th>
                                            <th data-priority="9">Customer </th>
                                            <th data-priority="13">Agent </th>
                                            <th data-priority="8">Vendor</th>
                                            <th data-priority="4">Amount</th>
                                            <th data-priority="13">Items</th>
                                            <th data-priority="4">Placed On</th>
                                            <th data-priority="11">Notes</th>
                                            <th data-priority="12">Delivery Location</th>
                                            <th data-priority="10">Payment Method</th>
                                            <th data-priority="3">Status</th>
                                            <th data-priority="2" width="95%">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(isset($orders))
                                            @foreach($orders as $key => $order)
                                                <tr>
                                                    <td>
                                                        @if(isset($order->vendor) && isset($order->vendor->service))
                                                            {{ $order->vendor->service->name }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{--<button class="btn btn-sm btn-icon btn-outline btn-info">--}}
                                                        {{--<i class="fa fa-plus"></i>--}}
                                                        {{ '#' . $order->id }}
                                                        {{--</button>--}}
                                                    </td>
                                                    <td>
                                                        {{ isset($order->customer->first_name) ? $order->customer->first_name : ''}}
                                                        {{ isset($order->customer->last_name) ? $order->customer->last_name : ''}}
                                                        <br>
                                                        @if(session('role') == 'agent')
                                                            <a href="tel:{{ $order->customer->user->mobile }}" class="btn btn-sm btn-pure btn-icon btn-outline btn-info">
                                                                <i class="fa fa-phone"></i>
                                                                Call
                                                            </a>
                                                            <a href="https://maps.google.com/maps?f=d&daddr={{ str_replace('#', '', $order->delivery_location) }}" class="btn btn-sm btn-pure btn-icon btn-outline btn-info">
                                                                <i class="fa fa-phone"></i>
                                                                Navigate
                                                            </a>
                                                        @else
                                                            {{ isset($order->customer) ? $order->customer->user->mobile : 'N/A' }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ isset($order->agent) ? $order->agent->first_name . " " . $order->agent->last_name : 'N/A'}}
                                                    </td>
                                                    <td>
                                                        @if(isset($order->vendor))
                                                            {{ $order->vendor->name }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $order->total }}</td>
                                                    <td>
                                                        @foreach($order->lines as $line)
                                                            <span class="pull-left">
                                                                    {{ $line->item_name }}
                                                                </span>
                                                            <span class="pull-right">
                                                                    {{ $line->item_price }} x {{ $line->quantity }}
                                                                </span>
                                                            <span class="clearfix"></span>
                                                            <br>
                                                        @endforeach
                                                        <hr>
                                                        Sub-Total: {{ $order->sub_total }}
                                                        <br>
                                                        Packing Charge: {{ $order->packing_charge }}
                                                        <br>
                                                        Delivery Charge: {{ $order->delivery_charge }}
                                                        <br>
                                                        Tax: {{ $order->tax }}
                                                        <br>
                                                        Discount: -{{ $order->discount }}
                                                        <hr>
                                                        Total: {{ $order->total }}
                                                    </td>
                                                    <td>{{ $order->created_at->format('d/m/Y h:s A') }}</td>
                                                    <td>
                                                        Customer Note: {{ $order->customer_note }}
                                                        <hr>
                                                        Vendor Note: {{ $order->vendor_note }}
                                                    </td>
                                                    <td>
                                                            <span style="width: 200px">
                                                                {{ $order->delivery_location }}
                                                            </span>
                                                    </td>
                                                    <td>
                                                        {{ $order->payment_method }}
                                                    </td>
                                                    <td>
                                                            <span class="label label-info">
                                                                {{ config('constants.order.status')[$order->status] }}
                                                            </span>
                                                    </td>
                                                    <td>
                                                        @if(session('role') == 'agent' && $order->agent_id == null)
                                                            <form action="{{ url('orders/'. $order->id) }}" method="post">
                                                                {{ method_field('put') }}
                                                                {{ csrf_field() }}
                                                                {{--@if($order->status == 2)--}}
                                                                {{--<input type="hidden" name="status" value="{{ $order->status + 1 }}">--}}
                                                                {{--@endif--}}
                                                                <input type="hidden" name="agent_id" value="{{ \Illuminate\Support\Facades\Auth::user()->account_id }}">
                                                                <a type="button"
                                                                   class="btn btn-sm btn-info btn-icon btn-pure btn-outline order-action"
                                                                   data-toggle="tooltip" data-original-title="Confirm" data-action="Accept">
                                                                    <i class="ti-check" aria-hidden="true"></i>
                                                                    Accept
                                                                </a>
                                                            </form>
                                                        @else
                                                            @if($order->status < 5 &&  $order->status > 0)
                                                                <form action="{{ url('orders/'. $order->id) }}" method="post">
                                                                    {{ method_field('put') }}
                                                                    {{ csrf_field() }}
                                                                    <input type="hidden" name="status" value="{{ $order->status + 1 }}">
                                                                    <input type="hidden" name="vendor_note" value="">
                                                                    <a type="button"
                                                                       class="btn btn-sm btn-info btn-icon btn-pure btn-outline order-action"
                                                                       data-toggle="tooltip" data-original-title="Confirm" data-action="{{ config('constants.order.action')[$order->status+1] }}">
                                                                        <i class="ti-check" aria-hidden="true"></i>
                                                                        {{ config('constants.order.action')[$order->status+1] }}
                                                                    </a>
                                                                    <br>
                                                                </form>
                                                            @endif

                                                            @if($order->status == 1)
                                                                <form action="{{ url('orders/'. $order->id) }}"
                                                                      method="post">
                                                                    {{ method_field('put') }}
                                                                    {{ csrf_field() }}
                                                                    <input type="hidden" name="status" value="-1">
                                                                    <input type="hidden" name="vendor_note" value="">
                                                                    <a type="button"
                                                                       class="btn btn-sm btn-danger btn-icon btn-pure btn-outline order-action"
                                                                       data-toggle="tooltip" data-original-title="Cancel" data-action="Cancel">
                                                                        <i class="ti-close" aria-hidden="true"></i>
                                                                        Cancel
                                                                    </a>
                                                                </form>
                                                            @endif

                                                            @if($order->status == 4)
                                                                <form action="{{ url('orders/'. $order->id) }}"
                                                                      method="post">
                                                                    {{ method_field('put') }}
                                                                    {{ csrf_field() }}
                                                                    <input type="hidden" name="status" value="0">
                                                                    <input type="hidden" name="vendor_note" value="">
                                                                    <a type="button"
                                                                       class="btn btn-sm btn-danger btn-icon btn-pure btn-outline order-action"
                                                                       data-toggle="tooltip" data-original-title="Cancel" data-action="{{ config('constants.order.action')[0] }}">
                                                                        <i class="ti-close" aria-hidden="true"></i>
                                                                        {{ config('constants.order.action')[0] }}
                                                                    </a>
                                                                </form>
                                                            @endif
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- .left-aside-column-->
                    </div>
                    <!-- /.left-right-aside-column-->
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>

    <script>
        window.onload = function () {
            var interval = 0;
//            setInterval(function () {
//                showToast("Update","Page will refresh after 10 seconds", "info");
//                setTimeout(function () {
//                    location.reload();
//                }, 10000);
//            }, 180000);

            var table = initDataTable('#orders-table');

            $(document).on('click', '.order-action', function (event) {
                var that = this;
                swal.queue([{
                    title: 'Process Order',
                    text: "We'll notify the customer for you",
                    input: 'textarea',
                    inputPlaceholder: 'Note for customer',
                    confirmButtonText: $(that).data('action') + ' Order',
                    confirmButtonColor: '#f55753',
                    showCancelButton: true,
                    showLoaderOnConfirm: true,
                    preConfirm: function (inputValue) {
                        console.log(inputValue);
                        return new Promise(function (resolve) {
                            $(that).parent('form').find('input[name="vendor_note"]').val(inputValue);
                            $(that).parent('form').submit();
                        })
                    }
                }]);
            });
        };

        function mapsSelector(lat, lng) {
            if /* if we're on iOS, open in Apple Maps */
            ((navigator.platform.indexOf("iPhone") != -1) ||
                (navigator.platform.indexOf("iPad") != -1) ||
                (navigator.platform.indexOf("iPod") != -1))
                window.open("maps://maps.google.com/maps?daddr=" + lat + "," + lng + "&amp;ll=");
            else /* else use Google */
                window.open("https://maps.google.com/maps?daddr=" + lat + "," + lng + "&amp;ll=");
        }
    </script>

@endsection