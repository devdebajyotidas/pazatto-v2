@extends('layouts.app')
@section('content')

    <div class="container-fluid">
        <!-- row -->
        <div class="row m-t-20">
            <div class="col-md-12">
                <div class="white-box p-0">
                    <!-- .left-right-aside-column-->

                    <div class="white-box" style="padding: 0px;">

                        <ul class="nav nav-tabs" role="tablist" style="@if($role == 'agent') {{ 'display:none' }} @endif">
                            <li role="presentation" class="active"><a href="#list" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs"> List</span></a></li>
                            <li role="presentation" class=""><a href="#groups" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs">Groups</span></a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane  {{ 'active' }}" id="list">
                                <div class="page-aside">
                                    <!-- .left-aside-column-->
                                    <div class="left-aside">
                                        <div class="scrollable">
                                            <ul id="service-list" class="list-style-none">
                                                <li class="box-label">
                                                    <a href="javascript:void(0)" class="service" data-id="" data-name="">
                                                        All Vendors
                                                        <span> {{ count($vendors) }} </span>
                                                    </a>
                                                </li>
                                                <li class="divider"></li>
                                                @if(isset($services))
                                                    @foreach($services as $service)
                                                        <li>
                                                            <a href="javascript:void(0)" class="service"
                                                               data-id="{{ $service->id }}" data-name="{{ $service->name }}">
                                                                {{ $service->name }}
                                                                {{--<span>{{ $service->learners()->count() }}</span>--}}
                                                                <span class="vendor-count">{{ $service->vendors_count  }}</span>
                                                                {{--<span class="remove"><i class="ti-close" aria-hidden="true"></i></span>--}}
                                                                {{--<span data-id="{{ $service->id }}"--}}
                                                                {{--data-name="{{ $service->name }}" class="edit">--}}
                                                                {{--<i class="ti-pencil" aria-hidden="true"></i>--}}
                                                                {{--</span>--}}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                @endif
                                                <li class="divider"></li>
                                            </ul>
                                            {{--<ul class="list-style-none">--}}
                                            {{--<li class="divider"></li>--}}
                                            {{--<li class="box-label">--}}
                                            {{--<a href="javascript:void(0)" data-toggle="modal" data-target="#service-editor">--}}
                                            {{--+ Add New Service--}}
                                            {{--</a>--}}
                                            {{--</li>--}}
                                            {{--</ul>--}}
                                        </div>
                                    </div>
                                    <!-- /.left-aside-column-->
                                    <div class="right-aside">
                                        <div class="right-page-header">
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="scrollable">
                                            <div class="table-responsive">
                                                <table id="vendors-table" class="table m-t-30 table-hover contact-list"
                                                       data-page-size="10" data-filter="#search-learner">
                                                    <thead>
                                                    <tr>
                                                        <th data-visible="true">Service</th>
                                                        {{--<th>ID</th>--}}
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Mobile</th>
                                                        <th>Taking Orders</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(isset($vendors))
                                                        @foreach($vendors as $key => $vendor)
                                                            <tr class="{{ $vendor->trashed() ? 'bg-danger' : '' }}">
                                                                <td>
                                                            <span class="label label-info">
                                                                {{ $vendor->service->name }}
                                                            </span>
                                                                </td>
                                                                {{--<td>{{ $vendor->id }}</td>--}}
                                                                <td>
                                                                    {{--<a href="{{ url( '/vendors/'. $vendor->id) }}">--}}
                                                                    {{--<img src="{{ $vendor->featured_image }}" alt="user" class="img-circle"/>--}}
                                                                    {{ $vendor->name }}
                                                                    {{--</a>--}}
                                                                </td>
                                                                <td>{{ isset($vendor->user) ? $vendor->user->email : 'N/A' }}</td>
                                                                <td>{{ isset($vendor->user) ? $vendor->user->mobile : 'N/A'}}</td>
                                                                <td>

                                                                    <form method="post" action="{{ url("vendors/" . $vendor->id . '/take-orders' ) }}">
                                                                        {{ csrf_field() }}
                                                                        {{ method_field('put') }}
                                                                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                                            <label class="btn  @if($vendor->is_taking_orders == 1) {{ 'btn-primary active' }} @else {{ 'btn-secondary' }} @endif">
                                                                                <input type="radio" name="vendor[is_taking_orders]" value="1"  autocomplete="off"  @if($vendor->is_taking_orders == 1) {{ 'checked' }} @endif onchange="this.form.submit()"> Yes
                                                                            </label>
                                                                            <label class="btn @if($vendor->is_taking_orders == 0) {{ 'btn-primary active' }} @else {{ 'btn-secondary' }} @endif">
                                                                                <input type="radio" name="vendor[is_taking_orders]" value="0" autocomplete="off" @if($vendor->is_taking_orders == 0) {{ 'checked' }} @endif onchange="this.form.submit()"> No
                                                                            </label>
                                                                        </div>
                                                                    </form>
                                                                    {{--<div class="form-group">--}}
                                                                    {{--<label for=""></label>--}}
                                                                    {{--</div>--}}
                                                                    {{--<input type="checkbox" >--}}
                                                                </td>
                                                                <td>
                                                                    <a href="{{ url( '/vendors/'. $vendor->id) }}"
                                                                       class="btn btn-sm btn-default btn-icon btn-pure btn-outline"
                                                                       data-toggle="tooltip" data-original-title="View">
                                                                        <i class="fa fa-edit" aria-hidden="true"></i>
                                                                        Edit
                                                                    </a>
                                                                    <a href="{{ url( '/vendors/'. $vendor->id . '/items') }}"
                                                                       class="btn btn-sm btn-info btn-icon btn-pure btn-outline"
                                                                       data-toggle="tooltip" data-original-title="View">
                                                                        <i class="fa fa-cutlery" aria-hidden="true"></i>
                                                                        Menu
                                                                    </a>

                                                                    @if($vendor->trashed())
                                                                        <form action="{{ url('vendors/' . $vendor->id . '/restore') }}" method="post">
                                                                            {{ method_field('put') }}
                                                                            {{ csrf_field() }}
                                                                            <button type="submit"
                                                                                    class="btn btn-sm btn-default btn-icon btn-pure btn-outline text-dark item-action"
                                                                                    data-action="Restore">
                                                                                <i class="ti-archive" aria-hidden="true"></i>
                                                                                <span class="hidden-xs">Restore</span>
                                                                            </button>
                                                                        </form>
                                                                    @else

                                                                    <form action="{{ url('vendors/'. $vendor->id) }}" method="post">
                                                                        {{ method_field('delete') }}
                                                                        {{ csrf_field() }}
                                                                        <input type="hidden" name="archive" value="true">
                                                                        <input type="hidden" name="service_id" value="{{ $service->id }}">
                                                                        <a type="button"
                                                                           class="btn btn-sm btn-danger btn-icon btn-pure btn-outline archive"
                                                                           data-toggle="tooltip" data-original-title="Archive">
                                                                            <i class="ti-archive" aria-hidden="true"></i>
                                                                            Archive
                                                                        </a>
                                                                    </form>
                                                                    @endif
                                                                    {{--<form action="{{ $prefix . '/learners/'. $vendor->id}}"--}}
                                                                    {{--method="post">--}}
                                                                    {{--{{ method_field('delete') }}--}}
                                                                    {{--{{ csrf_field() }}--}}
                                                                    {{--<input type="hidden" name="service_id" value="{{ $service->id }}">--}}
                                                                    {{--<a type="button"--}}
                                                                    {{--class="btn btn-sm btn-icon btn-pure btn-outline remove-learner"--}}
                                                                    {{--data-toggle="tooltip" data-original-title="Remove">--}}
                                                                    {{--<i class="ti-close" aria-hidden="true"></i>--}}
                                                                    {{--</a>--}}
                                                                    {{--</form>--}}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        @php unset($vendor) @endphp
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- .left-aside-column-->
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="groups">

                                <div class="table-responsive">
                                    <table id="groups-table" class="table m-t-30 table-hover contact-list"
                                           data-page-size="10" data-filter="#search-learner">
                                        <thead>
                                        <tr>
                                            <th data-priority="1">ID</th>
                                            <th data-priority="5">Name</th>
                                            <th data-priority="5">Vendors</th>
                                            <th data-priority="3">Created On</th>
                                            <th data-priority="11">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(isset($groups))
                                            @foreach($groups as $key => $group)
                                                <tr>
                                                    <td>{{ $group->id }}</td>
                                                    <td>
                                                        {{ $group->name }}
                                                    </td>
                                                    <td>
                                                        {{ $group->vendors_count }}
                                                    </td>
                                                    <td>{{ $group->created_at->format('m/d/Y h:s') }}</td>
                                                    <td>
                                                        <a href="#edit-group-{{ $group->id }}" data-toggle="modal" class="btn btn-info">
                                                            Edit
                                                        </a>
                                                        <div id="edit-group-{{ $group->id }}" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                                             aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                        <h4 class="modal-title" id="myModalLabel">Edit  Group</h4>
                                                                    </div>
                                                                    <form class="form-horizontal" action="{{ url('groups/' . $group->id) }}" method="post">
                                                                        {{ csrf_field() }}
                                                                        {{ method_field('put') }}

                                                                        <div class="modal-body">
                                                                            <div class="form-group">
                                                                                <div class="row">
                                                                                    <label class="col-md-12">Vendor(s)</label>
                                                                                    <select name="vendors[]" class="form-control col-md-12" multiple>
                                                                                        @foreach($vendors as $vendor)
                                                                                            <option value="{{ $vendor->id }}" @if(in_array($vendor->id, $group->vendors()->pluck('vendor_id')->toArray())) {{ "selected" }} @endif>
                                                                                                {{ $vendor->name }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="col-md-12">Name</label>
                                                                                <div class="col-md-12">
                                                                                    <input type="text" class="form-control" name="name" placeholder="Group Name"
                                                                                           value="{{ old('name', $group->name) }}">
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

                                                        <form action="{{ '/groups/' . $group->id }}" method="post">
                                                            {{ csrf_field() }}
                                                            {{ method_field('delete') }}
                                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure ?') ">
                                                                Delete
                                                            </button>
                                                        </form>
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


                    <!-- /.left-right-aside-column-->
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>

    <div id="service-editor" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">Add Service</h4>
                </div>
                <form class="form-horizontal" action="{{ url('services') }}" method="post">
                    {{ csrf_field() }}

                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-md-12">Name of Service</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="name" placeholder="Name"
                                       value="{{ old('name') }}">
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

    <div id="add-vendor" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel"><b>Add New Vendor</b></h4>
                </div>
                <div class="modal-body p-0">
                    @include('vendors.form')
                </div>
                {{--<div class="modal-footer">--}}
                {{--<button type="submit" class="btn btn-info waves-effect">Save</button>--}}
                {{--<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>--}}
                {{--</div>--}}
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
                <form class="form-horizontal" action="{{ url('notifications/vendors') }}" method="post" enctype="multipart/form-data">
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

    <div id="create-group" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">Create Group</h4>
                </div>
                <form class="form-horizontal" action="{{ url('groups') }}" method="post">
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
                            <label class="col-md-12">Name</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="name" placeholder="Group Name"
                                       value="{{ old('name') }}">
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
                    text: 'Add New Vendor',
//                        className : 'btn btn-info',
                    action: function (e, dt, node, config) {
                        $('#add-vendor').modal('show');
                    }
                }
            ];
            var table = initDataTable('#vendors-table', buttons);


            buttons = [
                {
                    text: 'Create New Group',
//                        className : 'btn btn-info',
                    action: function (e, dt, node, config) {
                        $('#create-group').modal('show');
                    }
                }
            ];
            var groupsTable = initDataTable('#groups-table', buttons);

            initVendorForm();
        }
    </script>
    
@endsection