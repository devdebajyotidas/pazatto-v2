<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\Vendor;
use Illuminate\Support\Facades\Auth;

class VendorItems extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
//    public function store(Request $request, $vendorId)
//     {
//
//
//        $data = [];
//        $item = Item::create($request->all());
//
//        if($request->ajax() || $request->wantsJson())
//        {
//
//            $data['result'] =  response()->json($item);
//            $data['status'] = 'false';
//
//            return $data;
//        }
//        else
//        {
////          return redirect()->intended('items');
//            $data=[];
//            $data['status'] = 'true';
//             $data['result'] = $item;
//            return $data;
//        }
//     }

    public function store(Request $request)
    {


        $item = Item::create($request->all());

        if ($request->ajax() || $request->wantsJson()) {

            $data['result'] = response()->json($item);
            $data['status'] = 'false';

            return $data;
        } else {
//          return redirect()->intended('items');
            $data = [];
            $data['status'] = 'true';
            $data['result'] = $item;
            return $data;
        }
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
    public function update(Request $request, $itemId)
    {
        $item = Item::find($itemId);
        $item->fill($request->all());
        

       

        if($item->save()){
            $data['status']='true';
            $data['result']=$item;
        }
        else{
             $data['status']='false';
        }
        return $data;
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
