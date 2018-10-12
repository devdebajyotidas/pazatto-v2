@extends('layouts.app')
@section('content')

    <div class="container-fluid">
        <!-- row -->
        <div class="row m-t-20">
            <div class="col-md-12">
                <div class="white-box p-0">
                    <div class="page-aside">
                        <div class="left-aside">

                        </div>
                        <div class="right-aside">
                            <div class="right-page-header">
                            </div>
                            <div class="clearfix"></div>
                            <div class="scrollable">
                                <div class="table-responsive">
                                    <table id="service-categories-table"
                                           class="display responsive nowrap table m-t-30 table-hover"
                                           data-page-size="10" data-filter="#search-learner">
                                        <thead>
                                        <tr>
                                            <th data-visible="true" data-priority="1">Service</th>
                                            <th data-visible="true" data-priority="2">Category</th>
                                            <th data-visible="true" data-priority="3">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($categories as $category)
                                            <tr>
                                                <td>
                                                    {{ $category->service->name }}
                                                </td>
                                                <td>
                                                    {{ $category->name }}
                                                </td>
                                                <td>
                                                </td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{--</div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            window.onload = function () {

                var buttons = [
                    {
                        text: 'Add New Category',
//                    className : 'btn btn-info',
                        action: function (e, dt, node, config) {
                            $("#add-category").modal('show');
                        }
                    }
                ];
                var table = initDataTable('#service-categories-table', buttons);
            }
        </script>

@endsection