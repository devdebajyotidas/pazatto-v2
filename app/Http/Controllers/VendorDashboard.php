<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Vendor;

class VendorDashboard extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($vendor_id)
    {
        
        

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

        // if(session('role') == "vendor")
        // {
            $activeOrders = $activeOrders->where('vendor_id', '=', $vendor_id);
            $ordersDelivered = $ordersDelivered->where('vendor_id', '=', $vendor_id);
            $ordersCancelled = $ordersCancelled->where('vendor_id', '=', $vendor_id);
        // }

        // if(session('role') == "agent")
        // {
        //     $activeOrders = $activeOrders->where('agent_id', '=', Auth::user()->account->id);
        //     $ordersDelivered = $ordersDelivered->where('agent_id', '=', Auth::user()->account->id);
        //     $ordersCancelled = $ordersCancelled->where('agent_id', '=', Auth::user()->account->id);
        // }

        $data['activeOrders'] = $activeOrders->count();
        $data['ordersDelivered'] = $ordersDelivered->count();
        $data['ordersCancelled'] = $ordersCancelled->count();
      $data['ordersSales'] = 0; //$sales->get();

      $vendor = Vendor::find($vendor_id);
      $data['is_taking_orders'] = $vendor->is_taking_orders;

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
    public function show($id)
    {
        
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

    public function showLoginForm(Request $request)
    {
        if($request->get('email') && $request->get('password') && Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')]))
        {
           $user = Auth::user();

            if(isset($user->account) && $user->account->trashed()){
//            Auth::logout();
            return "false";//redirect()->intended('restricted');
                }else{

                    if($request->get('fcm_token'))
                    {
                        $user->fcm_token = $request->get('fcm_token');
                        $user->save();
                    }

                    if ($user->hasRole('admin')) {
                        session(['role' => 'admin' ]);
                    } else if ($user->hasRole('vendor')) {
                        session(['role' => 'vendor' ]);
                    } else if ($user->hasRole('customer')) {
                        session(['role' => 'customer' ]);
                    } else if ($user->hasRole('agent')) {
                        session(['role' => 'agent' ]);
        //                $this->redirectTo = '/orders';
                    }

                    return $user;
                }
        }
        //return $this->getLogin();
    }

    public function authenticated(Request $request, $user)
    {
        // Processing after authentication

        if(isset($user->account) && $user->account->trashed()){
//            Auth::logout();
            return "false";//redirect()->intended('restricted');
        }else{

            if($request->get('fcm_token'))
            {
                $user->fcm_token = $request->get('fcm_token');
                $user->save();
            }

            if ($user->hasRole('admin')) {
                session(['role' => 'admin' ]);
            } else if ($user->hasRole('vendor')) {
                session(['role' => 'vendor' ]);
            } else if ($user->hasRole('customer')) {
                session(['role' => 'customer' ]);
            } else if ($user->hasRole('agent')) {
                session(['role' => 'agent' ]);
//                $this->redirectTo = '/orders';
            }

            return $user;
        }
    }

    public function login(Request $request) {
        $response = [];
        if($request->get('password') && Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')], true))
        {
            Auth::user()->fcm_token = $request->get('fcm_token');
            Auth::user()->expo_token = $request->get('expo_token');
            Auth::user()->save();
            $user = Auth::user();
            $user->load('account');

            $response['success'] = true;
            $response['data'] = $user;
            $response['message'] = 'Login Successful';

        }
        else
        {
            $response['success'] = false;
            $response['data'] = null;
            $response['message'] = 'Invalid Credentials';
        }

        return $response;
    }
}
