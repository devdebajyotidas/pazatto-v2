@extends('layouts.app')
@section('content')

    <div class="container-fluid">
        <!-- row -->
        <div class="row m-t-20">
            <div class="col-md-12">
                <div class="white-box" style="padding: 0px;">

                    <ul class="nav nav-tabs" role="tablist" style="@if($role == 'agent') {{ 'display:none' }} @endif">
                        <li role="presentation" class="active"><a href="#sales" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs"> Sales</span></a></li>
                        <li role="presentation" class=""><a href="#deliveries" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs">Deliveries</span></a></li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane @if($role != 'agent') {{ 'active' }} @endif " id="sales">
                            <!-- .left-right-aside-column-->
                            <div class="page-aside">
                                <!-- .left-aside-column-->
                                {{--<div class="left-aside">--}}
                                    {{--<div class="scrollable">--}}
                                        {{--<ul id="vendor-list" class="list-style-none">--}}
                                            {{--<li class="box-label">--}}
                                                {{--<a href="javascript:void(0)" class="service" data-id="" data-name="">--}}
                                                    {{--All Vendors--}}
                                                    {{--<span> {{ count($vendors) }} </span>--}}
                                                {{--</a>--}}
                                            {{--</li>--}}
                                            {{--<li class="divider"></li>--}}
                                            {{--@foreach($vendors as $vendor)--}}
                                                {{--<li>--}}
                                                    {{--<a href="javascript:void(0)" class="vendor" data-id="{{ $vendor->id }}" data-name="{{ $vendor->name }}">--}}
                                                        {{--{{ $vendor->name }}--}}
                                                    {{--</a>--}}
                                                {{--</li>--}}
                                            {{--@endforeach--}}

                                        {{--</ul>--}}
                                        {{--<ul class="list-style-none">--}}
                                        {{--<li class="divider"></li>--}}
                                        {{--<li class="box-label">--}}
                                        {{--<a href="javascript:void(0)" data-toggle="modal" data-target="#service-editor">--}}
                                        {{--+ Add New Service--}}
                                        {{--</a>--}}
                                        {{--</li>--}}
                                        {{--</ul>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                <!-- /.left-aside-column-->
                                <div class="right-aside" style="margin-left: 0px;padding: 0px;">
                                    <div class="right-page-header">
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="scrollable">
                                        <div class="table-responsive">
                                            <table id="reports-table" class="display responsive nowrap table m-t-30 table-hover"
                                                   data-page-size="10" data-filter="#search-learner">
                                                <thead>
                                                <tr>
                                                    <th>Vendor</th>
                                                    <th>Date</th>
                                                    <th>Orders</th>
                                                    <th>Sales</th>
                                                    <th>Details</th>
                                                </tr>
                                                </thead>
                                                <tfoot style="display: table-header-group">
                                                <tr>
                                                    <th data-visible="true" data-priority="4">Vendor</th>
                                                    <th data-priority="2" data-order="desc">Date</th>
                                                    <th data-priority="1">Orders</th>
                                                    <th data-priority="5">Sales</th>
                                                    <th data-priority="6">Details</th>
                                                </tr>
                                                </tfoot>
                                                <tbody>

                                                @foreach($sales as $sale)
                                                    <tr>
                                                        <td>{{ $sale->vendor_name }}</td>
                                                        <td>{{ date('d/m/Y', strtotime($sale->date)) }}</td>
                                                        <td>{{ $sale->total_orders }}</td>
                                                        <td>{{ $sale->total_sales }}</td>
                                                        <td>
                                                            <a href="/reports/details?mode=sales&date={{ date('Y-m-d', strtotime($sale->date)) }}&vendor={{ $sale->vendor_id }}" class="btn btn-info">
                                                            {{--<a href="/reports/details?mode=sales&date={{ date('Y-m-d', strtotime($sale->date)) }}&vendor={{ ($role != "vendor") ? $sale->vendor_id : ''  }}" class="btn btn-info">--}}
                                                            {{--<a href="/reports/details?mode=sales&date={{ $sale->date }}&vendor={{ ($role != "vendor") ? $sale->vendor_id : ''  }}" class="btn btn-info">--}}
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                            {{--<table class="display responsive nowrap table">--}}
                                                                {{--<thead>--}}
                                                                    {{--<tr>--}}
                                                                        {{--<th>Item Name</th>--}}
                                                                        {{--<th>Unit Sold</th>--}}
                                                                        {{--<th>Sales</th>--}}
                                                                    {{--</tr>--}}
                                                                {{--</thead>--}}
                                                                {{--<tbody>--}}
                                                                {{--@foreach($sale->details as $detail)--}}
                                                                    {{--<tr>--}}
                                                                        {{--<td>{{ $detail->item_name }}</td>--}}
                                                                        {{--<td>{{ $detail->items_sold }}</td>--}}
                                                                        {{--<td>{{ $detail->sales }}</td>--}}
                                                                    {{--</tr>--}}
                                                                {{--@endforeach--}}
                                                                {{--</tbody>--}}
                                                            {{--</table>--}}
                                                        </td>
                                                    </tr>
                                                @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- .left-aside-column-->
                            </div>
                            <!-- /.left-right-aside-column-->
                        </div>
                        <div role="tabpanel" class="tab-pane @if($role == 'agent') {{ 'active' }} @endif " id="deliveries">


                            <div class="page-aside">

                                <div class="right-aside" style="margin-left: 0px;padding: 0px;">
                                    <div class="right-page-header">
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="scrollable">
                                        <div class="table-responsive">
                                            <table id="deliveries-table" class="display responsive nowrap table m-t-30 table-hover"
                                                   data-page-size="10" data-filter="#search-learner">
                                                <thead>
                                                <tr>
                                                    @if($role != 'agent')
                                                    <th>Agent</th>
                                                    @endif
                                                    <th>Date</th>
                                                    <th>Orders <br> Delivered</th>
                                                    <th>Cash <br> Collected</th>
                                                    <th data-priority="5"> Paid on <br> Paytm</th>
                                                    <th data-priority="5">Discounts</th>
                                                    {{--<th>Details</th>--}}
                                                </tr>
                                                </thead>
                                                {{--<tfoot style="display: table-header-group">--}}
                                                <tfoot style="display: none">
                                                <tr>
                                                    @if($role != 'agent')
                                                    <th data-visible="true" data-priority="4">Agent</th>
                                                    @endif
                                                    <th data-priority="2" data-order="desc">Date</th>
                                                    <th data-priority="1">Orders <br> Delivered</th>
                                                    <th data-priority="5">Cash <br> Collected</th>
                                                    <th data-priority="5"> Paid on <br> Paytm</th>
                                                    <th data-priority="5">Discount</th>
                                                    {{--<th data-priority="6">Details</th>--}}
                                                </tr>
                                                </tfoot>
                                                <tbody>

                                                @foreach($deliveries as $delivery)
                                                    <tr>
                                                        @if($role != 'agent')
                                                        <td>{{ $delivery->first_name . ' ' . $delivery->last_name }}</td>
                                                        @endif
                                                        <td>{{ date('d/m/Y', strtotime($delivery->date)) }}</td>
                                                        <td>{{ $delivery->total_orders }}</td>
                                                        <td>{{ $delivery->cash_collected }}</td>
                                                        <td>{{ $delivery->paid_paytm }}</td>
                                                        <td>{{ $delivery->discounts }}</td>
                                                        {{--<td>--}}
                                                            {{--<a href="/reports/details?mode=deliveries&date={{ date('Y-m-d', strtotime($delivery->date)) }}&agent={{ ($role != "agent") ? $delivery->agent_id : ''  }}" class="btn btn-info">--}}
                                                                {{--<a href="/reports/details?mode=sales&date={{ $sale->date }}&vendor={{ ($role != "vendor") ? $sale->vendor_id : ''  }}" class="btn btn-info">--}}
                                                                {{--<i class="fa fa-eye"></i>--}}
                                                            {{--</a>--}}
                                                        {{--</td>--}}
                                                @endforeach



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
            </div>
        </div>
        <!-- /.row -->
    </div>

    <script>
        window.onload = function(){
            var dateRange;
            var table = initDataTable('#reports-table');
            var dTable = initDataTable('#deliveries-table');
            if(table){
//                console.log(table.columns().footer());

                table.columns().every(function (index, element) {
//                    console.log(this.footer());
                    var title =  $(this.footer()).text();
                    console.log(title);

                    if (title.trim() == 'Date') {
                        $(this.footer()).html('<div id="date-range" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">' +
                            '<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;' +
                            '<span></span> <b class="caret"></b>' +
                            '</div>');

                        dateRange = $('#date-range').daterangepicker({
                            startDate: moment().subtract(29, 'days'),
                            endDate: moment(),
                            opens: "right",
                            locale: {
                                format: 'MM/DD/YYYY '
                            },
                            ranges: {
                                'Today': [moment(), moment()],
                                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                                'This Month': [moment().startOf('month'), moment().endOf('month')],
                                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                            }
                        }, function () {
                            $('#date-range span').html(dateRange.data('daterangepicker').chosenLabel);
                            table.draw();
                        });
                    } else if(title.trim() == 'Vendor') {
                        $(this.footer()).html('<input type="text" placeholder="Search ' + title + '" />');
                    }else{
                        $(this.footer()).html('');
                    }
                });

                table.columns().every(function (index, value) {
                    var that = this;
                    $('input', this.footer()).on('keyup change input', function () {
                        if (that.search() !== this.value) {
//                            console.log(that.search());
                            that.search(this.value).draw();
                        }
                    });
                });

                $.fn.dataTableExt.afnFiltering.push(
                    function (oSettings, aData, iDataIndex) {
                        console.log(aData, iDataIndex);

                        if(typeof dateRange.data('daterangepicker') !== 'undefined'){
                            console.log('if date');

                            var startDate = moment(dateRange.data('daterangepicker').startDate.format('MM/DD/YYYY'));
                            var endDate = moment(dateRange.data('daterangepicker').endDate.format('MM/DD/YYYY'));
                            var dateToSearch = moment(reformatDateSring(aData[1]));

                            console.log(startDate);
                            console.log(endDate);
                            console.log(dateToSearch);

//                            var from = new Date(reformatDateSring(startDate));
//                            var to = new Date(reformatDateSring(endDate));
                            // colToSearch = colToSearch.match(/\d{2}([\/.-])\d{2}\1\d{4}/g);
//                            console.log(colToSearch);
//                            colToSearch = colToSearch.match(/\d{2}\/\d{2}\/\d{4}/g);
//                            colToSearch = new Date(reformatDateSring(colToSearch));

//                            if (isNaN(from) || isNaN(to)) {
//                                console.log('invalid date');
//                                return false;
//                            }
//
//                            if (from.getTime() > colToSearch.getTime()) {
//                                return false;
//                            }
//                            if (to.getTime() < colToSearch.getTime()) {
//                                return false;
//                            }

                            if(dateToSearch.isBetween(startDate, endDate)){
                                console.log('in range');
                                return true;
                            }
                            console.log('out range');
                            return false;

                        }else{
                            console.log('else date');
                        }
                    }
                );
            }
        }

        function reformatDateSring(date) {
            var dateComponents = date.split("/");
            date = dateComponents[1] + "/" + dateComponents[0] + "/" + dateComponents[2];
            return date;
        }
    </script>
@endsection