<?php

namespace App\Console\Commands\Order;

use App\Models\Product;
use App\Models\Store;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ParseXmlCommand extends Command
{
    protected $signature = 'order:parse';

    protected $description = 'parce xml';

    public function handle()
    {
        $fileName = 'ORDER_20221012153708_709C63EE-4A11-11ED-882E-F96288FE69E5.xml';
        $xmlFile = Storage::disk('public')->get($fileName);
        $objectData = simplexml_load_string($xmlFile);
        $jsonFormatData = json_encode($objectData);
        $data = json_decode($jsonFormatData, true);

        //salesrep_id = 192
        $store = Store::where('id_edi', $data['HEAD']['DELIVERYPLACE'])->first();
        if (!$store) {
            $this->error('store not found');
            return 0;
        }
        $counteragent = $store->counteragent;
        if (!$counteragent) {
            $this->error('counteragent not found');
            return 0;
        }
        $driver = $store->driver;
        if (!$driver) {
            $this->error('driver not found');
            return 0;
        }

//        $order = Order::create([
//            'salesrep_id' => 192,
//            'driver_id' => $driver->id,
//            'store_id' => $store->id,
//            'delivery_date' => Carbon::parse($data['HEAD']['DELIVERYDATE']),
//            'salesrep_mobile_app_version' => 1,
//            'mobile_id' => 'EDI_' . Str::random(9),
//            'payment_type_id' => $counteragent->payment_type_id,
//        ]);
        $this->info('product parse start');
        foreach ($data['HEAD']['POSITION'] as $item) {
            $product = Product::query()
                ->where('products.barcode', $item['PRODUCT'])
                ->first();
            if (!$product) {
                $product = Product::query()
                    ->join('product_barcodes', 'product_barcodes.product_id', 'products.id')
                    ->where('product_barcodes.barcode', $item['PRODUCT'])
                    ->groupBy('products.id')
                    ->select('products.*')
                    ->first();
            }

            if (!$product) {
                $this->error('product not found ' . $item['PRODUCT']);
                continue;
            }
            $this->info($item['CHARACTERISTIC']['DESCRIPTION']);
//            $order->baskets()->create([
//                'product_id' => $product->id,
//                'count' => $item['ORDEREDQUANTITY'],
//                'price' => $item['PRICEWITHVAT'],
//                'all_price' => $item['ORDEREDQUANTITY'] * $item['PRICEWITHVAT'],
//                'type' => 0,
//                'measure' => $product->measure
//            ]);
        }
    }
}
