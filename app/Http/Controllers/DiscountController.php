<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use function count;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Vendor;
use function intval;
use function json_encode;
use function route;
use function strtoupper;

class DiscountController extends Controller
{
//    private $coupons = [
//        'PZTFLAT75' => [
//            'service' => 'Restaurant',
//            'amount' => 75
//        ],
//        'PZTFREEWATER' => [
//            'service' => 'Water Supply',
//            'amount' => 75
//        ]
//    ];

    private $coupons = [
        'PZTFLAT75',
        'PZTFREEWATER',
        'PAZATTO10',
        'PZT50',
        'PZT75',
        'MEGHA100',
        'ESWAR50',
        'JAY22',
        'YASH50'
    ];

    public function __construct()
    {
//        $this->middleware('auth')->except('checkCoupon');
    }

    public function index(Request $request)
    {
        $data['page'] = 'discount';
        $data['role'] = session('role');
        $data['prefix']  = session('role');

//        $discounts = Discount::all(['id','code','title','description','featured_image','vendor_id','type']);
        $data['discounts'] = Discount::all();
        if($request->ajax() || $request->wantsJson())
        {
            return $data['discounts'];
        }
        else
        {
            return view('discounts.index', $data);
        }
    }

    public function create()
    {
        $data['page'] = 'dashboard';
        $data['role'] = session('role');
        $data['prefix']  = session('role');

        return view('discounts.create', $data);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $discount = Discount::create($data);
        dd($discount);
    }

    public function show($id)
    {
        $data['page'] = 'dashboard';
        $data['role'] = session('role');
        $data['prefix']  = session('role');

        $data['discount'] = Discount::find($id);

        return view('discounts.create', $data);
    }

    public function checkCoupon(Request $request)
    {
        $respoonse = [];
        $firstFoodOrder = true;
        $firstWaterOrder = true;

        $data = $request->all();

        $coupon = $data['discount_code'];

        if(!in_array(strtoupper($coupon), $this->coupons))
        {
            $respoonse['is_valid'] = 0;
            $respoonse['discounted_amount'] = 0;
            $respoonse['message'] = "Invalid coupon";
        }
        else
        {
            $orders = Order::where('customer_id','=',$data['customer_id'])
//            ->orWhere('device_id','',$data['device_id'])
            ->where('discount_code', '=', strtoupper($coupon))
            ->get();

            foreach ($orders as $key => $value) 
            {
                if(!isset($value->vendor))
                    continue;

                if($value->vendor->service->name == "Restaurant")
                {
                    $firstFoodOrder = false;   
                }

                if($value->vendor->service->name == "Water Supply")
                {
                    $firstWaterOrder = false;   
                }    
            }

        
            $vendor = Vendor::find($data['vendor_id']);

            if($firstFoodOrder && $vendor->service->name == 'Restaurant' && intval($data['sub_total']) >= 499)
            {
                $respoonse['is_valid'] = 1;
                $respoonse['discounted_amount'] = 75;
                $respoonse['message'] = "Coupon applied";

            }
//            else if($firstWaterOrder && $vendor->service->name == 'Water Supply')
            else if(count($orders) < 3 && $vendor->service->name == 'Water Supply')
            {
                $respoonse['is_valid'] = 1;
                $respoonse['discounted_amount'] = 10;
                $additionalDiscount = 0;

//                $totalItems = count($data['items']);
//
//                if($totalItems>1)
//                {
//                    $additionalDiscount = (($totalItems-1) > 5) ? 6*5 : ($totalItems-1)*5;
//                }

                $respoonse['discounted_amount'] += $additionalDiscount;
                $respoonse['message'] = "Coupon applied";
            }
            else
            {
                $respoonse['is_valid'] = 0;
                $respoonse['discounted_amount'] = 0;
                $respoonse['message'] = "You are not eligible for this offer";
            }
        

        }
        
        
        // if($respoonse['is_valid'])
        // {
        //     $respoonse['message'] = "Coupon applied";
        //     $respoonse['discounted_amount'] = [100,20,75,34,50][rand(0,4)];
        // }else{
        //     $respoonse['discounted_amount'] = 0;
        //     $respoonse['message'] = "Invalid coupon";
        // }

        return response()->json($respoonse);
    }

    public function validateCoupon(Request $request)
    {
        $respoonse = [];
        $firstFoodOrder = true;
        $firstWaterOrder = true;

        $data = $request->all();

        $coupon = strtoupper($data['discount_code']);


        $orders = Order::where('customer_id','=',$data['customer_id'])
//            ->orWhere('device_id','',$data['device_id'])
            ->where('discount_code', '=', strtoupper($coupon))
            ->get();

//        return json_encode(['count' => count($orders)]);


        if(!in_array(strtoupper($coupon), $this->coupons))
        {
            $respoonse['is_valid'] = 0;
            $respoonse['discounted_amount'] = 0;
            $respoonse['message'] = "Invalid coupon";

            return $respoonse;
        }
        else if(count($orders) >= 3)
        {
            $respoonse['is_valid'] = 0;
            $respoonse['use_count'] = count($orders);
            $respoonse['discounted_amount'] = 0;
            $respoonse['message'] = "You have already used this coupon 3 times";

            return $respoonse;
        }
        else if( $coupon == 'PZT50' && intval($data['sub_total']) >= 299)
        {
            $respoonse['is_valid'] = 1;
            $respoonse['discounted_amount'] = 50;
            $respoonse['message'] = "Coupon applied";

            return $respoonse;

        }
        else if( $coupon == 'PZT75' && intval($data['sub_total']) >= 499)
        {
            $respoonse['is_valid'] = 1;
            $respoonse['discounted_amount'] = 75;
            $respoonse['message'] = "Coupon applied";

            return $respoonse;
        }
        else if($coupon == "MEGHA100" &&  intval($data['customer_id']) == 324 && count($orders) == 0 && intval($data['sub_total']) >= 100)
        {
            $respoonse['is_valid'] = 1;
            $respoonse['discounted_amount'] = 100;
            $respoonse['message'] = "Coupon applied";

            return $respoonse;
        }
        else if($coupon == "ESWAR50" &&  intval($data['customer_id']) == 248 && count($orders) == 0 && intval($data['sub_total']) >= 100)
        {
            $respoonse['is_valid'] = 1;
            $respoonse['discounted_amount'] = 50;
            $respoonse['message'] = "Coupon applied";

            return $respoonse;
        }
        else if($coupon == "YASH50" &&  intval($data['customer_id']) == 538 && count($orders) == 0 && intval($data['sub_total']) >= 100)
        {
            $respoonse['is_valid'] = 1;
            $respoonse['discounted_amount'] = 50;
            $respoonse['message'] = "Coupon applied";

            return $respoonse;
        }
        else if($coupon == "JAY22" &&  intval($data['customer_id']) == 195 && count($orders) == 0 && intval($data['sub_total']) >= 100)
        {
            $respoonse['is_valid'] = 1;
            $respoonse['discounted_amount'] = 100;
            $respoonse['message'] = "Coupon applied";

            return $respoonse;
        }
        else
        {
            $respoonse['is_valid'] = 0;
            $respoonse['discounted_amount'] = 0;
            $respoonse['message'] = "You are not eligible for this offer";

            return $respoonse;
        }
    }
}
