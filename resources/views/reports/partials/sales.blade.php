<div class="row">

    <div class="col-md-12">
        <div id="sales-report" class="white-box">
            {{--<div class="row">--}}
                {{--<div class="col-md-12">--}}
                    {{--<div class="text-center">--}}
                        {{--<button id="print" class="btn btn-info" onclick="window.print()">Print Report</button>--}}
                        {{--<button id="email" class="btn btn-primary" onclick="">Email Report</button>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}

            <h3><b>SALES REPORT</b>
                <button id="print" class="btn btn-info" onclick="window.print()"><i class="fa fa-print"></i></button>
                {{--<button id="email" class="btn btn-primary" onclick=""><i class="fa fa-envelope"></i></button>--}}
                <span class="pull-right">{{ date('d/m/Y', strtotime($date)) }}</span>
            </h3>
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
                        </address>
                    </div>
                    <div class="pull-right text-right">
                        <address>
                            <h3>To,</h3>
                            <h4 class="font-bold">
                                {{ $vendor->name }}
                            </h4>
                            <p class="text-muted m-l-30" style="max-width: 300px">
                                {{ $vendor->locations()->first()->formatted_address }}
                            </p>
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
                                <th class="text-center">Sub Total</th>
                                <th class="text-center">Packaging Charge</th>
                                {{--@if($for != 'VENDOR')--}}
                                    <th class="text-center">Delivery Charge</th>
                                    <th class="text-center">Discount</th>
                                {{--@endif--}}
                                <th class="text-center">Tax</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Payment Method</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $subTotal = 0;
                                $packingCharge = 0;
                                $deliveryCharge = 0;
                                $tax = 0;
                                $discount = 0;
                                $total = 0;

                                $cashPayment = 0;
                                $onlinePayment = 0;
                                $paymentGatewayFees = 0;

                                $customerCommission = 0;
                                $vendorCommission = 0;

                                $amountToCredit = 0;
                                $amountToCollect = 0;
                            @endphp

                            @foreach($orders as $key => $order)
                                @php
                                    if($for == 'VENDOR')
                                        $subTotal += floor($order->sub_total - ($vendor->customer_commission/100) * $order->sub_total);
                                    else
                                        $subTotal += $order->sub_total;

                                        $packingCharge += $order->packing_charge;;
                                        $deliveryCharge += $order->delivery_charge;;
                                        $tax += $order->tax;;
                                       $discount += $order->discount;
                                        $total += $order->total;

                                        if($order->payment_method == "COD")
                                            $cashPayment += $order->total;
                                        else
                                            $onlinePayment += $order->total;
                                @endphp
                                <tr>
                                    <td class="text-center">{{ $order->id }}</td>
                                    @if($for == 'VENDOR')
                                    <td class="text-center">{{ floor($order->sub_total - ($vendor->customer_commission/100) * $order->sub_total) }}</td>
                                    @else
                                    <td class="text-center">{{ $order->sub_total }}</td>
                                    @endif
                                    <td class="text-center">{{ $order->packing_charge }}</td>
                                    {{--@if($for != 'VENDOR')--}}
                                    <td class="text-center">{{ $order->delivery_charge }}</td>
                                    <td class="text-center">-{{ $order->discount }}</td>
                                    {{--@endif--}}
                                    <td class="text-center">{{ $order->tax }}</td>
                                    <td class="text-center">{{ $order->total }}</td>
                                    <td class="text-center">{{ $order->payment_method }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="pull-right m-t-30 text-right">

                        <p>Sub-total: {{ $subTotal }}</p>
                        <p>Packing Charge: {{ $packingCharge }}</p>
                        <p>Tax ({{ $vendor->tax }}%): {{ $tax }}</p>
                        {{--@if($for != 'VENDOR')--}}
                        <p>Delivery Charge: {{ $deliveryCharge }}</p>
                        <p>Discount: -{{ $discount }}</p>
                        {{--@endif--}}
                        <hr>
                        <p>Total: {{ $total }}</p>
                        <hr>
                        <p><small>Online Payment:</small> {{ $onlinePayment }}</p>
                        <p><small>Cash Payment: </small>{{ $cashPayment }}</p>
                        <hr>
                        @if($for != 'VENDOR')
                            <p>Customer Commission ({{ $vendor->customer_commission }}%) :  {{ $customerCommission = ceil(($vendor->customer_commission/100) * $subTotal)  }} </p>
                        @endif
                            <p>Vendor Commission ({{ $vendor->pazatto_commission }}%) : {{ $vendorCommission = ceil(  ($vendor->pazatto_commission/100) * (($subTotal + $packingCharge)))  }} </p>
                            <p>Payment Gateway fees(2%): {{ $paymentGatewayFees = ceil((2/100) * $onlinePayment) }}</p>
                            <hr>
                            {{--<h3><b>Total :</b> {{ $total - ceil( (($vendor->customer_commission + $vendor->pazatto_commission)/100) * $total) }}</h3>--}}
                            <h3>
                                <b>Amount to be credited: </b>
                                {{ $amountToCredit = ($subTotal + $packingCharge) - $vendorCommission - $customerCommission - $paymentGatewayFees }}
                            </h3>
                        @if($for != 'VENDOR')
                        <h3>
                            <b>Amount to be collected: </b>
                            {{--{{ $amountToCollect = $total - ($amountToCredit - $vendorCommission) }}--}}
                            {{ $amountToCollect = $total - $amountToCredit  }}
                        </h3>
                        @endif
                        {{--@else--}}
                            {{--<hr>--}}
                            {{--<h3><b>Total :</b> {{ $order->total }}</h3>--}}
                        {{--@endif--}}

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

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #sales-report, #sales-report * {
            visibility: visible;
        }

        #sales-report #email, #sales-report #print  {
            visibility: hidden;
        }

        #sales-report {
            position: fixed;
            left: 0;
            top: 0;
        }
    }
</style>