<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginAuthRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    //test method
    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request->get('name'),
            'login' => $request->get('login'),
            'phone' => $request->get('phone'),
            'password' => Hash::make($request->get('password')),
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;



        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }
    public function login(LoginAuthRequest $request):JsonResponse
    {
        if (!Auth::attempt($request->only('login', 'password'))) {
            return response()->json([
                'message' => 'неверный пароль'
            ], 400);
        }

        $user = User::where('login', $request['login'])->firstOrFail();
        if ($request->has('device_token')){
            $user->device_token = $request->get('device_token');
            $user->save();
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => new UserResource($user),
        ]);
    }
    public function logout():JsonResponse
    {
        Auth::user()->tokens()->delete();

        return response()->json(['message' => 'вы вышли']);
    }
    public function profile()
    {

        return response()->json(new UserResource(Auth::user()));

    }
    public function position(Request $request)
    {
        Auth::user()->update([
            'lat' => $request->get('lat'),
            'lng' => $request->get('lng'),
        ]);

        return response()->json(Auth::user());
    }
}
