<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admins')->except('logout');
        $this->middleware('auth:admins')->only('logout');
    }

    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required','email'],
            'password' => ['required']
        ]);

        if (Auth::guard('admins')->attempt($request->only('email', 'password'))) {
            return to_route('admin.users.index');
        }
        return back()->withErrors(['email' => __('auth.failed')]);
    }

    public function logout(Request $request)
    {
        \auth()->guard('admins')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return to_route('admin.showLoginForm');
    }
}
