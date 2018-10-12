<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function redirect;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if(session('role') != 'admin' && !isset(Auth::user()->account))
        {
            return redirect('/logout');
        }

        $data['page'] = 'dashboard';
        $data['role'] = session('role');
        $data['prefix']  = session('role');

//        if(session('role') == "admin")
//        {
           $activeOrders = Order::where('status', '>=', 1)
               ->where('status', '<', 5)
               ->whereDate('created_at', DB::raw('CURDATE()'));

            $ordersDelivered = Order::where('status', '=', 5)
                ->whereDate('created_at', DB::raw('CURDATE()'));

            $ordersCancelled = Order::where('status', '=', -1)
                ->whereDate('created_at', DB::raw('CURDATE()'));

//            $sales = DB::select("SELECT
//SUM(orders.sub_total) AS total_sales
//FROM orders")
//ORDER BY DATE(orders.created_at) DESC");

//        }

        if(session('role') == "vendor")
        {
            $activeOrders = $activeOrders->where('vendor_id', '=', Auth::user()->account->id);
            $ordersDelivered = $ordersDelivered->where('vendor_id', '=', Auth::user()->account->id);
            $ordersCancelled = $ordersCancelled->where('vendor_id', '=', Auth::user()->account->id);
        }

        if(session('role') == "agent")
        {
            $activeOrders = $activeOrders->where('agent_id', '=', Auth::user()->account->id);
            $ordersDelivered = $ordersDelivered->where('agent_id', '=', Auth::user()->account->id);
            $ordersCancelled = $ordersCancelled->where('agent_id', '=', Auth::user()->account->id);
        }

        $data['activeOrders'] = $activeOrders->count();
        $data['ordersDelivered'] = $ordersDelivered->count();
        $data['ordersCancelled'] = $ordersCancelled->count();
//        $data['sales'] = $sales->get();

        return view('dashboard', $data);
    }
}
