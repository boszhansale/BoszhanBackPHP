<?php

namespace App\Http\Controllers\Api\Salesrep;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\OrderStoreRequest;
use App\Http\Requests\Api\StoreStoreRequest;
use App\Http\Requests\Api\StoreUpdateRequest;
use App\Http\Resources\CounteragentResource;
use App\Models\Counteragent;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CounteragentController extends Controller

{
    function index()
    {
        $counteragents  = Auth::user()->counteragents()->with(['priceType','paymentType'])->get();
        return response()->json(CounteragentResource::collection($counteragents));
    }

}
