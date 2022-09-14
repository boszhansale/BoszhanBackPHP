<?php

namespace App\Actions;

use App\Models\Order;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class OldDbOrderCreateAction
{
    public function execute(Order $order)
    {
        $oldOrder = DB::connection('old')->table('orders')
            ->whereMobileId($order->mobile_id)
            ->exists();
        if ($oldOrder) {
            $order->db_export = 1;
            $order->save();

            return;
        }

        //create Shop
        try {
            $store = DB::connection('old')->table('stores')
                ->where('id', $order->store->id)
                ->first();

            if (! $store) {
                DB::connection('old')->table('stores')->insert([
                    'id' => $order->store_id,
                    'seller_id' => $order->store->salesrep_id,
                    'address' => $order->store->address,
                    'phone' => $order->store->phone,
                    'name' => $order->store->name,
                    'bin' => $order->store->bin,
                    'longitude' => $order->store->lng,
                    'latitude' => $order->store->lat,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            } else {
                DB::connection('old')->table('stores')
                    ->where('id', $order->store->id)
                    ->update([
                        'bin' => $order->store->bin,
                    ]);
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
        try {
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

            DB::connection('old')->table('orders')->insert([
                'store_id' => $order->store_id,
                'user_id' => $order->salesrep_id,
                'basket' => json_encode($baskets),
                'address' => '{"latitude": "sad", "longitude": "sad", "delivery_time": "123"}',
                'mobile_id' => $order->mobile_id,
                'off_prices' => $order->store->counteragent()->exists() ? $order->store->counteragent->price_type_id : 1,
                'dogovor' => 0,
                'bin' => $order->store->counteragent()->exists() ? $order->store->counteragent->bin : null,
                'payment_type' => $order->payment_type_id,
                'delivery_time' => $order->delivery_date,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            DB::connection('old')->table('order_requests')
                ->where('mobile_id', $order->mobile_id)
                ->update(['is_processed' => true]);
        } catch (Exception $e) {
            dd($e->getMessage());
        }

        $order->db_export = 1;
        $order->save();
    }
}
