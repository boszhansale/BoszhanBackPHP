<?php

namespace App\Actions;

use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OldDbOrderUpdateAction
{
    public function execute(Order $order)
    {
        $oldOrder = DB::connection('old')->table('orders')
            ->whereMobileId($order->mobile_id)
            ->first();
        if (! $oldOrder) {
            return;
        }

        $baskets = [];
        foreach ($order->baskets as $k => $basket) {
            $item['name'] = $basket->product->name;
            $item['type'] = $basket->type;
            $item['count'] = $basket->count;
            if ($basket->product->images()->exists()) {
                $item['image'] = $basket->product->images[0]->path;
            }
            $item['price'] = $basket->price;
            $item['article'] = (int) $basket->product->article;
            $item['all_price'] = $basket->all_price;
            $item['measure_id'] = $basket->product->measure;
            $item['product_id'] = $basket->product_id;
            $baskets[$k] = $item;
        }

        DB::connection('old')
            ->table('orders')
            ->where('orders.id', $order->id)
            ->update(
                [
                    'basket' => json_encode($baskets),
                ]
            );
    }
}
