@extends('layouts.app')
@section('content')

<div class="container-fluid">
    <!-- row -->
    <div class="row m-t-20">
        <div class="col-md-12">
            <div class="white-box">
                <div class="page-aside">
                    <div class="left-aside"></div>
                    <div class="right-aside">
                        <div class="right-page-header">
                        </div>
                        <div class="clearfix"></div>
                        <div class="scrollable">
                            <div class="table-responsive">
                                <table id="discounts-table" class="display responsive nowrap table m-t-30 table-hover"
                                       data-page-size="10" data-filter="#search-learner">
                                    <thead>
                                    <tr>
                                        <th data-visible="true" data-priority="4">Service</th>
                                        <th data-visible="true" data-priority="4">Type</th>
                                        <th data-visible="true" data-priority="4">Code</th>
                                        <th data-priority="1">Vendor</th>
                                        <th data-priority="5">Price</th>
                                        <th data-priority="6">Packing <br> Charge</th>
                                        <th data-priority="2">Orders Placed</th>
                                        <th data-priority="3">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($discounts as $discount)
                                        @continue
                                        <tr>
                                            <td>
                                                {{--{{ $discount->service->name }}--}}
                                            </td>
                                            <td>
                                                {{ $discount->type }}
                                            </td>
                                            <td>
                                                {{ $discount->code }}
                                            </td>
                                            <td>

                                            </td>

                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.onload = function(){

        var buttons = [
            {
                text: 'Add New Discount',
//                    className : 'btn btn-info',
                action: function (e, dt, node, config) {
                    window.location.href = '{{ url('/discounts/create') }}';
                }
            }
        ];
        var table = initDataTable('#discounts-table', buttons);
    }
</script>

@endsection