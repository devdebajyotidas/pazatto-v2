<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderLine;
use App\Notifications\Notify;
use Illuminate\Http\Request;

class CustomerOrderController extends Controller
{
    public function index($customerId)
    {
        $orders = Order::with([
            'lines.item.category' => function($query){

        }, 'vendor' => function($query){
                $query->select('id','name','min_order','delivery_charge','tax','has_delivery','has_takeaway');
        }])->where('customer_id', '=', $customerId)->orderBy('id','desc')->get();

        return $orders;
    }

    public function store(Request $request, $customerId)
    {
        $data = $request->all();

        if(!isset($data['customer_note']) || is_null($data['customer_note']))
            $data['customer_note'] = "";

        if(!isset($data['vendor_note']) || is_null($data['vendor_note']))
            $data['vendor_note'] = "";

        $order = Order::create($data);

        foreach ($data['items'] as $item)
        {
            $line = OrderLine::make($item);
            $order->lines()->save($line);
        }
        Notify::sendOrderNotification($order);

        return Order::with(['lines.item.category','vendor' => function($query){
            $query->select('id','name','min_order','delivery_charge','tax','has_delivery','has_takeaway');
        }])->where('customer_id','=',$customerId)->orderBy('id','desc')->get();
    }

    public function show($customerId, $orderId)
    {
        return Order::with(['lines'])->find($orderId);
    }

    public function update(Request $request, $customerId, $orderId)
    {
        $data = $request->all();

        if(!isset($data['customer_note']) || is_null($data['customer_note']))
            $data['customer_note'] = "";

        if(!isset($data['vendor_note']) || is_null($data['vendor_note']))
            $data['vendor_note'] = "";

        $order = Order::find($orderId);
        $order->fill($data);
        
        if($order->save())
        {
            Notify::sendOrderNotification($order);
            return response()->json(['status' => true]);
        }
        else
        {
            return response()->json(['status' => false]);
        }

        // return Order::with(['lines.item.category','vendor' => function($query){
        //     $query->select('id','name','min_order','delivery_charge','tax','has_delivery','has_takeaway');
        // }])->where('customer_id','=',$customerId)->orderBy('id','desc')->get();

    }

    public function delete(Request $request, $customerId, $orderId)
    {

    }
}
