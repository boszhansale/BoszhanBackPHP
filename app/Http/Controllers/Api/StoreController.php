<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    function index(Request $request): JsonResponse
    {
       $stores = Store::with(['salesrep','counteragent'])->get();
        return  response()->json($stores);
    }


}
