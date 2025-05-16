<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function sendFailedLoginResponse(Request $request)
    {
        if ($request->input('login_failed_reason') === 'inactive') {
            return response()->json([
                'status' => 'isActive',
                'message' => 'الحساب غير مفعل'
            ], 403);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'بيانات الدخول غير صحيحة'
        ], 422);
    }

    protected function attemptLogin(Request $request)
    {
        $user = User::where($this->username(), $request->input($this->username()))->first();

        if ($user) {
            if ($user->status === 'inactive'){
            $request->merge(['login_failed_reason' => 'inactive']);
            return false;

            }
        }

        return $this->guard()->attempt(
            $this->credentials($request), $request->boolean('remember')
        );
    }
}
