<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Model\User;
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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function apiLogin(Request $request)
    {
        try {
            $this->validate($request, [
                'username' => 'required|string',
                'password' => 'required|string',
            ]);
            $email = $request->input('username');
            $password = $request->input('password');

            $user = User::where('email', $email)->where('password', $password)->first();
            if ($user) {
                return apiSuccess($user);
            } else {
                return apiError('用户名或密码错误，请重新登录');
            }
        } catch (\Exception $e) {
            return apiError($e->getMessage());
        }
    }



}
