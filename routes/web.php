<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


use App\Notifications\Notify;

//use Illuminate\Routing\Route;
date_default_timezone_set("Asia/Kolkata");

Route::get('phpinfo', function (){
    phpinfo();
});

Auth::routes();
Route::get('logout', 'Auth\LoginController@logout');

//Route::get('vendorlogin', 'Auth\LoginController@vendorLogin');
Route::get('vendorlogin', function (\Illuminate\Http\Request $request){

//        return ($request->all());
        $data = $request->all();

        if(\Illuminate\Support\Facades\Auth::attempt(['mobile' => $request->get('mobile'), 'password' => $request->get('password')], true))
        {
            $user = \Illuminate\Support\Facades\Auth::user();
//            session(['role' => 'vendor']);
            if ($user->hasRole('agent')) {
                session(['role' => 'agent' ]);
            } else if ($user->hasRole('vendor')) {
                session(['role' => 'vendor']);
            }
            return redirect()->intended('/dashboard');
        }
        else
        {
            return $this->unauthorized();
        }

});

Route::group(['middleware' => 'auth:web'], function (){
    Route::get('/home', function (){
        return redirect('/dashboard');
    });
    Route::get('dashboard', 'DashboardController@index');


    Route::resource('vendors', 'VendorController');

//Route::resource('items', 'ItemController');
    Route::resource('vendors.items', 'ItemController');
    Route::put('vendors/{vendorId}/items/{itemId}/restore', 'ItemController@restore');
    Route::put('vendors/{id}/take-orders', 'VendorController@takeOrders');

    Route::resource('categories', 'ItemCategoryController');
    Route::resource('images', 'ImageController');
    Route::resource('orders', 'OrderController');
    Route::resource('services', 'ServiceController');
    Route::resource('customers', 'CustomerController');
    Route::resource('cuisines', 'CuisineController');

    Route::get('reports', 'ReportController@index');
    Route::get('reports/details', 'ReportController@details');

    Route::resource('discounts', 'DiscountController');
//    Route::resource('members', 'MemberController');
    Route::resource('agents', 'AgentController');
    Route::resource('settings', 'SettingController');

    Route::post('notifications/customers', 'NotificationController@customers');
    Route::post('notifications/vendors', 'NotificationController@vendors');
    Route::post('notifications/agents', 'NotificationController@agents');
});

Route::get('/mail', function (){

    $title = 'some title';
    $content = 'some content';

    return \Illuminate\Support\Facades\Mail::send('emails.test', ['title' => $title, 'content' => $content], function ($message)
    {

        $message->from('no-reply@gmail.com', 'Dev Das');

        $message->to('info.debajyotidas@gmail.com');

    });

//    Mail::to('info.debajyotidas@gmail.com')
//        ->from('no-reply@gmail.com', 'Dev Das')
//        ->cc('dev.debajyotidas@gmail.com')
//        ->bcc('debajyotidas93@gmail.com')
//        ->send('emails.invoice', ['title' => $title, 'content' => $content]);

});

Route::get('/sales', function () {
    Notify::sendSalesReport(3, '2018-09-05');
});

Route::get('/restricted', function (){
    return "You are unauthorized";
});

Route::get('policies', function (){
    $data['page'] = 'policies';
    $data['role'] = 'guest';
    return view('policies', $data);
});

Route::get('terms-and-conditions', function (){
    $data['page'] = 'policies';
    $data['role'] = 'guest';
    return view('terms-and-conditions', $data);
});

Route::get('refund-policy', function (){
    $data['page'] = 'policies';
    $data['role'] = 'guest';
    return view('refund-cancellation', $data);
});

Route::get('contact', function (){
    $data['page'] = 'policies';
    $data['role'] = 'guest';
    return view('contact', $data);
});

Route::get('about-us', function (){
    $data['page'] = 'policies';
    $data['role'] = 'guest';
    return view('contact', $data);
});

Route::get('/time', function() {
    return date('h:i');
});

Route::get('/paytm/process', function (){
    return view('paytm.transaction');
});

Route::post('/paytm/process', function (){
    return view('paytm.transaction');
});

Route::post('/paytm/callback', function (){
    return view('paytm.response');
});