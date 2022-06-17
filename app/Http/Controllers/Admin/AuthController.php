<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    function login()
    {
        if (Auth::check()){
            if (Auth::user()->isAdmin() ){
                return to_route('admin.main');
            }
        }

        return view('admin.login');
    }

    function auth(AuthRequest $request)
    {

        $user = User::whereLogin($request->get('login'))->first();

        if (!Hash::check($request->get('password'),$user->password)){
            return  back()->withErrors('Неправильный пароль');
        }
        if (!$user->isAdmin()){
            return  back()->withErrors('У вас нет доступа');
        }

        Auth::login($user,$request->has('remember'));

        return to_route('admin.main');
    }

    function logout()
    {
        Auth::logout();
        return to_route('admin.login');
    }
}
