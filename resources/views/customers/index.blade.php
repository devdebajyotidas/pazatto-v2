@extends('layouts.app')
@section('content')

    <div class="container-fluid">
        <!-- row -->
        <div class="row m-t-20">
            <div class="col-md-12">
                <div class="white-box">
                    <div class="clearfix"></div>
                    <div class="scrollable">
                        <div class="table-responsive">
                            <table id="customers-table" class="table m-t-30 table-hover contact-list"
                                   data-page-size="10" data-filter="#search-learner">
                                <thead>
                                <tr>
                                    <th data-priority="1">ID</th>
                                    <th data-priority="5">Name</th>
                                    <th data-priority="6">Email</th>
                                    <th data-priority="2">Mobile</th>
                                    <th data-priority="3">Joined On</th>
                                    <th data-priority="8">Total Orders</th>
                                    <th data-priority="11">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($customers))
                                    @foreach($customers as $key => $customer)
                                        <tr>
                                            <td>{{ $customer->id }}</td>
                                            <td>
                                                {{--<a href="{{ url( '/vendors/'. $customer->id) }}">--}}
                                                {{--<img src="{{ $customer->featured_image }}" alt="user" class="img-circle"/>--}}
                                                {{ $customer->first_name }}
                                                {{ $customer->last_name }}
                                                <br>
                                                {{--</a>--}}
                                            </td>
                                            <td>
                                                {{ isset($customer->user) ? $customer->user->email : "N/A" }}
                                            </td>
                                            <td>
                                                {{ isset($customer->user) ? $customer->user->mobile : "N/A" }}
                                            </td>
                                            <td>{{ $customer->created_at->format('m/d/Y h:s') }}</td>
                                            <td>
                                                {{ $customer->orders()->count() }}
                                            </td>
                                            <td>
                                                {{--<form action="{{ url('orders/'. $customer->id) }}" method="post">--}}
                                                {{--{{ method_field('put') }}--}}
                                                {{--{{ csrf_field() }}--}}
                                                {{--<input type="hidden" name="vendor_note" value="">--}}
                                                {{--<a type="button"--}}
                                                {{--class="btn btn-sm btn-info btn-icon btn-pure btn-outline order-action"--}}
                                                {{--data-toggle="tooltip" data-original-title="Confirm" data-action="{{ config('constants.order_action')[$customer->status+1] }}">--}}
                                                {{--<i class="ti-check" aria-hidden="true"></i>--}}
                                                {{--{{ config('constants.order_action')[$customer->status+1] }}--}}
                                                {{--</a>--}}
                                                {{--</form>--}}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>

    <div id="send-notification" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">Send Notification</h4>
                </div>
                <form class="form-horizontal" action="{{ url('notifications/customers') }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-md-12">Title</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="title" placeholder="Title"
                                       value="{{ old('title') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Content</label>
                            <div class="col-md-12">
                                <textarea type="text" class="form-control" name="content" placeholder="Content">
                                    {{ old('content') }}
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Image (Optional)</label>
                            <input type="file" class="form-control" name="image">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info waves-effect">Save</button>
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <script>
        window.onload = function () {
            var buttons = [
                {
                    text: 'Send Notification',
//                        className : 'btn btn-info',
                    action: function (e, dt, node, config) {
                        $('#send-notification').modal('show');
                    }
                }
            ];
            var table = initDataTable('#customers-table', buttons, '{{ url('api/v1/customers') }}');

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
        }
    </script>

@endsection