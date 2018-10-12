@extends('layouts.app')
@section('content')

    <div class="container-fluid">
        <div class="row m-t-20">
            <div class="col-md-12">
                <div class="white-box p-0">
                    <div class="page-aside">
                        <div class="right-aside m-0">
                            <div class="right-page-header">
                            </div>
                            <div class="clearfix"></div>
                            <div class="scrollable">
                                <div class="table-responsive">
                                    <table id="services-table"
                                           class="display responsive nowrap table m-t-30 table-hover"
                                           data-page-size="10" data-filter="#search-learner">
                                        <thead>
                                            <tr>
                                                <th data-visible="true" data-priority="1">Service</th>
                                                <th data-visible="true" data-priority="2">Groups</th>
                                                <th data-visible="true" data-priority="3">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($services as $service)
                                            <tr>
                                                <td>
                                                    {{ $service->name }}
                                                </td>
                                                <td>
                                                    @foreach($service->groups as $group)
                                                        <div class="label label-info">
                                                            {{ $group->name }}
                                                        </div>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <a href="javascript:void(0)"
                                                       class="btn btn-sm btn-info btn-icon btn-pure btn-outline"
                                                       data-toggle="modal" data-target="#edit-service-{{ $service->id }}" data-dismiss="modal">
                                                        <i class="fa fa-edit" aria-hidden="true"></i>
                                                        <span class="hidden-xs">Edit</span>
                                                    </a>
                                                    <form action="{{ url('services/' . $service->id) }}" method="post">
                                                        {{ method_field('delete') }}
                                                        {{ csrf_field() }}
                                                        <a type="button"
                                                           class="btn btn-sm btn-danger btn-icon btn-pure btn-outline service-action"
                                                           data-action="Archive">
                                                            <i class="ti-archive" aria-hidden="true"></i>
                                                            <span class="hidden-xs">Archive</span>
                                                        </a>
                                                    </form>

                                                    <div id="edit-service-{{ $service->id }}" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                                         aria-hidden="true">
                                                        <div class="modal-dialog modal-sm">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                    <h4 class="modal-title" id="myModalLabel"><b>Edit Service</b></h4>
                                                                </div>
                                                                <form action="{{ url('services/' . $service->id) }}" method="post">
                                                                    {{ method_field('put') }}
                                                                    {{ csrf_field() }}
                                                                    <div class="modal-body">
                                                                        <div class="form-group">
                                                                            <label>Name</label>
                                                                            <input type="text" class="form-control" name="name" value="{{ $service->name }}">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Groups</label>
                                                                            <input type="text" class="form-control" data-role="tagsinput" name="groups" value="{{ count($service->groups) ? implode(',', $service->groups()->pluck('name')->toArray()) : '' }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="submit" class="btn btn-info waves-effect">Save</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
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

        <div id="add-service" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myModalLabel"><b>Add New Service</b></h4>
                    </div>
                    <form action="{{ url('services') }}" method="post">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name">
                            </div>
                            <div class="form-group">
                                <label>Groups</label>
                                <input type="text" class="form-control" name="groups" data-role="tagsinput">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-info waves-effect">Save</button>
                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            window.onload = function () {

                var buttons = [
                    {
                        text: 'Add New Service',
//                    className : 'btn btn-info',
                        action: function (e, dt, node, config) {
                            $('#add-service').modal('show');
                        }
                    }
                ];
                var table = initDataTable('#services-table', buttons);

                setTimeout(function () {
                    $('.dataTables_wrapper').removeClass('form-inline');
                    $('.dataTables_wrapper .modal form').css('display', 'block');
                },500);

                $(document).on('click', '.service-action', function (event) {
                    var that = this;
                    swal.queue([{
                        title: $(that).data('action'),
                        text: "Are you sure?",
                        confirmButtonText: $(that).data('action'),
                        confirmButtonColor: '#f55753',
                        showCancelButton: true,
                        showLoaderOnConfirm: true,
                        preConfirm: function () {
                            console.log();
                            return new Promise(function (resolve) {
                                $(that).parent('form').submit();
                            })
                        }
                    }]);
                });
            }
        </script>

@endsection