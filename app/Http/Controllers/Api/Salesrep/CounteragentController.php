<?php

namespace App\Http\Controllers\Api\Salesrep;

use App\Http\Controllers\Controller;
use App\Http\Resources\CounteragentResource;
use Illuminate\Support\Facades\Auth;

class CounteragentController extends Controller
{
    public function index()
    {
        $counteragents = Auth::user()->counteragents()->with(['priceType', 'paymentType'])->get();

        return response()->json(CounteragentResource::collection($counteragents));
    }
}
