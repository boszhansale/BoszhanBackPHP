<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class OtherCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'other:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'TESTING';

    /**
     * Execute the console command.
     *
     * @return int
     */

    public function handle()
    {

        $array = [
            ['product_id' => 2216, 'action_id' => 2707],
            ['product_id' => 2212, 'action_id' => 2708],
            ['product_id' => 798, 'action_id' => 2709],
        ];

        foreach ($array as $item) {
            $basketProduct = \App\Models\Basket::query()
                ->where('product_id', $item['action_id'])
                ->whereDate('created_at', '>=', now()->subDays(3))
                ->delete();
        }


//        $productId = 2212;
//        $actionProductId = 2708;

//        $productId = 798;
//        $actionProductId = 2709;

//        $productId = 2216;
//        $actionProductId = 2707;
//        $array = [
//            ['product_id' => 2216, 'action_id' => 2707],
//            ['product_id' => 2212, 'action_id' => 2708],
//            ['product_id' => 798, 'action_id' => 2709],
//        ];
//
//
//        foreach ($array as $item) {
//            $baskets = Basket::query()
//                ->where('product_id', $item['product_id'])
//                ->whereDate('created_at', now())
//                ->where('count', '>=', 5)
//                ->get();
//            foreach ($baskets as $basket) {
//                try {
//                    if ($basket->type == 1) continue;
//
//                    $actionProduct = Basket::query()
//                        ->where('order_id', $basket->order_id)
//                        ->where('product_id', $item['action_id'])
//                        ->first();
//                    if ($actionProduct) continue;
//                    $count = floor($basket->count / 5);
//                    dump("basket_count $basket->count - $count");
//
//                    Basket::create([
//                        'order_id' => $basket->order_id,
//                        'product_id' => $item['action_id'],
//                        'price' => 1,
//                        'type' => 0,
//                        'comment' => 'Акция 5+1',
//                        'count' => $count,
//                        'all_price' => $count * 1,
//                    ]);
//                } catch (\Exception $exception) {
//                    dump($exception->getMessage());
//                }
//            }
//        }
        return 0;
    }

//    public function handle()
//    {
//        //SELECT * FROM baskets WHERE price IS NOT NULL AND price != ROUND(price);
//        $baskets = \App\Models\Basket::query()
//            ->whereNotNull('price')
//            ->whereRaw('price != ROUND(price)')
//            ->get();
//
//
//        foreach ($baskets as $basket) {
//
//            $order = $basket->order()->withTrashed()->first();
//            if (!$order) continue;
//            $store = $order->store;
//            if (!$store) continue;
//            $counteragent = $store->counteragent;
//
//            $priceType = $counteragent ? $counteragent->priceType : PriceType::find(1);
//
//            $discount = $counteragent ? $counteragent->discount : 0;
//            $discount = $discount == 0 ? $store->discount : $discount;
//
//            $product = Product::find($basket->product_id);
//            $productPriceType = $product->prices()->where('price_type_id', $priceType->id)->first();
//            $discount = $discount == 0 ? $product->discount : $discount;
//
//            if (!$productPriceType) {
//                continue;
//            }
//            //возврат
//            dump($this->discount($productPriceType->price, $discount));
//            if ($basket->type == 0) {
//                $basket->price = $this->discount($productPriceType->price, $discount);
//            }
//            $basket->all_price = $basket->price * $basket->count;
//            $basket->save();
//        }
//
////        $date = Carbon::parse('2023-12-04')->format('Y-m-d');
////
////        $orders = Order::query()
////            ->whereDate('delivery_date', $date)
////            ->whereNull('rider_id')
////            ->get();
////
////
////        foreach ($orders as $order) {
////            $riderDriver = RiderDriver::where('driver_id', $order->driver_id)->latest()->first();
////            if (!$riderDriver) continue;
////
////            $order->rider_id = $riderDriver->rider_id;
////            $order->save();
////        }
//
//
//        return 0;
//    }

    protected function discount($price, $discount): float|int
    {
        $discountPrice = ($price / 100) * $discount;

        return $price - $discountPrice;
    }
}
