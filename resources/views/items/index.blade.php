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
                                            All Items
                                            <span> {{ count($items) }} </span>
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    {{--@if(session('role') == 'vendor')--}}
                                        @foreach($categories as $category)
                                            <li>
                                                <a href="javascript:void(0)" class="service"
                                                   data-toggle="modal"
                                                   data-id="{{ $category->id }}" data-name="{{ $category->name }}">
                                                    {{ $category->name }}
                                                    ({{ $category->items_count  }})
                                                    {{--<span>{{ $category->learners()->count() }}</span>--}}
                                                    {{--<span class="vendor-count">{{ $category->items_count  }}</span>--}}
                                                    {{--<span class="remove"><i class="ti-close" aria-hidden="true"></i></span>--}}
                                                    {{--<span data-id="{{ $category->id }}"--}}
                                                    {{--data-name="{{ $category->name }}" class="edit">--}}
                                                    {{--<i class="ti-pencil" aria-hidden="true"></i>--}}
                                                    {{--</span>--}}
                                                </a>

                                                <div id="category-{{ $category->id  }}" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                                     aria-hidden="true">
                                                    <div class="modal-dialog modal-sm">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                <h4 class="modal-title" id="myModalLabel"><b>Edit Category</b></h4>
                                                            </div>
                                                            <form action="{{ url('categories/' . $category->id ) }}" method="post">
                                                                {{ csrf_field() }}
                                                                {{ method_field('put') }}
                                                                <input type="hidden" name="vendor_id" value="@if(isset($vendor)) {{ $vendor->id }} @endif">
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <label>Name</label>
                                                                        <input type="text" class="form-control" name="name" value="{{ $category->name }}">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Priority</label>
                                                                        <input type="number" class="form-control" name="priority" value="{{ $category->priority }}">
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
                                            </li>
                                        @endforeach
                                    {{--@endif--}}

                                    {{--@if(session('role') == 'admin')--}}
                                        {{--@foreach($vendors as $vendor)--}}
                                            {{--<li>--}}
                                                {{--<a href="javascript:void(0)" class="service"--}}
                                                   {{--data-id="{{ $vendor->id }}" data-name="{{ $vendor->name }}">--}}
                                                    {{--{{ $vendor->name }}--}}
                                                    {{--<span>{{ $category->learners()->count() }}</span>--}}
                                                    {{--<span class="vendor-count">{{ $vendor->items_count  }}</span>--}}
                                                    {{--<span class="remove"><i class="ti-close" aria-hidden="true"></i></span>--}}
                                                    {{--<span data-id="{{ $category->id }}"--}}
                                                    {{--data-name="{{ $category->name }}" class="edit">--}}
                                                    {{--<i class="ti-pencil" aria-hidden="true"></i>--}}
                                                    {{--</span>--}}
                                                {{--</a>--}}
                                            {{--</li>--}}
                                        {{--@endforeach--}}
                                    {{--@endif--}}

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
                                    <table id="items-table" class="display responsive nowrap table m-t-30"
                                           data-page-size="10" data-filter="#search-learner">
                                        <thead>
                                        <tr>
                                            <th data-visible="true" data-priority="4">Category</th>
                                            <th data-priority="1">Name</th>
                                            <th data-priority="5">Price <br> (Offer Price)</th>

                                            <th data-priority="6">Packing <br> Charge</th>
                                            {{--<th data-priority="3">Stock</th>--}}
                                            <th data-priority="7">In Stock</th>
                                            <th data-priority="2">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($items as $key => $item)
                                                <tr @if($item->trashed()) class="bg-danger text-white" @endif>
                                                    <td>
                                                        <span class="label label-info">
                                                            {{ $item->category->name }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->price }} ({{ $item->offer_price }})</td>
                                                    <td>{{ $item->packing_charge }}</td>
                                                    <td>
                                                        @if($item->in_stock == 0)
                                                            <span class="label label-danger">
                                                                Out of Stock
                                                            </span>
                                                        @else
                                                            <span class="label label-info">
                                                                In Stock
                                                            </span>
                                                        @endif
                                                    </td>
                                                    {{--<td>--}}
                                                        {{--<form action="{{ url('vendors/' . $vendor->id . '/items/' . $item->id) }}" method="post">--}}
                                                            {{--{{ method_field('put') }}--}}
                                                            {{--{{ csrf_field() }}--}}
                                                            {{--<input type="checkbox" name="in_stock" class="js-switch"--}}
                                                                   {{--@if($item->in_stock == 1)--}}
                                                                   {{--{{ 'checked value="1"' }}--}}
                                                                   {{--@else--}}
                                                                   {{--{{ 'value="0"' }}--}}
                                                                   {{--@endif--}}
                                                                   {{--@if($item->trashed())--}}
                                                                   {{--{{ 'disabled' }}--}}
                                                                   {{--@endif--}}
                                                                   {{--data-color="#13dafe" data-size="small" data-switchery="true"--}}
                                                                   {{--onchange="this.form.submit()">--}}
                                                        {{--</form>--}}
                                                    {{--</td>--}}
                                                    <td>
                                                        @if($item->trashed())
                                                            <form action="{{ url('vendors/' . $vendor->id . '/items/' . $item->id . '/restore') }}" method="post">
                                                                {{ method_field('put') }}
                                                                {{ csrf_field() }}
                                                                <a type="button"
                                                                   class="btn btn-sm btn-default btn-icon btn-pure btn-outline text-dark item-action"
                                                                   data-action="Restore">
                                                                    <i class="ti-archive" aria-hidden="true"></i>
                                                                    <span class="hidden-xs">Restore</span>
                                                                </a>
                                                            </form>
                                                        @else
                                                            <a href="javascript:void(0)"
                                                               class="btn btn-sm btn-info btn-icon btn-pure btn-outline"
                                                               data-toggle="modal" data-target="#edit-item-{{ $item->id }}" data-dismiss="modal">
                                                                <i class="fa fa-edit" aria-hidden="true"></i>
                                                                <span class="hidden-xs">Edit</span>
                                                            </a>
                                                            <form action="{{ url('vendors/' . $vendor->id . '/items/' . $item->id) }}" method="post">
                                                                {{ method_field('delete') }}
                                                                {{ csrf_field() }}
                                                                <a type="button"
                                                                   class="btn btn-sm btn-danger btn-icon btn-pure btn-outline item-action"
                                                                   data-action="Archive">
                                                                    <i class="ti-archive" aria-hidden="true"></i>
                                                                    <span class="hidden-xs">Archive</span>
                                                                </a>
                                                            </form>
                                                        @endif
                                                        <div id="edit-item-{{ $item->id }}" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                                             aria-hidden="true">
                                                            <div class="modal-dialog modal-sm">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                        <h4 class="modal-title" id="myModalLabel"><b>Edit Item</b></h4>
                                                                    </div>
                                                                    <form action="{{ url('vendors/' . $vendor->id . '/items/' . $item->id) }}" method="post">
                                                                        {{ method_field('put') }}
                                                                        {{ csrf_field() }}
                                                                        <div class="modal-body">
                                                                            <div class="form-group">
                                                                                <label>Category</label>
                                                                                <select name="item_category_id" class="form-control">
                                                                                    @foreach($categories as $category)
                                                                                        <option value="{{ $category->id }}" @if($category->id == $item->category_id) {{ 'selected' }} @endif>
                                                                                            {{ $category->name }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>Name</label>
                                                                                <input type="text" class="form-control" name="name" value="{{ $item->name }}">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>Price</label>
                                                                                <input type="text" class="form-control" name="price" value="{{ $item->price }}">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>Offer Price</label>
                                                                                <input type="text" class="form-control" name="offer_price" value="{{ $item->offer_price }}">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>Packing Charge</label>
                                                                                <input type="text" class="form-control" name="packing_charge" value="{{ $item->packing_charge }}">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>Stock</label>
                                                                                <select name="in_stock" id="" class="form-control">
                                                                                    <option value="1" @if($item->in_stock == 1) {{ 'selected' }} @endif>In Stock</option>
                                                                                    <option value="0" @if($item->in_stock == 0) {{ 'selected' }} @endif>Out of Stock</option>
                                                                                </select>
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
            </div>
        </div>
        <!-- /.row -->
    </div>

    <div id="add-category" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel"><b>Add New Category</b></h4>
                </div>
                <form action="{{ url('categories') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="vendor_id" value="@if(isset($vendor)) {{ $vendor->id }} @endif">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="form-group">
                            <label>Priority</label>
                            <input type="number" class="form-control" name="priority">
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

    <div id="add-item" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel"><b>Add New Item</b></h4>
                </div>
                <form action="{{ url('vendors/' . $vendor->id . '/items') }}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Category</label>
                            <select name="item_category_id" class="form-control">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input type="text" class="form-control" name="price">
                        </div>
                        <div class="form-group">
                            <label>Offer Price</label>
                            <input type="text" class="form-control" name="offer_price" value="0">
                        </div>
                        <div class="form-group">
                            <label>Packing Charge</label>
                            <input type="text" class="form-control" name="packing_charge" value="0">
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
        window.onload = function (){

//            $('form').submit(function (e) {
//                e.preventDefault();
//
//                alert(1);
//
//                console.log(e);
//                return false;
//            });

            var buttons = [
                {
                    text: 'Add New Item',
//                    className : 'btn btn-info',
                    action: function (e, dt, node, config) {
                        $('#add-item').modal('show');
                    }
                },
                {
                    text: 'Add New Category',
//                    className : 'btn btn-info',
                    action: function (e, dt, node, config) {
                        $('#add-category').modal('show');
                    }
                }
            ];
            var table = initDataTable('#items-table', buttons);

            setTimeout(function () {
                $('.dataTables_wrapper').removeClass('form-inline');
                $('.dataTables_wrapper .modal form').css('display', 'block');
            },500);

            $(document).on('click', '.item-action', function (event) {
                var that = this;
                swal.queue([{
                    title: $(that).data('action') + ' Item',
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