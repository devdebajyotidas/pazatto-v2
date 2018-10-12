<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $data['page'] = 'customers';
        $data['role'] = session('role');
        $data['prefix']  = session('role');

        $data['customers'] = Customer::with(['user'])->orderBy('id', "DESC")->get();

        if($request->wantsJson() ||  $request->ajax())
            return response()->json([ 'data' => $data['customers']]);
        else
            return view('customers.index', $data);
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $response = [];
        try
        {
            $data['customer'] = $request->except('user');
            $data['user'] = $request->get('user');

            $customerValidator = Validator::make($data['customer'], Customer::$rules);
            $userValidator = Validator::make($data['user'], User::$rules);

            if ($customerValidator->passes() && $userValidator->passes())
            {
                $customer = Customer::create($data['customer']);
                $user = User::make($data['user']);
                $customer->user()->save($user);
                $customer->load('user');

                $response['success'] = true;
                $response['account'] = $customer->load('addresses');
                $response['error'] = '';
            }
            else
            {
                $errors = implode(',',call_user_func_array('array_merge', array_values(json_decode($customerValidator->errors()->merge($userValidator->errors()),true))));
                $response['success'] = false;
                $response['account'] = null;
                $response['error'] = $errors;
            }

            return $response;

        }catch (\Exception $exception)
        {
            $response['success'] = false;
            $response['account'] = null;
            $response['error'] = $exception->getMessage();
            return $response;
        }
    }

    public function show($id)
    {

    }

    public function update(Request $request, $id)
    {
        $response = [];
        try
        {
            $customer = Customer::find($id);
            $customer->fill($request->all());
            if($customer->save())
            {
                $response['success'] = true;
                $response['account'] = $customer->load('user');
                $response['error'] = '';
            }
            else
            {
                $response['success'] = false;
                $response['account'] = null;
                $response['error'] = '';
            }

            return $response;

        }
        catch (\Exception $exception)
        {
            $response['success'] = false;
            $response['account'] = null;
            $response['error'] = $exception->getMessage();
            
            return $response;
        }

    }

    public function delete(Request $request, $id)
    {

    }
}
