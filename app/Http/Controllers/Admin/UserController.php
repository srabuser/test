<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


class UserController extends Controller
{
    public function index()
    {
        $data = User::all();
        return view('admin.user.index', compact('data'));
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        User::create($request->all());
        return to_route('admin.users.index')->with('success', 'تم اضافة المستخدم');
    }

    public function edit(User $user)
    {
        return view('admin.user.edit', compact('user'));
    }

    public function update(User $user, Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id),],
        ]);

        $user->update($request->all());
        return to_route('admin.users.edit',$user->id)->with('success', 'تعديل بيانات المستخدم');

    }

    public function updateStatus(Request $request, User $user)
    {

        $user->update([
            'status' => $request->status
        ]);

        return to_route('admin.users.index')->with('success', 'تم تغيير حالة المستخدم');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return to_route('admin.users.index')->with('success', 'تم حذف المستخدم');
    }
}
