<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Models\Order;
use App\Models\Vendor;
use Illuminate\Http\Request;

class AgentOrderDetails extends Controller
{
    /**
     * Display a listing of the resource.

     *
     * @return \Illuminate\Http\Response
     */
    public function index($agent_id)
    {
        //        if(session('role') != 'admin' && !isset(Auth::user()->account))
        // {
        //     return redirect('/logout');
        // }

        $data['page'] = 'reports';
        // $data['role'] = session('role');
        // $data['prefix']  = session('role');

        // $data['vendors']  = Vendor::with(
        //     [
        //         'orders' => function($query)
        //         {
        //             $query->selectRaw('orders.*');
        //             $query->selectRaw('SUM(total) as grand_total');
        //         },

        //     ])->withCount(['orders'])->get(['id','name']);


        // if (session('role') == "vendor")
        // //     $query = "AND vendors.id = " . Auth::user()->account->id . ' ';
        // else if(session('role') == "agent")
            $query = "AND orders.agent_id = " . $agent_id . ' ';
        // else
        //     $query = ' ';

        $sales = DB::select("SELECT orders.created_at AS date,
            -- vendors.id AS vendor_id, vendors.name AS vendor_name,
COUNT(DISTINCT orders.id) AS total_orders,
SUM(orders.total) AS total_sales
FROM orders
-- JOIN vendors ON orders.vendor_id = vendors.id
WHERE orders.status = 5
$query
GROUP BY DATE(orders.created_at)
-- , orders.vendor_id
ORDER BY DATE(orders.created_at) DESC");
//dd($sales);

//         foreach ($sales as $sale)
//         {
// //            dd($sale->vendor_id);
//             $sale->details = DB::select("
//             SELECT
// order_lines.item_name,
// order_lines.item_id,
// order_lines.created_at,
// SUM(order_lines.quantity) AS items_sold,
// SUM(order_lines.quantity) * order_lines.item_price AS sales
// FROM order_lines
// JOIN orders ON orders.id = order_lines.order_id
// AND orders.vendor_id = $sale->vendor_id
// WHERE DATE(order_lines.created_at) = DATE('$sale->date')
// AND orders.status = 5
// GROUP BY order_lines.item_id");

//         }

        $data['sales'] = $sales; 
        // $data['sales'] = collect($sales)->sortByDesc('date');


//        if (session('role') == "vendor")
//            $query = "AND vendors.id = " . Auth::user()->account->id . ' ';
//         if(session('role') == "agent")
//             $query = "AND o1.agent_id = " . Auth::user()->account->id . ' ';
//         else
//             $query = ' ';

//         $deliveries = DB::select("SELECT o1.created_at AS date,
//             a1.id AS agent_id, a1.first_name AS first_name,
//             a1.last_name AS last_name,
// COUNT(DISTINCT o1.id) AS total_orders,
// (SELECT SUM(o2.total) FROM orders o2 WHERE o2.payment_method = 'COD' AND DATE(date) = DATE(o2.created_at) AND o2.agent_id = a1.id  ) AS cash_collected,
// (SELECT SUM(o2.total) FROM orders o2 WHERE o2.payment_method LIKE  '%PAYTM%' AND DATE(date) = DATE(o2.created_at) AND o2.agent_id = a1.id  ) AS paid_paytm,
// (SELECT SUM(o2.discount) FROM orders o2 WHERE DATE(date) = DATE(o2.created_at) AND o2.agent_id = a1.id  ) AS discounts,
// SUM(o1.total) AS total_sales
// FROM orders o1
// JOIN agents a1 ON o1.agent_id = a1.id
// WHERE o1.status = 5
// $query
// GROUP BY DATE(o1.created_at), o1.agent_id
// ORDER BY DATE(o1.created_at) DESC");

//         $data['deliveries'] = collect($deliveries)->sortByDesc('date');




        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($agentid, $date)
    {

        $query = Order::with(['lines', 'lines.item', 'vendor'])->where('status', '=', 5)->whereDate('created_at', '=', $date);

        $query = $query->where("agent_id", "=" ,  $agentid);


        $data['orders'] = $query->get();




    $subTotal = 0;
    $packingCharge = 0;
    $deliveryCharge = 0;
    $tax = 0;
    $discount = 0;
    $total = 0;

    $cashPayment = 0;
    $onlinePayment = 0;
    $paymentGatewayFees = 0;

    $customerCommission = 0;
    $vendorCommission = 0;

    $amountToCredit = 0;
    $amountToCollect = 0;

    
    foreach($data['orders'] as $key => $order){

       $subTotal += $order->sub_total;

        $packingCharge += $order->packing_charge;
        $deliveryCharge += $order->delivery_charge;
        $tax += $order->tax;
        $discount += $order->discount;
        $total += $order->total;

        if($order->payment_method == "COD")
            $cashPayment += $order->total;
        else
            $onlinePayment += $order->total;

    }

    $summary['subTotal']= $subTotal ;
    $summary['packingCharge']= $packingCharge ;
    $summary['deliveryCharge']= $deliveryCharge ;
    $summary['tax']= $tax ;
    // $summary['taxPar'] = $data['vendor']->tax;
    
    $summary['discount']= $discount ;
    $summary['total']= $total ;
    $summary['cashPayment']= $cashPayment ;
    $summary['onlinePayment']= $onlinePayment ;

    // $vendorCommission = ceil(  ($data['vendor']->pazatto_commission/100) * (($subTotal + $packingCharge)));
    $summary['vendorCommission'] = $vendorCommission;

    // $summary['vendorCommissionPar'] = $data['vendor']->pazatto_commission;

    
    // $customerCommission = ceil(($data['vendor']->customer_commission/100) * $subTotal);

    // $paymentGatewayFees = ceil( (2/100) * $onlinePayment);
    // $summary['paymentGatewayFees'] = $paymentGatewayFees;

    // $amountToCredit = ($subTotal + $packingCharge) - $vendorCommission - $customerCommission - $paymentGatewayFees;
    // $summary['amountToCredit'] = $amountToCredit;


    $data['summary'] =  $summary;

//    dd(count($data['orders']));

        return $data;



    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
