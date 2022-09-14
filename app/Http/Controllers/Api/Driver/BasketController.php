<?php

namespace App\Http\Controllers\Api\Driver;

use App\Actions\OrderPriceAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\BasketUpdateRequest;
use App\Models\Basket;
use App\Models\Order;
use Illuminate\Http\JsonResponse;

class BasketController extends Controller
{
    public function index(Order $order): JsonResponse
    {
        return response()->json($order->baskets()
            ->with('product')
            ->join('products', 'products.id', 'baskets.product_id')
            ->orderBy('products.measure', 'desc')
            ->select('baskets.*')
            ->get()
        );
    }

    public function initialState(Order $order): JsonResponse
    {
        foreach ($order->baskets as $basket) {
            $firstBasket = $basket->audits()->whereEvent('created')->first();
            if ($firstBasket) {
                $newValue = $firstBasket->new_values;
                if (isset($newValue['count']) and isset($newValue['all_price'])) {
                    $basket->count = $newValue['count'];
                    $basket->all_price = $newValue['all_price'];
                    $basket->save();
                }
            }
        }
        OrderPriceAction::execute($order);

        return response()->json(['message' => 'success']);
    }

    public function update(BasketUpdateRequest $request, Basket $basket)
    {
        $basket->count = $request->get('count');
        $basket->all_price = $basket->count * $basket->price;
        $basket->save();

        OrderPriceAction::execute($basket->order);

        return response()->json($basket);
    }

    public function delete(Basket $basket)
    {
        $basket->delete();

        return response()->json(['message' => 'Удалено']);
    }
}
