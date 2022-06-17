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

class BasketCreateAction
{

    function execute(array $data,Order $order)
    {

        //Basket
        $store = $order->store;
        $counteragent = $store->counteragent;
        $priceType = $counteragent ? $counteragent->priceType: PriceType::find(1);

        $discount = $counteragent ? $counteragent->discount: 0;
        $discount = $discount == 0 ? $store->discount : $discount;

        $baskets = collect();
        foreach ($data as $value) {
            $product = Product::find($value['product_id']);
            if (!$product) continue;
            $productPriceType = $product->prices()->where('price_type_id',$priceType->id)->first();
            $discount = $discount == 0 ?  $product->discount : $discount;

            if (!$productPriceType) continue;
            if ($value['type'] == 1){
                $basket = Basket::join('orders','orders.id','baskets.order_id')
                    ->where('orders.salesrep_id',$order->salesrep_id)
                    ->where('baskets.type',0)
                    ->where('baskets.product_id',$product->id)
                    ->where('orders.store_id',$order->store_id)
                    ->latest('baskets.id')
                    ->first();

                if ($basket){
                    $value['price'] = $basket->price;
                }else {
                    $value['price'] = $this->discount($productPriceType->price,$discount);
                }
            }else{
                $discount = $discount == 0 ?  $product->discount : $discount;
                $value['price'] = $this->discount($productPriceType->price,$discount);
            }
            $value['all_price'] = $value['count'] * $value['price'];

            $baskets->add($value);
        }

        $order->baskets()->createMany($baskets);

        return $baskets;
    }

    protected function discount($price,$discount):float|int
    {
        $discountPrice = ( $price / 100) * $discount;
        return $price - $discountPrice;
    }

}
