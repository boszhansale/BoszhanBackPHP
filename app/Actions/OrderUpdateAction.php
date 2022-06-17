<?php

namespace App\Actions;

use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class OrderUpdateAction
{

    function execute(array $data,Order $order) : Order
    {
        if (isset($data['salesrep_id'])){
            $order->salesrep_id = $data['salesrep_id'];
        }
        if (isset($data['driver_id'])){
            $order->driver_id = $data['driver_id'];
        }
        if (isset($data['delivery_date'])){
            $order->delivery_date = $data['delivery_date'];
        }
        if (isset($data['delivered_date'])){
            $order->delivered_date = $data['delivered_date'];
        }
        if (isset($data['rnk_generate'])){
            $order->rnk_generate = $data['rnk_generate'];
        }
        if (isset($data['store_id'])){
            $order->store_id = $data['store_id'];
        }
        if (isset($data['payment_type_id'])){
            $order->payment_type_id = $data['payment_type_id'];
        }
        if (isset($data['payment_status_id'])){
            $order->payment_status_id = $data['payment_status_id'];
        }
        if (isset($data['payment_full'])){
            $order->payment_full = $data['payment_full'];
        }
        if (isset($data['payment_partial'])){
            $order->payment_partial = $data['payment_partial'];
        }
        if (isset($data['winning_name'])){
            $order->winning_name = $data['winning_name'];
        }
        if (isset($data['winning_phone'])){
            $order->winning_phone = $data['winning_phone'];
        }

        if (isset($data['winning_status'])){
            $order->winning_status = $data['winning_status'];
        }
        if (isset($data['status_id'])){
            $order->status_id = $data['status_id'];
        }
        $order->save();

        return OrderPriceAction::execute($order);
    }


}
