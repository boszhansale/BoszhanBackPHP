<?php

namespace App\Http\Controllers\Api\Salesrep;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\OrderStoreRequest;
use App\Http\Requests\Api\StoreStoreRequest;
use App\Http\Requests\Api\StoreUpdateRequest;
use App\Models\Counteragent;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CounteragentController extends Controller

{
    function index()
    {
        return response()->json(Auth::user()->counteragents()->with('priceType')->get());
    }

}
