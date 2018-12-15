<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Order;
use App\Models\OrderLine;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\Notify;
use function is_null;
use const null;
use function session;

class OrderController extends Controller
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

        $data['page'] = 'orders';
        $data['role'] = session('role');
        $data['prefix']  = session('role');

        $data['orders'] = Order::with(['lines','customer.user','vendor', 'agent'])->orderBy('id','desc')->limit(100)->get();
        $data['services'] = Service::withCount('orders')->get();
        $data['agents'] = Agent::all();
//        dd($data);

        if(session('role') == 'vendor')
        {
            $data['orders'] = Order::with(['lines','customer.user', 'agent'])->where('vendor_id', '=', Auth::user()->account->id)->orderBy('id','desc')->get();
        }

        if(session('role') == 'agent')
        {
            $vendors = auth()->user()->account->vendors()->pluck('vendor_id')->toArray();
            $data['orders'] = Order::with(['lines','customer.user', 'agent'])->whereIn('vendor_id', $vendors)
                ->whereNotIn('status',  [-1, 0, 1, 5])
                ->where(function($query){
                    $query->where('agent_id', '=', Auth::user()->account->id)
                        ->orWhere('agent_id', '=', null);
                })
                ->orderBy('id','desc')->get();
        }

        return view('orders.index', $data);
    }

    public function history(){
        if(session('role') != 'admin' && !isset(Auth::user()->account))
        {
            return redirect('/logout');
        }

        $data['page'] = 'orders';
        $data['role'] = session('role');
        $data['prefix']  = session('role');

        $data['orders'] = Order::with(['lines','customer.user','vendor', 'agent'])->orderBy('id','desc')->get();
        $data['services'] = Service::withCount('orders')->get();
//        dd($data);

        if(session('role') == 'vendor')
        {
            $data['orders'] = Order::with(['lines','customer.user', 'agent'])->where('vendor_id', '=', Auth::user()->account->id)->orderBy('id','desc')->get();
        }

        if(session('role') == 'agent')
        {
            $vendors = auth()->user()->account->vendors()->pluck('vendor_id')->toArray();
            $data['orders'] = Order::with(['lines','customer.user', 'agent'])->whereIn('vendor_id', $vendors)
                ->whereNotIn('status',  [-1, 0, 1, 5])
                ->where(function($query){
                    $query->where('agent_id', '=', Auth::user()->account->id)
                        ->orWhere('agent_id', '=', null);
                })
                ->orderBy('id','desc')->get();
        }

        return view('orders.history', $data);
    }

    public function create()
    {

    }

    public function store(Request $request)
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

        return $order->load('lines');
    }

    public function show($id)
    {

    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        $order = Order::find($id);

        if(!isset($data['customer_note']) || is_null($data['customer_note']))
            $data['customer_note'] = "";

        if(!isset($data['vendor_note']) || is_null($data['vendor_note']))
            $data['vendor_note'] = "";

        if(isset($data['agent_id']) && !is_null($order->agent_id) && session('role') != 'admin')
        {
            unset($data['agent_id']);
        }

        $order->fill($data);
        $order->save();

        Notify::sendOrderNotification($order);

        return redirect()->back();
    }

    public function delete(Request $request, $id)
    {

    }
}
