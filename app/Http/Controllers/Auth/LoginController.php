<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers {
        showLoginForm as getLogin;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Override default username
     *
     * @return string
     */
//    public function username()
//    {
//        return 'mobile';
//    }

    public function authenticated(Request $request, $user)
    {
        // Processing after authentication

        if(isset($user->account) && $user->account->trashed()){
//            Auth::logout();
            return redirect()->intended('restricted');
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
                \auth()->logout();
                return redirect()->intended('restricted');
//                $this->redirectTo = '/orders';
            }
        }
    }

    public function unauthorized()
    {
        return view('errors.403');
    }

    public function showLoginForm(Request $request)
    {
        if($request->get('email') && $request->get('password') && Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')]))
        {
            $this->authenticated($request, Auth::user());
            return redirect()->intended($this->redirectTo);
        }
        return $this->getLogin();
    }
}
