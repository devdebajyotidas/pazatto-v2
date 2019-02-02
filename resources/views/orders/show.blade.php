@extends("layouts.app")
@section("content")

    <div class="row m-t-20">
        <div class="col-md-12">
            <div class="white-box">

                <form method="post" action="{{ isset($order) ? '/orders/'. $order->id : '/orders' }}">
                    {{ csrf_field() }}
                    {{ method_field(isset($order) ? 'put' : 'post') }}
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-4 col-lg-2 col-form-label require" for="input-1">Customer</label>
                            <div class="col-8 col-lg-10">
                                <select name="customer_id" class="form-control selectpicker" data-live-search="true" >
                                    <option>Select Customer</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}" @if(isset($order) && $customer->id == $order->customer_id) {{ 'selected' }} @endif >
                                            {{ $customer->first_name . ' ' . $customer->last_name }} ({{ isset($customer->user) ? $customer->user->mobile : 'N/A' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-4 col-lg-2 col-form-label require" for="input-1">Agent</label>
                            <div class="col-8 col-lg-10">
                                <select name="agent_id" class="form-control">
                                    <option value="null">Select Agent</option>
                                    @foreach($agents as $agent)
                                        <option value="{{ $agent->id }}" @if(isset($order) && $agent->id == $order->agent_id) {{ 'selected' }} @endif >
                                            {{ $agent->first_name . ' ' . $agent->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 col-lg-2 col-form-label">Vendor</label>
                            <div class="col-8 col-lg-10">
                                <select class="form-control" id="vendor" required="" name="vendor_id">
                                    @foreach($services as $service)
                                        <optgroup label="{{ $service->name }}">
                                            @foreach($service->vendors as $vendor)
                                                <option value="{{ $vendor->id }}" @if(isset($order) && $order->vendor_id == $vendor->id) {{ 'selected' }} @endif>
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
                                @if(isset($order) && count($order->lines))
                                    @foreach($order->lines as $key => $line)
                                        <div class="row line-item">
                                            <div class="col-md-6">
                                                <input name="items[{{ $key }}][item_name]" type="text" class="form-control" value="{{ $line->item_name }}" placeholder="Item name">
                                                <input name="items[{{ $key }}][item_id]" type="hidden" value="{{ $line->item_id }}">
                                            </div>
                                            <div class="col-md-2">
                                                <input name="items[{{ $key }}][item_price]" value="{{ $line->item_price }}" type="text" class="form-control" placeholder="Price">
                                            </div>
                                            <div class="col-md-2">
                                                <input name="items[{{ $key }}][quantity]" value="{{ $line->quantity }}" type="number" class="form-control" placeholder="Quantity">
                                            </div>
                                            <div class="col-md-2">
                                                <a href="javascript:void(0)" class="btn btn-danger remove-item">
                                                    Remove
                                                </a>
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
                                        <a href="javascript:void(0)" class="btn btn-primary" id="add-item">
                                            Add Item
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-4 col-lg-2 col-form-label" for="input-3">Sub-Total</label>
                            <div class="col-8 col-lg-10">
                                <input name="sub_total" type="text" class="form-control" value="{{ old('sub_total', isset($order) ? $order->sub_total : 0) }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 col-lg-2 col-form-label" for="input-4">Packing Charge</label>
                            <div class="col-8 col-lg-10">
                                <input name="packing_charge" type="text" class="form-control" value="{{ old('packing_charge', isset($order) ? $order->packing_charge : 0) }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 col-lg-2 col-form-label" for="input-4">Delivery Charge</label>
                            <div class="col-8 col-lg-10">
                                <input name="delivery_charge" type="text" class="form-control" value="{{ old('delivery_charge', isset($order) ? $order->delivery_charge : 0) }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 col-lg-2 col-form-label" for="input-5">Tax</label>
                            <div class="col-8 col-lg-10">
                                <input type="text" name="tax" class="form-control" value="{{ old('tax', isset($order) ? $order->tax : 0) }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 col-lg-2 col-form-label" for="input-6">Discount</label>
                            <div class="col-8 col-lg-10">
                                <input type="text" name="discount" class="form-control" value="{{ old('discount', isset($order) ? $order->discount : 0) }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 col-lg-2 col-form-label" for="input-6">Total</label>
                            <div class="col-8 col-lg-10">
                                <input type="text" name="total" class="form-control" value="{{ old('total', isset($order) ? $order->total : 0) }}">
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
        var menu = [];
        window.onload = function() {
            $('.selectpicker').selectpicker();

            var itemIndex = $('.line-item').length;
            $("#vendor").change(function () {
                var vendorId = $(this).val();
                $.get("/api/v1/vendors/" + vendorId, function (response) {
                    console.log(response);
                    menu = response.menu;
                    var html = '<option value="-1">Select Item</option>';
                    for(var i = 0; i < menu.length; i++) {
                        var category = menu[i];
                        html += '<optgroup label="' + category.name + '">';
                        for(var j = 0; j < category.items.length; j++) {
                            var item = category.items[j];
                            html += '<option value="' + item.id + '">' + item.name + '</option>';
                        }
                        html += '</optgroup>';
                    }
                    $('#items').html(html);
                })
            });

            $("#add-item").click(function () {
                var itemId = $("#items").val();
                var itemName = $("#items option:selected").text();
                var itemPrice = getPrice(itemId);
                console.log(itemId, itemName);
                if(itemId == '-1')
                    return;
                var html =  '<div class="row line-item">'+
                   '<div class="col-md-6">'+
                    '<input name="items[' + itemIndex + '][item_name]" type="text" class="form-control" value="' + itemName + '">'+
                    '<input name="items[' + itemIndex + '][item_id]" type="hidden" value="' + itemId + '">'+
                   '</div>'+
                   '<div class="col-md-2">'+
                   '<input name="items[' + itemIndex + '][item_price]" value="' + itemPrice + '" type="text" class="form-control" placeholder="Price" >'+
                   '</div>'+
                   '<div class="col-md-2">'+
                   '<input name="items[' + itemIndex + '][quantity]" value="1" type="number" class="form-control"  placeholder="Quantity">'+
                   '</div>'+
                   '<div class="col-md-2">'+
                   '<a href="javascript:void(0)" class="btn btn-danger remove-item">Remove</a>'+
                   '</div>'+
                   '</div>';
                 $('#lines').prepend(html);
                 itemIndex++;
                $("#items").val('-1');
            });

            $(document).on('click', ".remove-item", function () {
                if(confirm("Are you sure ?")) {
                    $(this).parents('.line-item').remove();
                }

            });

            $('#vendor').change();
        }

        function getPrice(itemId) {
            for(var i = 0; i < menu.length; i++) {
                var category = menu[i];
                for(var j = 0; j < category.items.length; j++) {
                    var item = category.items[j];
                    if(item.id == itemId)
                        return item.price;
                }
            }
            return 0;
        }
    </script>
@endsection