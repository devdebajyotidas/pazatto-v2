@extends("layouts.app")
@section("content")

    <div class="row m-t-20">
        <div class="col-md-12">
            <div class="white-box">

                <form method="post" action="">
                    {{ csrf_field() }}
                    {{ method_field(isset($order) ? 'put' : 'post') }}

                        <div class="form-group row">
                            <label class="col-4 col-lg-2 col-form-label require" for="input-1">Customer</label>
                            <div class="col-8 col-lg-10">
                                <select name="customer_id" class="form-control">
                                    <option>Select Customer</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}" @if($customer->id == $order->customer_id) {{ 'selected' }} @endif >
                                            {{ $customer->first_name . ' ' . $customer->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-4 col-lg-2 col-form-label require" for="input-1">Agent</label>
                            <div class="col-8 col-lg-10">
                                <select name="agent_id" class="form-control">
                                    <option>Select Agent</option>
                                    @foreach($agents as $agent)
                                        <option value="{{ $agent->id }}" @if($agent->id == $order->agent_id) {{ 'selected' }} @endif >
                                            {{ $agent->first_name . ' ' . $agent->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-4 col-lg-2 col-form-label">Vendor</label>
                            <div class="col-8 col-lg-10">
                                <select class="form-control" id="vendor" required="" name="vendor_id">
                                    @foreach($services as $service)
                                        <optgroup label="{{ $service->name }}">
                                            @foreach($service->vendors as $vendor)
                                                <option value="{{ $vendor->id }}" @if(isset($order) && $order->vendor_id == $vendor->id) {{ 'selected }} @endif>
                                                    {{ $vendor->name }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-4 col-lg-2 col-form-label" for="input-2">Items</label>
                            <div class="col-8 col-lg-10" id="lines">
                                @if($order && count($order->lines))
                                    @foreach($order->lines as $key => $line)
                                        <div class="row line-item">
                                            <div class="col-md-6">
                                                <input name="lines[{{ $key }}][item_name]" type="text" class="form-control" placeholder="Item name">
                                                <input name="lines[{{ $key }}][item_id]" type="hidden">
                                            </div>
                                            <div class="col-md-2">
                                                <input name="lines[{{ $key }}][item_price]" type="number" class="form-control" placeholder="Price">
                                            </div>
                                            <div class="col-md-2">
                                                <input name="lines[{{ $key }}][quantity]" type="number" class="form-control" placeholder="Quantity">
                                            </div>
                                            <div class="col-md-2">
                                                <button class="btn btn-danger remove-item">
                                                    Remove
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                <div class="row">
                                    <div class="col-md-6">
                                        <select class="form-control" id="items">
                                            <option>Select Item</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-primary add-item">
                                            Add Item
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-4 col-lg-2 col-form-label" for="input-3">Sub-Total</label>
                            <div class="col-8 col-lg-10">
                                <input name="sub_total" type="text" class="form-control" value="{{ isset($order) ? $order->sub_total : "" }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 col-lg-2 col-form-label" for="input-4">Packing Charge</label>
                            <div class="col-8 col-lg-10">
                                <input name="packing_charge" type="number" class="form-control" value="{{ isset($order) ? $order->packing_charge : "" }}">
{{--                                <input name="packing_charge" type="number" class="form-control" value="{{  isset($order) ? $order->packing_charge : '' }}">--}}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 col-lg-2 col-form-label" for="input-4">Delivery Charge</label>
                            <div class="col-8 col-lg-10">
                                {{--<input name="delivery_charge" type="number" class="form-control" value="{{ old('delivery_charge', isset($order) ? $order->delivery_charge : '') }}">--}}
                                <input name="delivery_charge" type="number" class="form-control" value="{{ isset($order) ? $order->delivery_charge : "" }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 col-lg-2 col-form-label" for="input-5">Tax</label>
                            <div class="col-8 col-lg-10">
                                {{--<input type="text" name="tax" class="form-control" value="{{ old('tax', isset($order) ? $order->tax : '') }}">--}}
                                <input type="text" name="tax" class="form-control" value="{{ isset($order) ? $order->tax : "" }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 col-lg-2 col-form-label" for="input-6">Discount</label>
                            <div class="col-8 col-lg-10">
                                {{--<input type="text" name="discount" class="form-control" value="{{ old('discount', isset($order) ? $order->discount : '') }}">--}}
                                <input type="text" name="discount" class="form-control" value="{{ isset($order) ? $order->discount : "" }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 col-lg-2 col-form-label" for="input-6">Total</label>
                            <div class="col-8 col-lg-10">
                                {{--<input type="text" name="total" class="form-control" value="{{ old('total', isset($order) ? $order->total : '') }}">--}}
                                <input type="text" name="total" class="form-control" value="{{ isset($order) ? $order->total : "" }}">
                            </div>
                        </div>
                    </div>
                    <footer class="card-footer text-right">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </footer>
                </form>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            var itemIndex = $('.line-item').length;
            $('#vendor').change(function () {
                var vendorId = $(this).val();
                $.get('/api/v1/vendors/' + vendorId, function (response) {
                    console.log(response);
                    var menu = response.menu;
                    var html = '<option>Select Item</option>';
                    for(var i = 0; i < menu.length; i++) {
                        var category = menu[i];
                        html += '<optgroup label="' + category.name + '">';
                        for(var j = 0; j < category.items.length; j++) {
                            var item = category.items[j];
                            html += '<option value="' + item.id + '">' + item.name + '</option>'
                        }
                        html += '</optgroup>';
                    }
                    $('#items').html(html);
                })
            });

            $('#add-item').click(function () {
                var itemId = $('#items').val();
                var itemName = $('#items option:selected').text();
                var html =  '<div class="row line-item">'+
                   '<div class="col-md-6">'+
                    '<input name="lines[' + itemIndex + '][item_name]" type="text" class="form-control" value="' + itemName + '">'+
                    '<input name="lines[' + itemIndex + '][item_name]" type="hidden" value="' + itemId + '">'+
                   '</div>'+
                   '<div class="col-md-2">'+
                   '<input name="lines[' + itemIndex + '][item_price]" type="number" class="form-control" placeholder="Price" >'+
                   '</div>'+
                   '<div class="col-md-2">'+
                   '<input name="lines[' + itemIndex + '][quantity]" type="number" class="form-control"  placeholder="Quantity">'+
                   '</div>'+
                   '<div class="col-md-2">'+
                   '<button class="btn btn-danger remove-item">Remove</button>'+
                   '</div>'+
                   '</div>'
                 $('#lines').append(html);
            });

            $('#vendor').change();
        }
    </script>
@endsection