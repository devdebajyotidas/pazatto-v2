<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Notifications\Notify;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {

    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $data = $request->all();

    }

    public function show($id)
    {

    }

    public function update(Request $request, $id)
    {

    }

    public function delete(Request $request, $id)
    {

    }

    public function login(Request $request)
    {

        $response = [];

        if($request->get('email'))
        {
            if($request->get('password') && Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')], true))
            {
                session()->regenerateToken();

                $response['login'] = true;
                $response['_token'] = csrf_token();
                Auth::user()->fcm_token = $request->get('fcm_token');
                Auth::user()->save();
            }
            else
            {
                $response['login'] = false;
            }

            return $response;
        }

        $mobile = $request->get('mobile');
        $user = User::where('mobile',$mobile)->first();

        if($user)
        {
            $fcmToken = $request->get('fcm_token');
            $expoToken = $request->get('expo_token');

            if($expoToken) {
                $user->expo_token = $expoToken;
            }
            if($fcmToken) {
                $user->fcm_token = $fcmToken;
            }
            $user->save();

            $response['success'] = true;
            $response['account'] = $user->account;
        }else
        {
            $response['success'] = false;
            $response['account'] = null;
        }

        $response['otp'] = Notify::sendOTP($mobile);

        return response()->json($response,Response::HTTP_OK);
    }
}
