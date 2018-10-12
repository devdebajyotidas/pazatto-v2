{{--{{ url('http://34.215.207.204/vendors' . isset($vendor)? '/'.$vendor->id : '' ) }}--}}
<form id="vendor-form" class="form-material" method="post" action="" enctype="multipart/form-data">
    {{ csrf_field() }}
    {{ method_field(isset($profile) && ($profile == 'vendors') ? 'put' : 'post') }}
    <div class="wizard">
        <ul class="wizard-steps" role="tablist">
            <li class="active" role="tab">
                <h4><span><i class="fa fa-sticky-note"></i></span>Primary</h4>
            </li>
            <li role="tab">
                <h4><span><i class="fa fa-map-marker"></i></span>Location</h4>
            </li>
            <li role="tab">
                <h4><span><i class="fa fa-cogs"></i></span>Operation</h4>
            </li>
            <li role="tab">
                <h4><span><i class="fa fa-user"></i></span>Account</h4>
            </li>
        </ul>
        <div class="wizard-content">
            <div class="wizard-pane active" role="tabpanel">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group text-center m-b-30">
                            <div class="fileupload">
                                <img id="preview" src="{{ isset($vendor) ? $vendor->featured_image: 'http://sanarch.in/public/images/defaultAvatar.png' }}" alt="">
                                <input class="upload" type="file" name="vendor[featured_image]" onchange="previewImage(this)">
                                <label class="btn btn-block"><i class="fa fa-upload m-r-5"></i>Upload Image</label>
                            </div>
                        </div>
                        <div class="form-group col-md-6 m-b-20">
                            <label for="vendor[name]">Vendor Name</label>
                            <input type="text" class="form-control" name="vendor[name]" placeholder="My Super Cool Business"
                                   value="{{ old('vendor.name', isset($vendor->name) ? $vendor->name: '') }}" required>
                        </div>
                        <div class="form-group col-md-6  m-b-20">
                            <label for="">Contact Person</label>
                            <input type="text" class="form-control" name="vendor[contact_person]" placeholder="John Doe"
                                   value="{{ old('vendor.contact_person', isset($vendor->contact_person) ? $vendor->contact_person : '') }}" required>
                        </div>
                        <div class="form-group col-md-6 m-b-20">
                            <label for="">Phone</label>
                            <input type="text" class="form-control" name="vendor[contact_phone]" placeholder="1234567890" maxlength="10"
                                   value="{{ old('vendor.contact_phone', isset($vendor->contact_phone) ? $vendor->contact_phone : '') }}" required>
                        </div>
                        <div class="form-group col-md-6 m-b-20">
                            <label for="">Email</label>
                            <input type="text" class="form-control" name="vendor[contact_email]" placeholder="1234567890"
                                   value="{{ old('vendor.contact_email', isset($vendor->contact_email) ? $vendor->contact_email : '') }}" required>
                        </div>
                        <div class="form-group col-md-6 m-b-20">
                            <label for="">Service</label>
                            <select name="vendor[service_id]" class="form-control" required>
                                @foreach($services as $service)
                                <option value="{{ $service->id }}" @if( isset($vendor) && $vendor->service_id == $service->id) {{ 'selected' }} @endif>{{ $service->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{--<div class="form-group col-md-6 m-b-20">--}}
                            {{--<label for="">Service Group</label>--}}
                            {{--<input type="text" class="form-control" data-role="tagsinput" name="vendor[category]" placeholder="Eg. Pure Veg, Non-Veg, Mineral Water, Normal Water"--}}
                                   {{--value="{{ old('vendor.category', isset($vendor->category) ? $vendor->category : '') }}" required>--}}
                        {{--</div>--}}
                        <div class="form-group col-md-12 m-b-20">
                            <label for="">Highlights</label>
                            <input type="text" class="form-control" data-role="tagsinput" name="vendor[highlights]" placeholder="Eg. Pure Veg, Non-Veg, Mineral Water, Normal Water"
                                   value="{{ old('vendor.highlights', isset($vendor->highlights) ? $vendor->highlights : '') }}" required>
                            {{--<select name="vendor[highlights]" class="select2 form-control m-b-10 select2-multiple" multiple="multiple" data-placeholder="Choose" required>--}}
                                {{--<optgroup label="Cuisines">--}}
                                    {{--<option value="Tandoor">Tandoor</option>--}}
                                    {{--<option value="Chinese">Chinese</option>--}}
                                    {{--<option value="Bengali">Bengali</option>--}}
                                    {{--<option value="Hyderabadi">Hyderabadi</option>--}}
                                    {{--<option value="Mughlai">Mughlai</option>--}}
                                    {{--<option value="Punjabi">Punjabi</option>--}}
                                    {{--<option value="South Indian">South Indian</option>--}}
                                {{--</optgroup>--}}
                                {{--<optgroup label="Water Packages">--}}
                                    {{--<option value="Mineral Water">Mineral Water</option>--}}
                                    {{--<option value="Tapped Cans">Tapped Cans</option>--}}
                                    {{--<option value="20lt Jars">20lt Jars</option>--}}
                                    {{--<option value="Kinley">Kinley</option>--}}
                                    {{--<option value="Bislery">Bislery</option>--}}
                                    {{--<option value="Aquafina">Aquafina</option>--}}
                                {{--</optgroup>--}}
                            {{--</select>--}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="wizard-pane" role="tabpanel">
                <div id="location-container" class="row">
                    <div class="col-md-12 location-components">

                        @if(isset($vendor) && count($vendor->locations))
                            @foreach($vendor->locations as $key => $location)
                                <div class="form-group col-md-12 m-b-20">
                                    <label for="">Full Address</label>
                                    <input type="text" class="form-control address" name="address[{{ $key }}][formatted_address]" placeholder="112 Nilachal, Birati, Kolkata - 700051"
                                           value="{{ $location->formatted_address }}" required>
                                    <input type="hidden" name="address[{{ $key }}][latitude]" class="latitude" value="{{ $location->latitude }}">
                                    <input type="hidden" name="address[{{ $key }}][longitude]" class="longitude" value="{{ $location->longitude }}">
                                </div>
                            @endforeach
                        @else
                            <div class="form-group col-md-12 m-b-20">
                                <label for="">Full Address</label>
                                <input type="text" class="form-control address" name="address[0][formatted_address]" placeholder="112 Nilachal, Birati, Kolkata - 700051"
                                       value="{{ old('address.0.formatted_address') }}" required>
                                <input type="hidden" name="address[0][latitude]" class="latitude" value="{{ old('address.0.latitude') }}">
                                <input type="hidden" name="address[0][longitude]" class="longitude" value="{{ old('address.0.longitude') }}">
                            </div>
                        @endif
                        {{--<div class="form-group col-md-4 m-b-20">--}}
                            {{--<label for="">Building, Establishment Name/No.</label>--}}
                            {{--<input type="text" class="form-control" name="address[building]" placeholder=""--}}
                                   {{--value="{{ old('address.building') }}">--}}
                        {{--</div>--}}
                        {{--<div class="form-group col-md-4 m-b-20">--}}
                            {{--<label for="">Street/Cross/Area</label>--}}
                            {{--<input type="text" class="form-control" name="address[street]" placeholder=""--}}
                                   {{--value="{{ old('address.street') }}">--}}
                        {{--</div>--}}
                        {{--<div class="form-group col-md-4 m-b-20">--}}
                            {{--<label for="">Landmark (Optional)</label>--}}
                            {{--<input type="text" class="form-control" name="address[landmark]" placeholder=""--}}
                                   {{--value="{{ old('address.landmark') }}">--}}
                        {{--</div>--}}
                        {{--<div class="form-group col-md-3 m-b-20">--}}
                            {{--<label for="">Locality/Town</label>--}}
                            {{--<input type="text" class="form-control" name="address[locality]" placeholder=""--}}
                                   {{--value="{{ old('address.locality') }}">--}}
                        {{--</div>--}}
                        {{--<div class="form-group col-md-3 m-b-20">--}}
                            {{--<label for="">City</label>--}}
                            {{--<input type="text" class="form-control" name="address[city]" placeholder=""--}}
                                   {{--value="{{ old('address.city') }}">--}}
                        {{--</div>--}}
                        {{--<div class="form-group col-md-3 m-b-20">--}}
                            {{--<label for="">State</label>--}}
                            {{--<input type="text" class="form-control" name="address[state]" placeholder=""--}}
                                   {{--value="{{ old('address.state') }}">--}}
                        {{--</div>--}}
                        {{--<div class="form-group col-md-3 m-b-20">--}}
                            {{--<label for="">Postal Code</label>--}}
                            {{--<input type="text" class="form-control" name="address[postal_code]" placeholder=""--}}
                                   {{--value="{{ old('address.postal_code') }}">--}}
                        {{--</div>--}}
                    </div>
                </div>
                {{--<div class="row">--}}
                    {{--<div class="col-md-12">--}}
                        {{--<button id="add-location" class="btn btn-primary" type="button" onclick="addLocation()">--}}
                            {{--<span class="fa fa-plus"></span>--}}
                            {{--Add Location--}}
                        {{--</button>--}}
                    {{--</div>--}}
                {{--</div>--}}
            </div>

            <div class="wizard-pane" role="tabpanel">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group col-md-6 m-b-20">
                            <label>Has Delivery
                                <input type="checkbox" name="vendor[has_delivery]" class="js-switch" data-color="#eb3270" data-size="small" value="1"
                                @if( isset($vendor) && $vendor->has_delivery) {{ 'checked' }} @endif
                                />
                            </label>
                        </div>
                        <div class="form-group col-md-6 m-b-20">
                            <label class="m-l-20">Has Takeaway
                                <input type="checkbox" name="vendor[has_takeaway]" class="js-switch" data-color="#eb3270" data-size="small" value="1"
                                @if(isset($vendor) && $vendor->has_takeaway) {{ 'checked' }} @endif
                                />
                            </label>
                        </div>
                        <div class="form-group col-md-12 m-b-20">
                            <label>Set Delivery Range</label>
                            <div id="delivery-range"></div>
                            <small class="pull-left">Free Delivery Range: <span id="free-delivery-range">0-5</span> </small>
                            <small class="pull-right">Paid Delivery Range: <span id="paid-delivery-range">5-10</span> </small>
                            <input type="hidden" name="vendor[free_delivery_range]" value="{{ old('vendor.free_delivery_range', isset($vendor->free_delivery_range) ? $vendor->free_delivery_range : 5 )  }}">
                            <input type="hidden" name="vendor[paid_delivery_range]" value="{{ old('vendor.paid_delivery_range', isset($vendor->paid_delivery_range) ? $vendor->paid_delivery_range : 0 )  }}">
                        </div>
                        <div class="form-group col-md-6 m-b-20">
                            <label>Delivery Charge</label>
                            <input type="number" class="form-control" name="vendor[delivery_charge]" placeholder="20"
                                   value="{{ old('vendor.delivery_charge', isset($vendor) ? $vendor->delivery_charge : '') }}" required>
                        </div>
                        <div class="form-group col-md-6 m-b-20">
                            <label>Delivery Time (Minutes)</label>
                            <input type="number" class="form-control" name="vendor[average_delivery_time]" placeholder="30"
                                   value="{{ old('vendor.average_delivery_time', isset($vendor) ? $vendor->average_delivery_time : '') }}" required>
                        </div>
                    </div>
                    <div class="col-md12">
                        <div class="form-group col-md-6 m-b-20">
                            <label>Min. Order Amount</label>
                            <input type="number" class="form-control" name="vendor[min_order]" placeholder="100"
                                   value="{{ old('vendor.min_order', isset($vendor) ? $vendor->min_order : '') }}" required>
                        </div>
                        <div class="form-group col-md-6 m-b-20">
                            <label>Average Cost</label>
                            <input type="number" class="form-control" name="vendor[average_cost]" placeholder="250"
                                   value="{{ old('vendor.average_cost', isset($vendor) ? $vendor->average_cost : '') }}" required>
                        </div>
                        <div class="form-group col-md-6 m-b-20">
                            <label for="">Open Time</label>
                            <input type="text" class="form-control clockpicker" name="vendor[open_time]" placeholder="09:30"
                                   value="{{ old('vendor.open_time', isset($vendor) ? $vendor->open_time : '') }}" required>
                        </div>
                        <div class="form-group col-md-6 m-b-20">
                            <label for="">Close Time</label>
                            <input type="text" class="form-control clockpicker" name="vendor[close_time]" placeholder="09:30"
                                   value="{{ old('vendor.close_time', isset($vendor) ? $vendor->close_time : '') }}" required>
                        </div>
                        <div class="form-group col-md-4 m-b-20">
                            <label for="">Tax (%)</label>
                            <input type="number" class="form-control" placeholder="0" name="vendor[tax]"
                                   value="{{ old('vendor.tax', isset($vendor) ? $vendor->tax : '') }}" required>
                        </div>
                        <div class="form-group col-md-4 m-b-20">
                            <label for="">Pazatto Commission (%)</label>
                            <input type="number" class="form-control" placeholder="8" name="vendor[pazatto_commission]"
                                   value="{{ old('vendor.pazatto_commission', isset($vendor) ? $vendor->pazatto_commission : '') }}" required>
                        </div>
                        <div class="form-group col-md-4 m-b-20">
                            <label for="">Customer Commission (%)</label>
                            <input type="number" class="form-control" placeholder="2" name="vendor[customer_commission]"
                                   value="{{ old('vendor.customer_commission', isset($vendor) ? $vendor->customer_commission : '') }}" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="wizard-pane" role="tabpanel">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group col-md-6 m-b-20">
                            <label for="">Email</label>
                            <input type="email" class="form-control" name="user[email]" placeholder="Email"
                                   value="{{ old('user.email', isset($vendor->user) ? $vendor->user->email : 'N/A') }}" required>
                        </div>
                        <div class="form-group col-md-6 m-b-20">
                            <label for="">Mobile</label>
                            <input type="number" class="form-control" name="user[mobile]" placeholder="Mobile"
                                   value="{{ old('user.mobile', isset($vendor->user) ? $vendor->user->mobile : 'N/A') }}" required>
                        </div>
                        <div class="form-group col-md-6 m-b-20">
                            <label for="">Password</label>
                            <input type="password" class="form-control" name="user[password]"
                                   placeholder="Password" required>
                        </div>
                        <div class="form-group col-md-6 m-b-20">
                            <label for="">Confirm Password</label>
                            <input type="password" class="form-control" name="user[password_confirmation]"
                                   placeholder="Confirm Password" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<style>
    @media(max-width: 767px){
        .wizard-steps > li:not(.current) {
            display: none;
        }
    }
</style>

<script>
    function addLocation() {

        var totalLocations = $('.location-components').length + 1;
        var locationFieldsHTML = '<div class="col-md-12 location-components">'+
            '<div class="form-group col-md-12 m-b-20">'+
            '<label for="">Full Address</label>'+
            '<input type="text" class="form-control address" name="address[' + totalLocations + '][formatted_address]" placeholder="112 Nilachal, Birati, Kolkata - 700051"value="{{ old('address.0.formatted_address') }}">'+
            '<input type="hidden" name="address[' + totalLocations + '][latitude]" class="latitude" value="">'+
            '<input type="hidden" name="address[' + totalLocations + '][longitude]" class="longitude" value="">'+
            '</div>'+
            '</div>';

        $('#location-container').append(locationFieldsHTML);
        initGeoCoder();
    }
</script>