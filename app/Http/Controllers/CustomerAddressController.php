<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerAddressController extends Controller
{
    public function index($customerId)
    {
        $customer = Customer::find($customerId);
        return $customer->addresses;
    }

    public function store(Request $request, $customerId)
    {
        $address = Address::make($request->all());
        $customer = Customer::find($customerId);
        $customer->addresses()->save($address);

        return $customer->addresses()->get();
    }

    public function show($customerId, $addressId)
    {

    }

    public function update(Request $request, $customerId, $addressId)
    {
        $address = Address::find($addressId);
        $address->fill($request->all());
        $address->save();

        $customer = Customer::find($customerId);
        $customer->addresses()->save($address);

        return $customer->addresses()->get();
    }

    public function destroy(Request $request, $customerId, $addressId)
    {
        Address::destroy($addressId);
        $customer = Customer::find($customerId);
        return $customer->addresses;
    }
}
