<?php

namespace App\Actions;

use App\Models\Order;
use App\Models\Store;
use App\Models\User;
use Carbon\Carbon;

class OrderCreateAction
{
    public function execute(array $data, User $salesrep): Order
    {
        $store = Store::findOrFail($data['store_id']);
        if ($store->driver) {
            $driver = $store->driver;
        } else {
            $driver = $salesrep->driver;
        }

        $order = new Order();
        $order->salesrep_id = $salesrep->id;
        $order->driver_id = $driver->id;
        $order->delivery_date = $this->getDeliveryDate($data);
        $order->store_id = $data['store_id'];
        $order->mobile_id = $data['mobile_id'];
        $order->payment_type_id = $data['payment_type_id'] ?? null;
        $order->payment_full = $data['payment_full'] ?? null;
        $order->payment_partial = $data['payment_partial'] ?? null;
        $order->winning_name = $data['winning_name'] ?? null;
        $order->winning_phone = $data['winning_phone'] ?? null;
        $order->winning_status = $data['winning_status'] ?? null;
        $order->salesrep_mobile_app_version = $data['salesrep_mobile_app_version'] ?? 1.6;
        $order->save();

        return $order;
    }

    protected function getDeliveryDate($data): Carbon
    {
        if (isset($data['delivery_date'])) {
            return Carbon::parse($data['delivery_date']);
        }
        $date = Carbon::now();

        return match ($date->dayOfWeek) {
            5 => $date->addDays(3),
            6 => $date->addDays(2),
            default => Carbon::now()->addDay(),
        };
    }
}
