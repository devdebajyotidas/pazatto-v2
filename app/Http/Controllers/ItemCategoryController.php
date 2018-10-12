<?php

namespace App\Http\Controllers;

use App\Models\ItemCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemCategoryController extends Controller
{
    public function index()
    {

        $data['page'] = 'customers';
        $data['role'] = session('role');
        $data['prefix']  = session('role');

        if(session('role') == 'vendor') // || Auth::user()->account instanceof Vendor
        {
            $vendor = Auth::user()->account;
            $data['vendor'] = $vendor;
            $data['categories'] = ItemCategory::withCount(['items'])->where('vendor_id', '=', $vendor->id)->get();
            $data['items'] = $vendor->items;
        }
        else
        {
            $data['vendors'] = Vendor::withCount(['items'])->get();
            $data['categories'] = ItemCategory::withCount(['items'])->get();
            $data['items'] = Item::withTrashed()->with(['category.vendor'])->get();
        }

        return view('items.index', $data);
    }

    public function show($id)
    {

    }

    public function store(Request $request)
    {
//        dd($request->all());
        $item = ItemCategory::create($request->all());

        if($request->ajax() || $request->wantsJson())
        {
            return response()->json($item);
        }
        else
        {
//            return redirect()->intended('items');
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        dd($request->all());
        $category = ItemCategory::find($id);
        $category->fill($request->all());
        $category->save();

        return redirect()->back();
    }

    public function destroy(Request $request, $id)
    {
        ItemCategory::destroy($id);
        return redirect()->back();
    }
}
