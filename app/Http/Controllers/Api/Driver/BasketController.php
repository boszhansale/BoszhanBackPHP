<?php

namespace App\Http\Controllers\Api\Driver;

use App\Actions\BasketCreateAction;
use App\Actions\BasketUpdateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\BasketStoreRequest;
use App\Http\Requests\Api\BasketUpdateRequest;
use App\Http\Requests\Api\OrderUpdateRequest;
use App\Models\Basket;
use App\Models\Order;
use App\Models\OrderComment;
use App\Models\PriceType;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BasketController extends Controller
{
    function index(Order $order):JsonResponse
    {
        return response()->json($order->baskets()->with('product')->get());
    }
    function update(BasketUpdateRequest $request,Basket $basket)
    {
        $basket->update($request->validated());

        return response()->json($basket);
    }
    function delete(Basket $basket)
    {
        $basket->delete();
        return response()->json(['message' => 'Удалено']);
    }

}
