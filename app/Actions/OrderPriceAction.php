<?php

namespace App\Actions;

use App\Models\Order;

class OrderPriceAction
{
    public static function execute(Order $order): Order
    {
        $order->purchase_price = $order->baskets()->where('type', 0)->sum('all_price');
        $order->return_price = $order->baskets()->where('type', 1)->sum('all_price');
        $order->save();

        return $order;
    }
}
