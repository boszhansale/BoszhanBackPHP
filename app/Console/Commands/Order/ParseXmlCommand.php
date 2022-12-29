<?php

namespace App\Console\Commands\Order;

use App\Actions\OrderPriceAction;
use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Str;

class ParseXmlCommand extends Command
{
    protected $signature = 'order:parse';

    protected $description = 'parse xml from ftp';

    public function handle()
    {
        $this->clear();

        $files = Storage::disk('ftp')->files('inbox');
        dump('all count ' . count($files));
        $date = Carbon::parse('2022-12-26')->format('Ymd');
//        $date = Carbon::now()->format('Ymd');
        $matches = preg_grep("/(ORDER_|RETANN)($date)([0-9]{2})([0-9]{2}).*/", $files);
        dump('parse count ' . count($matches));
        $success = [];
        foreach ($matches as $fileName) {


//            $fileName = 'ORDER_20221012153708_709C63EE-4A11-11ED-882E-F96288FE69E5.xml';
//            $fileName = 'RETANN_20221020111213_C23008B8-5035-11ED-882E-F98ADC1C8D75.xml';

            if (strpos($fileName, 'ORDER')) {
                $type = 0;
            } elseif (strpos($fileName, 'RETANN')) {
                $type = 1;
            } else {
//               dump('filename type error');
                continue;
            }

//            dump("scan $fileName" . ' time: ' . Carbon::now()->format('H:i:s'));


            $xmlFile = Storage::disk('ftp')->get($fileName);
            if (!$xmlFile) {
                dump('xml file not found');
                continue;
            }
            $objectData = simplexml_load_string($xmlFile);
            $jsonFormatData = json_encode($objectData);
            $data = json_decode($jsonFormatData, true);
            //salesrep_id = 192
            $store = Store::where('id_edi', $data['HEAD']['DELIVERYPLACE'])->first();
            if (!$store) {
                dump('store not found: ' . $data['HEAD']['DELIVERYPLACE']);
                continue;
            }
            $counteragent = $store->counteragent;
            if (!$counteragent) {
                dump('counteragent not found');
                continue;
            }
            $driver = $store->driver;
            if (!$driver) {
                dump('driver not found');
                continue;
            }
            $errorMessages = [];

            $order = Order::where('number', $data['NUMBER'])->first();
            if ($order) {
                $order->update(
                    [
                        'salesrep_id' => 192,
                        'driver_id' => $driver->id,
                        'store_id' => $store->id,
                        'delivery_date' => Carbon::parse($type == 0 ? $data['DELIVERYDATE'] : $data['RETURNDATE']),
                        'error_message' => [],
                        'payment_type_id' => $counteragent->payment_type_id,
                    ]);
                $order->baskets()->forceDelete();

            } else {
                $order = Order::create(
                    [
                        'salesrep_id' => 192,
                        'driver_id' => $driver->id,
                        'store_id' => $store->id,
                        'number' => $data['NUMBER'],
                        'delivery_date' => Carbon::parse($type == 0 ? $data['DELIVERYDATE'] : $data['RETURNDATE']),
                        'salesrep_mobile_app_version' => 1,
                        'mobile_id' => 'EDI_' . $date . '_' . Str::random(7),
                        'payment_type_id' => $counteragent->payment_type_id,
                    ]);
            }


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

            if (count($errorMessages) == 0) {
                $success[] = $fileName;
            }
        }

        dump('success count: ' . count($success));
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
            dump('product barcode not found: ' . $item['PRODUCT']);

            $errorMessage['barcode'] = $item['PRODUCT'];
            $errorMessage['name'] = $type == 0 ? $item['CHARACTERISTIC']['DESCRIPTION'] : $item['DESCRIPTION'];
            return $errorMessage;
        }


        if ($product) {

            if ($product->remainder == 0) {
                return null;
            }


            //        dump($item['PRODUCT']);
            $count = $type == 0 ? $item['ORDEREDQUANTITY'] : $item['RETURNQUANTITY'];
            $price = $type == 0 ? $item['PRICEWITHVAT'] : $item['PRICE'];
            $order->baskets()->create([
                'product_id' => $product->id,
                'count' => $count,
                'price' => $type == 0 ? $item['PRICEWITHVAT'] : $item['PRICE'],
                'all_price' => (int)$count * (int)$price,
                'type' => $type,
                'measure' => $product->measure
            ]);
        }
        return null;
    }

    public function clear()
    {
        $files = Storage::disk('ftp')->files('inbox');
        dump('all count ' . count($files));
//        $date = Carbon::parse('2022-11-30')->format('Ymd');
        $date = (int)Carbon::now()->subDays(7)->format('Ymd');
        foreach ($files as $fileName) {
            if (strpos($fileName, 'ORDER')) {
                $d = (int)substr($fileName, 12, 8);

                if ($d <= $date) {
//                    dump('delete: ' . $fileName);

                    Storage::disk('ftp')->delete($fileName);
                }

            } elseif (strpos($fileName, 'RETANN')) {
                $d = (int)substr($fileName, 13, 8);

                if ($d <= $date) {
//                    dump('delete: ' . $fileName);

                    Storage::disk('ftp')->delete($fileName);
                }
            } else {
                $d = (int)substr($fileName, 13, 8);

                if ($d <= $date) {
//                    dump('delete: ' . $fileName);

                    Storage::disk('ftp')->delete($fileName);
                }
            }
        }


    }

}
