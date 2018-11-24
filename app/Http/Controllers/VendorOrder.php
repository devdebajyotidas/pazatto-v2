<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Models\Order;
use App\Models\Vendor;



class VendorOrder extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($vendorId)
    {
          $orders = Order::with('lines')
                ->where('vendor_id',$vendorId)
               ->where('status', '>=', 1)
               ->where('status', '<', 5)
               //->whereDate('created_at', DB::raw('CURDATE()'))
               ->get();

       return $orders;
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
    public function show($id)
    {
        //
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
        $item = Order::find($id);

        $item->fill($request->all());
        $item->save();

        return $item;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      // $data=  Order::withTrashed()
      //       ->where('id', $id)
      //       ->restore();
      //   return $data;
    }
    public function takeOrders(Request $request, $id)
    {
        $result['status'] = "false";
        try
        {
            $data = $request->all();
            $vendor = Vendor::find($id);
            $vendor->fill($data);
            $vendor->save();
//            dd($vendor->is_taking_orders);
             $result['status'] = "true";
             $result['is_taking_orders'] = $vendor->is_taking_orders;
        }
        catch (\Exception $exception)
        {
              $result['status'] = 'false';
        }

        return $result;
    }
}
