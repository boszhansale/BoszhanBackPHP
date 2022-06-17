<?php

namespace App\Actions;

use App\Models\Basket;
use App\Models\Order;
use App\Models\PriceType;
use App\Models\Product;
use App\Models\ProductPriceType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BasketUpdateAction
{

    function execute($data,Order $order)
    {
        foreach ($data as $value) {

            $product = Product::find($value['product_id']);
            if (!$product) continue;


            $value['all_price'] = $value['count'] * $value['price'];

        }

        $order->baskets()->createMany($baskets);

        return $baskets;
    }



}
