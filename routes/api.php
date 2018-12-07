<?php

use App\Models\Customer;
use App\Models\Group;
use App\Models\Vendor;
use App\Notifications\Notify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'v1'], function(){

    Route::get('notify', function () {
        $customer = Vendor::find(1);
        $data['notification'] = [
            'tag' => 'NOTIFY',
            'title' => 'Title',
            'content' => 'body',
            'data' => [
                'title' => 'Titlex',
                'body' => 'bodyx',
            ]
        ];

        if(!empty($customer->user->fcm_token)) {
            $data['fcm_token'] = $customer->user->fcm_token;
            $notify[] = Notify::sendPushNotification($data);
        }

        if(!empty($customer->user->expo_token)) {
            echo 'sent';
            $data['expo_token'] = $customer->user->expo_token;
            try {
                print_r(Notify::sendExpoPushNotification($data, $customer->user->id));
            } catch (\Exception $exception) {
                print_r('Expo error details: ' . $exception->getMessage() );
                print_r('Expo error details: ' . $exception->getTraceAsString() );
            }

        }
    });

    Route::get('config', function (){

        $config = '{
          "payment_methods": {
            "net_banking": false,
            "bhim": true,
            "card": true,
            "phonepe": true,
            "paytm": true,
            "cod": true
          },
          "support": {
            "whatsapp": "",
            "phone": "9739275673",
            "email": ""
          },
          "release": {
            "ios": {
              "store_url": "https://www.apple.com/in/ios/app-store/",
              "maintenance_mode": false,
              "version": "1.27.02"
            },
            "android": {
              "store_url": "https://play.google.com/store/apps/details?id=com.pazatto.app",
              "maintenance_mode": false,
              "version": "1.27.02"
            } 
          }
        }';
        return response()->json(json_decode($config));
    });

    Route::any('timestamp',function (){
        return \Carbon\Carbon::now();
    });

    Route::get('test',function (){
        return \App\Notifications\Notify::sendOTP('8961678211');
    });


    Route::post('otp',function (){
        return \App\Notifications\Notify::sendOTP(\request()->get('mobile'));
    });

    Route::post('generate-checksum', function ( Request $request){

        $data = $request->all();

        $paytm = new \App\Paytm\Paytm;
        return $paytm->generateChecksum($data);
    });

    Route::post('verify-checksum', function ( Request $request){

        $data = $request->all();

        $paytm = new \App\Paytm\Paytm;
        return $paytm->verifyChecksum($data);
    });

    Route::post('txnstatus', function ( Request $request){

        $data = $request->all();

        $paytm = new \App\Paytm\Paytm;
        return $paytm->getTxnStatus($data);
    });

    Route::get('groups',function (Request $request) {
        $groups = Group::with(['vendors' => function($query){
//                return $query->orderBy('priority', 'ASC');
            return $query->orderByRaw('ISNULL(priority), priority ASC')->orderBy('created_at', 'DESC');
        }])->get();

        $coordinates = $request->get('filters');

        if(!isset($coordinates))
            return $groups;

        $customerCoordinate = formatLatLng($coordinates['coordinate']);

        $restaurants = [];

        foreach ($groups as $index => $service){
            $vendors = $service->vendors;

            $filtered = $vendors->filter(function ($restaurant, $key) use ($customerCoordinate, $coordinates) {
                $range = 0;
//                if (isset($restaurant->paid_delivery_range) && $restaurant->paid_delivery_range > 0)
//                    $range = $restaurant->paid_delivery_range;
//                else
                $range = $restaurant->free_delivery_range;

                Log::debug('vendor: ' . $restaurant->toJSON() );
                Log::debug('free range: ' . $restaurant->free_delivery_range . ',paid range: '. $restaurant->paid_delivery_range );
//            return $range;

                $restaurantCoordinate = $restaurant->locations[0];
//                dd($restaurantCoordinate);
                $restaurantCoordinate = ['lat' => $restaurantCoordinate->latitude, 'lng' => $restaurantCoordinate->longitude];
                $distance = calculateDistance($restaurantCoordinate, $customerCoordinate);

                Log::debug('coordinates: ' . $coordinates['coordinate'] );
                Log::debug('distance: ' . $distance . ', range: '. $range );

                $flag = true;
                if (doubleval($distance) > doubleval($range)) {
                    Log::debug('out of range');
                    $flag = false;
//                    unset($restaurant);
//                    unset($services[$index]->vendors[$key]);
//                    $services[$index]->vendors->forget($key);
//                    $services[$index]->vendors = collect($services[$index]->vendors->toArray());
                } else {
                    $flag = true;
                    Log::debug('within range');
                }
                return $flag;
            });

            // Filter out vendors closed for the day
//            $filtered = $filtered->filter(function ($restaurant, $key) {
//                return  $restaurant->is_open_now;
//            });

            $restaurants[$index]['id'] = $service->id;
            $restaurants[$index]['name'] = $service->name;
            $restaurants[$index]['vendors'] = array_values($filtered->all());
        }
        return $restaurants;
    });

    Route::get('vendors',function (Request $request) {
//        return $request->all();
//        session(['coordinates' => '112,1234']);

//        $services = \App\Models\Service::with(['vendors' => function ($query) {
//            $query->select('id', 'service_id', 'name', 'featured_image', 'min_order', 'average_delivery_time', 'is_taking_orders', 'highlights', 'category', 'average_cost', 'customer_commission', 'free_delivery_range', 'paid_delivery_range');
//        }])->get();

        $services = \App\Models\Service::with(['vendors' => function($query){
//                return $query->orderBy('priority', 'ASC');
                return $query->orderByRaw('ISNULL(priority), priority ASC')->orderBy('created_at', 'DESC');
        }])->get();

//        return $services;

        $coordinates = $request->get('filters');

        if(!isset($coordinates))
            return $services;

        $customerCoordinate = formatLatLng($coordinates['coordinate']);

        $restaurants = [];

        foreach ($services as $index => $service){
            $vendors = $service->vendors;

            $filtered = $vendors->filter(function ($restaurant, $key) use ($customerCoordinate, $coordinates) {
                $range = 0;
//                if (isset($restaurant->paid_delivery_range) && $restaurant->paid_delivery_range > 0)
//                    $range = $restaurant->paid_delivery_range;
//                else
                    $range = $restaurant->free_delivery_range;

                Log::debug('vendor: ' . $restaurant->toJSON() );
                Log::debug('free range: ' . $restaurant->free_delivery_range . ',paid range: '. $restaurant->paid_delivery_range );
//            return $range;

                $restaurantCoordinate = $restaurant->locations[0];
//                dd($restaurantCoordinate);
                $restaurantCoordinate = ['lat' => $restaurantCoordinate->latitude, 'lng' => $restaurantCoordinate->longitude];
                $distance = calculateDistance($restaurantCoordinate, $customerCoordinate);

                Log::debug('coordinates: ' . $coordinates['coordinate'] );
                Log::debug('distance: ' . $distance . ', range: '. $range );

                $flag = true;
                if (doubleval($distance) > doubleval($range)) {
                    Log::debug('out of range');
                    $flag = false;
//                    unset($restaurant);
//                    unset($services[$index]->vendors[$key]);
//                    $services[$index]->vendors->forget($key);
//                    $services[$index]->vendors = collect($services[$index]->vendors->toArray());
                } else {
                    $flag = true;
                    Log::debug('within range');
                }
                return $flag;
            });

            // Filter out vendors closed for the day
//            $filtered = $filtered->filter(function ($restaurant, $key) {
//                return  $restaurant->is_open_now;
//            });

            $restaurants[$index]['id'] = $service->id;
            $restaurants[$index]['name'] = $service->name;
            $restaurants[$index]['vendors'] = array_values($filtered->all());
         }
         return $restaurants;
        return $services;
        return \App\Models\Vendor::all(['id','name','featured_image','min_order','average_delivery_time']);
    });

    Route::get('vendors/{id}',function ($id){
        $v = \App\Models\Vendor::find($id);
        return $v->load(['menu']);
    });

    Route::put('vendors/{id}', 'VendorController@update');

    Route::resource('orders', 'OrderController');
    Route::resource('customers.orders', 'CustomerOrderController');
    Route::resource('customers.addresses', 'CustomerAddressController');
    Route::resource('users', 'UserController');
    Route::resource('customers', 'CustomerController');
    Route::post('login', 'UserController@login');

//    Route::resource('discounts', 'DiscountController');
    Route::get('discounts', function (){
        return \App\Models\Discount::all();
    });
//    Route::post('discounts/check','DiscountController@checkCoupon');
    Route::post('discounts/check','DiscountController@validateCoupon');

    Route::resource('images', 'ImageController');

    Route::get('testorders', 'TestOrderController@index');
    Route::post('testorders', 'TestOrderController@store');
    Route::put('testorders/{id}', 'TestOrderController@update');

    Route::get('customers/{customer}/testorders', 'TestOrderController@index');
    Route::post('customers/{customer}/testorders', 'TestOrderController@store');
    Route::put('customers/{customer}/testorders/{id}', 'TestOrderController@update');

    Route::get('vendors/{vendor}/testorders', 'TestOrderController@index');
    Route::post('vendors/{vendor}/testorders', 'TestOrderController@store');
    Route::put('vendors/{vendor}/testorders/{id}', 'TestOrderController@update');


    Route::get('vendors/{vendor}/orderdetails', 'VendorOrderDetails@index');
    Route::get('vendors/{vendor}/orderdetails/{date}', 'VendorOrderDetails@show');

    Route::get('vendors/{vendor}/order', 'VendorOrder@index');
    Route::put('vendors/{id}/order', 'VendorOrder@update');
    Route::delete('vendors/{id}/order', 'VendorOrder@destroy');

    Route::put('vendors/{itemId}/item/', 'VendorItems@update');

    Route::post('vendors/item', 'VendorItems@store');

    Route::get('vendors/{vendorId}/dashboard', 'VendorDashboard@index');

    Route::put('vendors/{id}/take_orders', 'VendorOrder@takeOrders');

//    Route::post('loginVendor', 'VendorDashboard@showLoginForm');
    Route::post('loginVendor', 'VendorDashboard@login');


    Route::post('vendors/Category', 'VendorCategory@store');
    Route::put('vendors/{id}/Category', 'VendorCategory@update');


//    Route::resource('testorders', 'TestOrderController');
//    Route::resource('customers.testorders', 'TestOrderController');
//    Route::resource('vendors.testorders', 'TestOrderController');
});

 function calculateDistance($point1, $point2, $unit = 'km', $decimals = 2) {

    // Calculate the distance in degrees
    $degrees = rad2deg(acos((sin(deg2rad($point1['lat']))*sin(deg2rad($point2['lat']))) + (cos(deg2rad($point1['lat']))*cos(deg2rad($point2['lat']))*cos(deg2rad($point1['lng']-$point2['lng'])))));

    // Convert the distance in degrees to the chosen unit (kilometres, miles or nautical miles)
    switch($unit) {
        case 'km':
            $distance = $degrees * 111.13384; // 1 degree = 111.13384 km, based on the average diameter of the Earth (12,735 km)
            break;
        case 'mi':
            $distance = $degrees * 69.05482; // 1 degree = 69.05482 miles, based on the average diameter of the Earth (7,913.1 miles)
            break;
        case 'nmi':
            $distance =  $degrees * 59.97662; // 1 degree = 59.97662 nautic miles, based on the average diameter of the Earth (6,876.3 nautical miles)
    }
    return round($distance, $decimals);
}

 function formatLatLng($string)
{
    $parts = explode(',',$string);

    $point['lat'] = $parts[0];
    $point['lng'] = $parts[1];

    return $point;
}

