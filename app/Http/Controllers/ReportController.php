<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Vendor;
use Carbon\Carbon;
use function count;
use function date;
use function dd;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use function strtotime;
use function strtoupper;

class ReportController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth');
    }

    public function index()
    {
        if(session('role') != 'admin' && !isset(Auth::user()->account))
        {
            return redirect('/logout');
        }

        $data['page'] = 'reports';
        $data['role'] = session('role');
        $data['prefix']  = session('role');

        $data['vendors']  = Vendor::withTrashed()->with(
            [
                'orders' => function($query)
                {
                    $query->selectRaw('orders.*');
                    $query->selectRaw('SUM(total) as grand_total');
                },
//                'orders.lines' => function($query)
//                {
//                    $query->selectRaw('lines.*');
////                    $query->select('COUNT(total) as grand_total');
//                    $query->selectRaw('SUM(quantity) AS items_sold');
//                    $query->selectRaw('GROUP BY  item_id');
//                }
            ])->withCount(['orders'])->get(['id','name']);

//        $orders = Order::with(['lines'])->get()->groupBy('vendor_id');

//        dd($orders);

//        dd($data['vendors']->toArray());
//->each(function ($v){
//
////            $v['sales'] = DB::select("SELECT DATE(created_at) AS date, COUNT(DISTINCT id) AS order_count,SUM(sub_total) AS total FROM orders WHERE vendor_id = {$v->id} GROUP BY DATE(created_at)");
//
//            $v['sales'] = DB::select("
//SELECT DATE(orders.created_at) AS date, COUNT(DISTINCT orders.id) AS total_orders, COUNT( order_lines.item_id) * order_lines.quantity AS total_items_sold, SUM(orders.sub_total) AS total_sale
//FROM orders
//JOIN order_lines ON orders.id = order_lines.order_id
//WHERE orders.vendor_id = {$v->id}
//GROUP BY DATE(orders.created_at), order_lines.quantity
//");
//
//            $v['details'] = DB::select("
//SELECT DATE(order_lines.created_at) AS date,
//order_lines.item_name,
//SUM(order_lines.quantity) AS items_sold,
//SUM(order_lines.quantity) * order_lines.item_price AS total_sale
//FROM order_lines
//JOIN orders ON orders.id = order_lines.order_id
//WHERE orders.vendor_id = {$v->id}
//GROUP BY DATE(order_lines.created_at), order_lines.item_name, order_lines.quantity, order_lines.item_price
//");

            /* "SELECT DATE(orders.created_at) AS date,
            vendors.id, vendors.name,
order_lines.item_name,
COUNT(DISTINCT orders.id) AS total_orders,
COUNT( order_lines.item_id) * order_lines.quantity AS items_sold,
SUM(orders.sub_total) AS total ,
SUM(order_lines.quantity) AS items_sold,
SUM(order_lines.quantity) * order_lines.item_price AS total_sale


FROM orders
JOIN order_lines ON orders.id = order_lines.order_id
JOIN vendors ON orders.vendor_id = vendors.id

GROUP BY DATE(orders.created_at), DATE(order_lines.created_at), order_lines.item_name, order_lines.quantity, vendors.id, vendors.name"
            */

//        });

        if (session('role') == "vendor")
            $query = "AND vendors.id = " . Auth::user()->account->id . ' ';
        else if(session('role') == "agent")
            $query = "AND orders.agent_id = " . Auth::user()->account->id . ' ';
        else
            $query = ' ';

        $sales = DB::select("SELECT orders.created_at AS date,
            vendors.id AS vendor_id, vendors.name AS vendor_name,
COUNT(DISTINCT orders.id) AS total_orders,
SUM(orders.total) AS total_sales
FROM orders
JOIN vendors ON orders.vendor_id = vendors.id
WHERE orders.status = 5
$query
GROUP BY DATE(orders.created_at), orders.vendor_id
ORDER BY DATE(orders.created_at) DESC");
//dd($sales);

        foreach ($sales as $sale)
        {
//            dd($sale->vendor_id);
            $sale->details = DB::select("
            SELECT
order_lines.item_name,
order_lines.item_id,
order_lines.created_at,
SUM(order_lines.quantity) AS items_sold,
SUM(order_lines.quantity) * order_lines.item_price AS sales
FROM order_lines
JOIN orders ON orders.id = order_lines.order_id
AND orders.vendor_id = $sale->vendor_id
WHERE DATE(order_lines.created_at) = DATE('$sale->date')
AND orders.status = 5
GROUP BY order_lines.item_id");

        }

        $data['sales'] = collect($sales)->sortByDesc('date');


//        if (session('role') == "vendor")
//            $query = "AND vendors.id = " . Auth::user()->account->id . ' ';
        if(session('role') == "agent")
            $query = "AND o1.agent_id = " . Auth::user()->account->id . ' ';
        else
            $query = ' ';

        $deliveries = DB::select("SELECT o1.created_at AS date,
            a1.id AS agent_id, a1.first_name AS first_name,
            a1.last_name AS last_name,
COUNT(DISTINCT o1.id) AS total_orders,
(SELECT SUM(o2.total) FROM orders o2 WHERE o2.payment_method = 'COD' AND DATE(date) = DATE(o2.created_at) AND o2.agent_id = a1.id  ) AS cash_collected,
(SELECT SUM(o2.total) FROM orders o2 WHERE o2.payment_method LIKE  '%PAYTM%' AND DATE(date) = DATE(o2.created_at) AND o2.agent_id = a1.id  ) AS paid_paytm,
(SELECT SUM(o2.discount) FROM orders o2 WHERE DATE(date) = DATE(o2.created_at) AND o2.agent_id = a1.id  ) AS discounts,
SUM(o1.total) AS total_sales
FROM orders o1
JOIN agents a1 ON o1.agent_id = a1.id
WHERE o1.status = 5
$query
GROUP BY DATE(o1.created_at), o1.agent_id
ORDER BY DATE(o1.created_at) DESC");

        $data['deliveries'] = collect($deliveries)->sortByDesc('date');



//        dd($data['deliveries']);

//        $now = Carbon::now();
//        $month_number = $now->month; // get the $request->input('month') here
//        $current_year = date('Y');
//        $number_of_days = cal_days_in_month(CAL_GREGORIAN, $month_number , $current_year);
//        $result = array();
//        for($i=1;$i<=$number_of_days;$i++ ){
//            $date = $current_year.'-'.$month_number.'-'.$i;
//            $count_perday= Order::whereDate('created_at',$date)->count(); // counting number of sales per day
//            $result[]= array('Day '.$i => $count_perday); // adding into array
//        }
//        dd($result);

        return view('reports.index', $data);
    }

    public function details()
    {
        $data = request()->all();
        $data['vendor'] = Vendor::withTrashed()->find($data['vendor']);
        $data['order'] = Order::find(133);
        $data['page'] = $data['mode'] . '-details';
        $data['for'] = strtoupper(session('role'));
        $data['role'] = session('role');
        $data['details'] = DB::select("
            SELECT
order_lines.item_name,
order_lines.item_id,
order_lines.created_at,
SUM(order_lines.quantity) AS items_sold,
SUM(order_lines.quantity) * order_lines.item_price AS sales
FROM order_lines
JOIN orders ON orders.id = order_lines.order_id
AND orders.vendor_id = {$data['vendor']->id}
WHERE DATE(order_lines.created_at) = DATE('{$data['date']}')
AND orders.status = 5
GROUP BY order_lines.item_id");;

    $query = Order::with(['lines', 'lines.item', 'vendor'])->where('status', '=', 5)->whereDate('created_at', '=', $data['date']);

//    if (session('role') == "vendor")
//        $query = $query->where("vendor_id", "=" , Auth::user()->id);
//    else
        $query = $query->where("vendor_id", "=" ,  $data['vendor']->id);

    $data['orders'] = $query->get();

//    dd(count($data['orders']));
    return view('reports.details', $data);
    }
}
