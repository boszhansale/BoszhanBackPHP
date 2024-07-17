<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\AuthRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {

        if (Auth::check()) {
            return match (Auth::user()->role->name) {
                'admin' => to_route('admin.main'),
                'operator' => to_route('admin.main'),
                'cashier' => to_route('cashier.main'),
                'supervisor' => to_route('supervisor.main'),
                'logist' => to_route('logist.user.drivers'),
                default => view('login')->withErrors('нет доступа')
            };
        }

        return view('login');
    }

    public function auth(AuthRequest $request)
    {
        $user = User::whereLogin($request->get('login'))->first();

        if (!Hash::check($request->get('password'), $user->password)) {
            return back()->withErrors('Неправильный пароль');
        }
        Auth::login($user, 1);
        return match ($user->role->name) {
            'admin' => to_route('admin.main'),
            'operator' => to_route('admin.main'),
            'cashier' => to_route('cashier.main'),
            'supervisor' => to_route('supervisor.main'),
            'logist' => to_route('logist.user.drivers'),
            'accountant' => to_route('admin.main'),
            default => to_route('login'),
        };
    }

    public function logout()
    {
        Auth::logout();

        return to_route('login');
    }
}
