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
use Illuminate\Support\Facades\Redis;

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
            'user' => $user,
        ]);
    }

    public function login(LoginAuthRequest $request): JsonResponse
    {
        if (!Auth::attempt($request->only('login', 'password'))) {
            return response()->json([
                'message' => 'неверный пароль',
            ], 400);
        }

        $user = User::where('login', $request['login'])->firstOrFail();
        if ($request->has('device_token')) {
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

    public function logout(): JsonResponse
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


        try {
            $key = 'positions:' . Auth::id();
            if ($request->has('positions')) {
                foreach ($request->get('positions') as $item) {
                    Redis::rpush($key, json_encode([
                        'user_id' => Auth::id(),
                        'lat' => $item['lat'],
                        'lng' => $item['lng'],
                        'created_at' => $item['created_at']
                    ]));
                }
            } else {
                Redis::rpush($key, json_encode([
                    'lat' => $request->get('lat'),
                    'lng' => $request->get('lng'),
                    'user_id' => Auth::id(),
                    'created_at' => now()->format('Y-m-d H:m:s'),
                ]));
            }
            return response()->json(Auth::user());
        } catch (\Exception $exception) {
            return response()->json(Auth::user());
        }


//
//        if ($request->has('positions')) {
//            foreach ($request->get('positions') as $key => $item) {
//
//                $exists = Auth::user()->userPositions()
//                    ->whereDate('created_at', now())
//                    ->where('lat', $item['lat'])
//                    ->where('lng', $item['lng'])
//                    ->exists();
//
//                if (!$exists) {
//                    Auth::user()->userPositions()->create([
//                        'lat' => $item['lat'],
//                        'lng' => $item['lng'],
//                        'created_at' => Carbon::parse($item['created_at'])
//                    ]);
//                }
//
//                if ($key === array_key_last($request->get('positions'))) {
//                    Auth::user()->update([
//                        'lat' => $item['lat'],
//                        'lng' => $item['lng'],
//                    ]);
//                }
//            }
//        } else {
//            Auth::user()->update([
//                'lat' => $request->get('lat'),
//                'lng' => $request->get('lng'),
//            ]);
//
//
//            $exists = Auth::user()->userPositions()
//                ->whereDate('created_at', now())
//                ->where('lat', $request->get('lat'))
//                ->where('lng', $request->get('lng'))
//                ->exists();
//
//            if (!$exists) {
//                Auth::user()->userPositions()->create([
//                    'lat' => $request->get('lat'),
//                    'lng' => $request->get('lng'),
//                ]);
//            }
//
//        }

        return response()->json(Auth::user());
    }

    public function deviceToken(Request $request)
    {
        Auth::user()->update([
            'device_token' => $request->get('device_token'),
        ]);

        return response()->json(Auth::user());
    }
}
