<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class TestOrderController
{
    public function index($belongsTo = null)
    {
        return Order::count();
    }

    public function store(Request $request, $belongsTo = null)
    {
        dd($belongsTo, Route::current()->parameters());
    }

    public function update(Request $request, $belongsTo = null, $orderId)
    {
        dd($belongsTo, $orderId, Route::current()->parameters());
    }
}