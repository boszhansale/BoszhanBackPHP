<?php

namespace App\Console\Commands\Order;

use App\Actions\OrderPriceAction;
use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Str;

class ParseXmlCommand extends Command
{
    protected $signature = 'order:parse';

    protected $description = 'parse xml';

    public function handle()
    {
        try {
            $fileName = 'ORDER_20221012153708_709C63EE-4A11-11ED-882E-F96288FE69E5.xml';
            $fileName = 'RETANN_20221020111213_C23008B8-5035-11ED-882E-F98ADC1C8D75.xml';
            if ($fileName[0] == 'O') {
                $type = 0;
            } elseif ($fileName[0] == 'R') {
                $type = 1;
            } else {
                throw new Exception('filename type error');
            }
            $xmlFile = Storage::disk('public')->get($fileName);
            if (!$xmlFile) {
                throw new Exception('xml file not found');
            }
            $objectData = simplexml_load_string($xmlFile);
            $jsonFormatData = json_encode($objectData);
            $data = json_decode($jsonFormatData, true);

            //salesrep_id = 192
            $store = Store::where('id_edi', $data['HEAD']['DELIVERYPLACE'])->first();
            if (!$store) {
                throw  new Exception('store not found');
            }
            $counteragent = $store->counteragent;
            if (!$counteragent) {
                throw new Exception('counteragent not found');
            }
            $driver = $store->driver;
            if (!$driver) {
                throw new Exception('driver not found');
            }
            $errorMessages = [];

            $order = Order::create([
                'salesrep_id' => 192,
                'driver_id' => $driver->id,
                'store_id' => $store->id,
                'number' => $data['NUMBER'],
                'delivery_date' => Carbon::parse($type == 0 ? $data['DELIVERYDATE'] : $data['RETURNDATE']),
                'salesrep_mobile_app_version' => 1,
                'mobile_id' => 'EDI_' . Str::random(10),
                'payment_type_id' => $counteragent->payment_type_id,
            ]);

            if (isset($data['HEAD']['POSITION'][0])) {
                foreach ($data['HEAD']['POSITION'] as $item) {
                    $error = $this->createBasket($type, $order, $item);
                    if ($error) {
                        $errorMessages[] = $error;
                    }
                }
            } else {
                $error = $this->createBasket($type, $order, $data['HEAD']['POSITION']);
                if ($error) {
                    $errorMessages[] = $error;
                }
            }


            $order->update(['error_message' => $errorMessages]);

            OrderPriceAction::execute($order);
        } catch (\Throwable $exception) {
            $this->error($exception);
            return 0;
        }
    }

    public function createBasket(int $type, Order $order, array $item): array|null
    {
        //search barcode from table products
        $product = Product::query()
            ->where('products.barcode', $item['PRODUCT'])
            ->first();
        if (!$product) {
            //search barcode from table product_barcodes
            $product = Product::query()
                ->join('product_barcodes', 'product_barcodes.product_id', 'products.id')
                ->where('product_barcodes.barcode', $item['PRODUCT'])
                ->groupBy('products.id')
                ->select('products.*')
                ->first();
        }
        if (!$product) {
            $this->error($item['PRODUCT']);

            $errorMessage['barcode'] = $item['PRODUCT'];
            $errorMessage['name'] = $type == 0 ? $item['CHARACTERISTIC']['DESCRIPTION'] : $item['DESCRIPTION'];
            return $errorMessage;
        }
        $this->info($item['PRODUCT']);
        $count = $type == 0 ? $item['ORDEREDQUANTITY'] : $item['RETURNDQUANTITY'];
        $price = $type == 0 ? $item['PRICEWITHVAT'] : $item['PRICE'];
        $order->baskets()->create([
            'product_id' => $product->id,
            'count' => $count,
            'price' => $type == 0 ? $item['PRICEWITHVAT'] : $item['PRICE'],
            'all_price' => $count * $price,
            'type' => $type,
            'measure' => $product->measure
        ]);
        return null;
    }


}
