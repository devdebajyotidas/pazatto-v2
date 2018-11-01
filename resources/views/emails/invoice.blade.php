<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    @include('includes.css')
</head>
<body class="content-wrapper no-sidebar">
<div id="wrapper">

    <div id="page-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3><b>INVOICE</b> <span class="pull-right">#5669626</span></h3>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-left">
                                <address>
                                    <h3>From,</h3>
                                    <h3>
                                        <b class="text-danger">Pazatto Delicious Pvt. Ltd.</b>
                                    </h3>
                                    <p class="text-muted m-l-5">
                                        200 Kirloskar, Hesserghatta
                                        <br>
                                        Bangalore - 364002
                                    </p>
                                    <p class="text-muted m-l-5">
                                        GSTIN: 29AAJCP5921B1ZG
                                    </p>
                                </address>
                            </div>
                            <div class="pull-right text-right">
                                <address>
                                    <h3>To,</h3>
                                    <h4 class="font-bold">
                                        @if($for == 'VENDOR')
                                            {{ $order->vendor->name }}
                                        @else
                                            {{ $order->customer->first_name }}
                                            {{ $order->customer->last_name }}
                                        @endif
                                    </h4>
                                    <p class="text-muted m-l-30" style="max-width: 300px">
                                        @if($for == 'VENDOR')
                                            {{ $order->vendor->locations()->first()->formatted_address }}
                                        @else
                                            {{ $order->delivery_location }}
                                        @endif
                                    </p>
                                    <p class="m-t-30"><b>Invoice Date :</b> <i class="fa fa-calendar"></i> {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
                                    {{--<p><b>Due Date :</b> <i class="fa fa-calendar"></i> 25th Jan 2016</p>--}}
                                </address>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive m-t-40">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Item</th>
                                        <th class="text-right">Quantity</th>
                                        <th class="text-right">Unit Cost</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($order->lines as $key => $line)
                                        <tr>
                                            <td class="text-center">{{ $key }}</td>
                                            <td>{{ $line->item_name }}</td>
                                            <td class="text-right">{{ $line->quantity }} </td>
                                            @if($for == 'CUSTOMER')
                                                <td class="text-right"> {{ $line->item_price }} </td>
                                                <td class="text-right"> {{ $line->quantity * $line->item_price }} </td>
                                            @else
                                                <td class="text-right"> {{ floor($line->item_price - ($order->vendor->customer_commission/100) * $line->item_price)  }} </td>
                                                <td class="text-right"> {{ $line->quantity * floor($line->item_price - ($order->vendor->customer_commission/100) * $line->item_price) }} </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="pull-right m-t-30 text-right">
                                @if($for == 'VENDOR')
                                <p>Sub-total: {{ floor($order->sub_total - ($order->vendor->customer_commission/100) * $order->sub_total) }}</p>
                                @else
                                <p>Sub-total: {{ $order->sub_total }}</p>
                                @endif
                                <p>Packing Charge: {{ $order->packing_charge }}</p>
                                <p>Delivery Charge: {{ $order->delivery_charge }}</p>
                                <p>Tax ({{ $order->vendor->tax }}%): {{ $order->tax }}</p>

                                @if($for == 'VENDOR')
                                    <p>Pazatto Commission ({{ $order->vendor->pazatto_commission }}%) : - {{ floor( ($order->vendor->pazatto_commission/100) * floor($order->total - ($order->vendor->customer_commission/100) * $order->total))  }} </p>
                                    <hr>
                                    <h3><b>Total :</b> {{ $order->total - floor( (($order->vendor->customer_commission + $order->vendor->pazatto_commission)/100) * $order->total) }}</h3>
                                @else
                                    <hr>
                                    <h3><b>Total :</b> {{ $order->total }}</h3>
                                @endif

                            </div>
                            <div class="clearfix"></div>
                            {{--<hr>--}}
                            {{--<div class="text-right">--}}
                                {{--<button class="btn btn-danger" type="submit"> Proceed to payment </button>--}}
                                {{--<button onclick="javascript:window.print();" class="btn btn-default btn-outline" type="button"> <span><i class="fa fa-print"></i> Print</span> </button>--}}
                            {{--</div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
