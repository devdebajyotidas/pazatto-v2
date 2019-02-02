<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth');
    }

    public function index($vendorId)
    {
        $data['page'] = 'vendors';
        $data['role'] = session('role');
        $data['prefix']  = session('role');

        $vendor = Vendor::withTrashed()->find($vendorId); //Auth::user()->account;
        $data['vendor'] = $vendor;
        $data['categories'] = ItemCategory::withTrashed()
            ->withCount(['items'])
            ->where('vendor_id', '=', $vendor->id)
            ->orderBy('priority', 'DESC')
//            ->orderBy('updated_at', 'DESC')
            ->get();
        $data['items'] = $vendor->items()->withTrashed()->get();

        return view('items.index', $data);
    }

    public function show($id)
    {

    }

    public function store(Request $request, $vendorId)
    {
        $data = $request->all();

        if ($request->hasFile('image'))
        {
            $file = $request->file('image');
            $name = time().rand(100,999).".".$file->getClientOriginalExtension();
            if($file->move('uploads/',$name))
            {
                $image = Image::create([
                    'filename' => $name,
                    'original' => $file->getClientOriginalName(),
                    'mime' => $file->getClientMimeType(),
                ]);

                $data['image'] = url('api/v1/images/' . $image->id);
            }
            else
            {
                $data['image'] = null;
            }
        }

        Item::create($data);
        return redirect()->intended('vendors/' . $vendorId . '/items');
    }

    public function update(Request $request, $vendorId, $itemId)
    {
        $data = $request->all();

        if ($request->hasFile('image'))
        {
            $file = $request->file('image');
            $name = time().rand(100,999).".".$file->getClientOriginalExtension();
            if($file->move('uploads/',$name))
            {
                $image = Image::create([
                    'filename' => $name,
                    'original' => $file->getClientOriginalName(),
                    'mime' => $file->getClientMimeType(),
                ]);

                $data['image'] = url('api/v1/images/' . $image->id);
            }
            else
            {
                $data['image'] = null;
            }
        }
        $item = Item::find($itemId);
        $item->fill($data);
        $item->save();

        return redirect()->intended('vendors/' . $vendorId . '/items');
    }

    public function destroy(Request $request, $vendorId, $itemId)
    {
        Item::destroy($itemId);
        return redirect()->intended('vendors/' . $vendorId . '/items');
    }

    public function restore(Request $request, $vendorId, $itemId)
    {
        Item::withTrashed()
            ->where('id', $itemId)
            ->restore();
        return redirect()->intended('vendors/' . $vendorId . '/items');
    }
}
