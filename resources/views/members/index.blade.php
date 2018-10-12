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
                            <table id="delivery-persons-table" class="table m-t-30 table-hover contact-list"
                                   data-page-size="10" data-filter="#search-learner">
                                <thead>
                                <tr>
                                    <th data-priority="1">ID</th>
                                    <th data-priority="5">Name</th>
                                    <th data-priority="6">Email</th>
                                    <th data-priority="2">Mobile</th>
                                    <th data-priority="3">Joined On</th>
                                    {{--<th data-priority="8">Orders</th>--}}
                                    <th data-priority="11">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($deliveryPersons))
                                    @foreach($deliveryPersons as $key => $deliveryPerson)
                                        <tr>
                                            <td>{{ $deliveryPerson->id }}</td>
                                            <td>
                                                {{--<a href="{{ url( '/vendors/'. $deliveryPerson->id) }}">--}}
                                                {{--<img src="{{ $deliveryPerson->featured_image }}" alt="user" class="img-circle"/>--}}
                                                {{ $deliveryPerson->first_name }}
                                                {{ $deliveryPerson->last_name }}
                                                <br>
                                                {{--</a>--}}
                                            </td>
                                            <td>
                                                {{ $deliveryPerson->user->email }}
                                            </td>
                                            <td>
                                                {{ $deliveryPerson->user->mobile }}
                                            </td>
                                            <td>{{ $deliveryPerson->created_at->format('m/d/Y h:s') }}</td>
                                            <td>
                                                <a href="#edit-agent-{{ $deliveryPerson->id }}" data-toggle="modal" class="btn btn-info">
                                                    Edit
                                                </a>
                                                <div id="edit-agent-{{ $deliveryPerson->id }}" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                                     aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                <h4 class="modal-title" id="myModalLabel">Edit  Agent</h4>
                                                            </div>
                                                            <form class="form-horizontal" action="{{ url('agents/' . $deliveryPerson->id) }}" method="post">
                                                                {{ csrf_field() }}
                                                                {{ method_field('put') }}

                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <div class="row">
                                                                            <label class="col-md-12">Vendor(s)</label>
                                                                            <select name="vendors[]" class="form-control col-md-12" multiple>
                                                                                @foreach($vendors as $vendor)
                                                                                    <option value="{{ $vendor->id }}" @if(in_array($vendor->id, $deliveryPerson->vendors()->pluck('vendor_id')->toArray())) {{ "selected" }} @endif>
                                                                                        {{ $vendor->name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-md-12">First Name</label>
                                                                        <div class="col-md-12">
                                                                            <input type="text" class="form-control" name="agent[first_name]" placeholder="First Name"
                                                                                   value="{{ old('agent.first_name', $deliveryPerson->first_name) }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-md-12">Last Name</label>
                                                                        <div class="col-md-12">
                                                                            <input type="text" class="form-control" name="agent[last_name]" placeholder="Last Name"
                                                                                   value="{{ old('agent.last_name', $deliveryPerson->last_name) }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-md-12">Email</label>
                                                                        <div class="col-md-12">
                                                                            <input type="email" class="form-control" name="user[email]" placeholder="Email"
                                                                                   value="{{ old('user.email', $deliveryPerson->user->email) }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-md-12">Mobile</label>
                                                                        <div class="col-md-12">
                                                                            <input type="text" class="form-control" name="user[mobile]" placeholder="Mobile"
                                                                                   value="{{ old('user.mobile', $deliveryPerson->user->mobile) }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-md-12">Password</label>
                                                                        <div class="col-md-12">
                                                                            <input type="password" class="form-control" name="user[password]" placeholder="Password">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-md-12">Confirm Password</label>
                                                                        <div class="col-md-12">
                                                                            <input type="password" class="form-control" name="user[password_confirmation]" placeholder="Confirm Password">
                                                                        </div>
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

                                                <form action="{{ '/agents/' . $deliveryPerson->id }}" method="post">
                                                    {{ csrf_field() }}
                                                    {{ method_field('delete') }}
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure ?') ">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                            {{--<td>--}}
                                                {{--{{ $deliveryPerson->orders()->count() }}--}}
                                            {{--</td>--}}
                                            {{--<td>--}}
                                                {{--<form action="{{ url('orders/'. $deliveryPerson->id) }}" method="post">--}}
                                                {{--{{ method_field('put') }}--}}
                                                {{--{{ csrf_field() }}--}}
                                                {{--<input type="hidden" name="vendor_note" value="">--}}
                                                {{--<a type="button"--}}
                                                {{--class="btn btn-sm btn-info btn-icon btn-pure btn-outline order-action"--}}
                                                {{--data-toggle="tooltip" data-original-title="Confirm" data-action="{{ config('constants.order_action')[$deliveryPerson->status+1] }}">--}}
                                                {{--<i class="ti-check" aria-hidden="true"></i>--}}
                                                {{--{{ config('constants.order_action')[$deliveryPerson->status+1] }}--}}
                                                {{--</a>--}}
                                                {{--</form>--}}
                                            {{--</td>--}}
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

    <div id="add-delivery-person" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">Add Delivery Agent</h4>
                </div>
                <form class="form-horizontal" action="{{ url('agents') }}" method="post">
                    {{ csrf_field() }}

                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-md-12">Vendor(s)</label>
                            <select name="vendors[]" class="form-control" multiple>
                                @foreach($vendors as $vendor)
                                    <option value="{{ $vendor->id }}">
                                        {{ $vendor->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">First Name</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="agent[first_name]" placeholder="First Name"
                                       value="{{ old('agent.first_name') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Last Name</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="agent[last_name]" placeholder="Last Name"
                                       value="{{ old('agent.last_name') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Email</label>
                            <div class="col-md-12">
                                <input type="email" class="form-control" name="user[email]" placeholder="Email"
                                       value="{{ old('user.email') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Mobile</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="user[mobile]" placeholder="Mobile"
                                       value="{{ old('user.mobile') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Password</label>
                            <div class="col-md-12">
                                <input type="password" class="form-control" name="user[password]" placeholder="Password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Confirm Password</label>
                            <div class="col-md-12">
                                <input type="password" class="form-control" name="user[password_confirmation]" placeholder="Confirm Password">
                            </div>
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

    <div id="send-notification" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">Send Notification</h4>
                </div>
                <form class="form-horizontal" action="{{ url('notifications/agents') }}" method="post" enctype="multipart/form-data">
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
                },
                {
                    text: 'Add New Delivery Agent',
//                        className : 'btn btn-info',
                    action: function (e, dt, node, config) {
                        $('#add-delivery-person').modal('show');
                    }
                }
            ];
            var table = initDataTable('#delivery-persons-table', buttons, '{{ url('api/v1/customers') }}');

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