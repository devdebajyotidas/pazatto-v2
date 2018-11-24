<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Models\Order;
use Illuminate\Http\Request;

class TestOrderController extends Controller
{
    public function index($vendorId)
    {

        $orders = Order::with('lines')
                ->where('vendor_id',$vendorId)
               ->where('status', '>=', 1)
               ->where('status', '<', 5)
               ->whereDate('created_at', DB::raw('CURDATE()'))
               ->get();

       return $orders;
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