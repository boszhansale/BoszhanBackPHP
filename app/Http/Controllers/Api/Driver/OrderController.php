<?php

namespace App\Http\Controllers\Api\Driver;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
//        $roadmap = Auth::user()->roadmaps()
//            ->latest('id')
//            ->first();
//
//        if (!$roadmap) {
//            return $this->cresponse('No roadmaps are generated yet', null, Response::HTTP_EXPECTATION_FAILED);
//        }
        if (Carbon::now()->dayOfWeek === 1){
            $date = Carbon::now()->subDays(3);
        }else{
            $date = Carbon::now()->subDay();
        }

        $waypoints = Order::where('orders.status', 2)
            ->with(["user.counterparty", 'store', 'bonusGames', 'user:id,phone_number'])
            ->join('driver_store_representatives', 'driver_store_representatives.store_representative_id', 'orders.user_id')
            ->whereDate('orders.created_at', '>=', $date)
            ->where('driver_store_representatives.driver_id', Auth::id())
            ->select('orders.*')
            ->get();



        return $this->cresponse('All waypoints of driver', new DeliveryOrdersDataResource((object)['waypoints' => $waypoints]));
    }

    public function changeDeliveryOrderStatus(Order $order, ChangeOrderStatusRequest $request)
    {
        if (!Auth::user()->driverOrders()->where('orders.id', $order->id)->exists()) {
            return $this->cresponse('Order not found in that courier orders', null, Response::HTTP_NOT_FOUND);
        }


        try {
//            dispatch(new ChangeOrderStatusJob($order, $request->status));
            $order->status = $request->status;
            if ($order->status == Order::STATUS_DELIVERED) {
                $order->delivered_at = now();
            }
            if ($order->status == Order::STATUS_REJECT) {
                if ($request->has('comment')) {
                    $comment = new OrderComment();
                    $comment->user_id = Auth::user()->id;
                    $comment->role = Auth::user()->role;
                    $comment->description = $request['description'];
                    $comment->save();

                    //TODO send push
                }
            }
            $order->save();


        } catch (Exception $e) {
            return $this->cresponse($e->getMessage(), null, Response::HTTP_EXPECTATION_FAILED);
        }
        return $this->cresponse('Successfully changed status');
    }

    public function changePaymentType(Order $order, ChangeOrderPaymentTypeRequest $request)
    {
        if (!Auth::user()->driverOrders()->where('orders.id', $order->id)->exists()) {
            return $this->cresponse('Order not found in that courier orders', null, Response::HTTP_NOT_FOUND);
        }

        try {
            $order->payment_type = $request->payment_type;
            switch ($order->payment_type) {
                case Order::PAYMENT_CASH:
                    $order->status = Order::STATUS_DELIVERED;
                    $order->payment_full = $request->get('payment_full');
                    if ($request->has('payment_partial')) {
                        $order->payment_partial = $request->get('payment_partial');
                    }
                    break;
                case Order::PAYMENT_CARD:
                    $order->status = Order::STATUS_DELIVERED;
                    break;
                case Order::PAYMENT_KASPI:
                    $order->status = Order::STATUS_DELIVERED;
                    $order->payment_full = $request->get('payment_full');

                    if ($request->has('kaspi_phone')) {
                        $order->kaspi_phone = $request->get('kaspi_phone');
                    }
                    if ($request->has('payment_partial')) {
                        $order->payment_partial = $request->get('payment_partial');
                    }

                    dispatch(new PushSendJob(User::whereRole(User::ROLE_CASHIER)->deviceTokens(), [
                        'title' => 'Вставлен счет на оплату',
                        'body' => "заявка №$order->id ",
                        'order_id' => $order->id,
                        'sound' => 'default'
                    ],4));
                    break;
                case Order::PAYMENT_DELAY:
                    $order->status = Order::STATUS_CONFIRMATION;
                    break;

            }

            $order->save();

            //Send
//            dispatch(new PushSendJob( $order->user->deviceTokens(),[
//                'title' => 'Статус изменен',
//                'body' => $request->get('comment'),
//                'order_id' => $order->id,
//                'sound' => 'default'
//            ]));


        } catch (Exception $e) {
            return $this->cresponse($e->getMessage(), null, Response::HTTP_EXPECTATION_FAILED);
        }
        return $this->cresponse('Successfully changed payment type');
    }

    public function getDeliveredOrders(Request $request)
    {
//        $orders = Auth::user()
//            ->driverOrders()
//            ->delivered()
//            ->get();

        $orders = Order::join('driver_store_representatives', 'driver_store_representatives.store_representative_id', 'orders.user_id')
            ->join('stores', 'stores.id', 'orders.store_id')
            ->where('driver_store_representatives.driver_id', Auth::user()->id)
            ->whereIn('orders.status', [3, 4, 5, 6])
            ->whereDate('orders.updated_at', '=', Carbon::today())
            ->select('orders.*', 'stores.name as store_name', 'stores.id as store_id', 'stores.address as store_address')
            ->groupBy('orders.id')
            ->get();


        return $this->cresponse('Delivered orders2', $orders);
    }

    public function update(Request $request)
    {

        $order = Order::findOrFail($request->order_id);
        DB::beginTransaction();
        try {
            $oldOrder = new OrderUpdateHistory();
            $oldOrder->order_id = $order->id;
            $oldOrder->user_id = $order->user_id;
            $oldOrder->delivery_time = $order->delivery_time;
            $oldOrder->basket = $order->basket;
            $oldOrder->address = $order->address;
            $oldOrder->store_id = $order->store_id;
            $oldOrder->mobile_id = $order->mobile_id;
            $oldOrder->delivered_at = $order->delivered_at;
            $oldOrder->status = $order->status;
            $oldOrder->payment_at = $order->payment_at;
            $oldOrder->dogovor = $order->dogovor;
            $oldOrder->bin = $order->bin;
            $oldOrder->off_prices = $order->off_prices;
            $oldOrder->payment_type = $order->payment_type;
            $oldOrder->payment_status = $order->payment_status;
            $oldOrder->kaspi_phone = $order->kaspi_phone;
            $oldOrder->payment_full = $order->payment_full;
            $oldOrder->payment_partial = $order->payment_partial;
            $oldOrder->winning_name = $order->winning_name;
            $oldOrder->winning_phone = $order->winning_phone;
            $oldOrder->winning_status = $order->winning_status;
            $oldOrder->save();

            $basket = [];
            foreach ($request['basket'] as $item) {
                $b['product_id'] = $item['product_id'];
                $b['name'] = $item['name'];
                $b['price'] = $item['price'];
                $b['all_price'] = $item['price'] * $item['count'];
                $b['article'] = $item['article'];
                $b['image'] = isset($item['image']) ? $item['image'] : '';
                $b['measure_id'] = $item['measure_id'];
                $b['count'] = $item['count'];
                $b['type'] = $item['type'];

                $basket[] = $b;
            }
            $order->basket = $basket;
            $order->save();

            //TODO send push

        } catch (Exception $e) {
            return $this->cresponse($e->getMessage(), null, Response::HTTP_EXPECTATION_FAILED);
        }

        DB::commit();

        return $this->cresponse('Successfully updated order basket');
    }

    public function reject(Order $order, RejectOrderRequest $request)
    {


        $order->status = Order::STATUS_REJECT;
        $order->save();

        $orderComment = new OrderComment();
        $orderComment->user_id = Auth::user()->id;
        $orderComment->role = Auth::user()->role;
        $orderComment->description = $request->get('comment');
        $orderComment->save();

        dispatch(new PushSendJob($order->user->deviceTokens(), [
            'title' => 'Отказ',
            'body' => $request->get('comment'),
            'order_id' => $order->id,
            'sound' => 'default'
        ]));

        return $this->cresponse('Successfully reject order');
    }

    public function myPaymentsInfo()
    {
        $orders = Order::join('driver_store_representatives', 'driver_store_representatives.store_representative_id', 'orders.user_id')
            ->join('stores', 'stores.id', 'orders.store_id')
            ->where('driver_store_representatives.driver_id', Auth::user()->id)
            ->whereIn('orders.status', [3])
            ->whereDate('orders.updated_at', '=', Carbon::today())
            ->select('orders.*')
            ->get();

        $data['full_name'] = Auth::user()->full_name;
        $data['cash'] = 0;
        $data['card'] = 0;
        $data['delay'] = 0;
        $data['kaspi'] = 0;
        $data['total_base_cost'] = 0;
        $data['return_cost'] = 0;
        $data['total_cost'] = 0;

        foreach ($orders as $order) {
            $total_base_cost = $order->total_cost;
            $data['total_base_cost'] += $total_base_cost;
            $return_cost = $order->total_returns_cost;
            $data['return_cost'] += $return_cost;
            $total_cost = $total_base_cost - $return_cost;
            $data['total_cost'] += $total_cost;

            switch ($order->payment_type) {
                case Order::PAYMENT_CASH;
                    $data['cash'] += $total_cost;
                    break;
                case Order::PAYMENT_CARD;
                    $data['kaspi'] += $total_cost;
                    break;
                case Order::PAYMENT_DELAY;
                    $data['delay'] += $total_cost;
                    break;
                case Order::PAYMENT_KASPI;
                    $data['card'] += $total_cost;
                    break;
            }


        }
        $data['cash'] =  round($data['cash']);
        return $data;
    }

    public function winning(Order $order, Request $request)
    {
        $order->winning_name = $request['winning_name'];
        $order->winning_phone = $request['winning_phone'];
        $order->save();

        return $this->cresponse('Successfully');

    }

    public function rnk(Order $order)
    {

        $price = 0;
        $all_price = 0;
        $return_price = 0;
        $count = 0;
        $driverName = '';
        $qr_price = 0;

        $user = $order->user;
        if ($user) {
            $driver = $user->driver;
            if ($driver) {
                $driverName = $driver->full_name;
            }
        }
        $countragent = $order->counteragent;
        if ($countragent) {
            $recipient[] = $countragent->name_1c;
        }
        $store = $order->store;
        if ($store) {
            $storeName = $store->name;
            $storeAddress = $store->address;
            $storePhone = $store->phone;
            if ($storeName) {
                $recipient[] = $storeName;
            }
            if ($storeAddress) {
                $recipient[] = $storeAddress;
            }
            if ($storePhone) {
                $recipient[] = $storePhone;
            }
        }

        foreach ($order->basket as $basket) {
            if ($basket['type'] == 0) {
                $price += $basket['price'];
                $all_price += $basket['all_price'];
                $count += $basket['count'];
            }else{
                $return_price += $basket['all_price'];
            }
        }


        $qr_price = $all_price-$return_price;
//        return view('pdf.rnk',compact('order','price','all_price','count','recipient'));
        PDF::setOptions(['dpi' => 210, 'defaultFont' => 'sans-serif']);

        $pdf = PDF::loadView('pdf.rnk', compact('order', 'price','qr_price', 'all_price', 'count', 'recipient', 'driverName'));

        return $pdf->download('rnk.pdf');
    }

    public function beforeRnk(Order $order)
    {

        $price = 0;
        $all_price = 0;
        $count = 0;

        $return_price = 0;
        $return_all_price = 0;
        $return_count = 0;



        foreach ($order->basket as $basket) {
            if ($basket['type'] == 0) {
                $price += $basket['price'];
                $all_price += $basket['all_price'];
                $count += $basket['count'];
            }else{
                $return_price += $basket['price'];
                $return_all_price += $basket['all_price'];
                $return_count += $basket['count'];
            }
        }


//        return view('pdf.before_rnk',compact('order','price','all_price','count'));
        PDF::setOptions(['dpi' => 210, 'defaultFont' => 'sans-serif']);

        $pdf = PDF::loadView('pdf.before_rnk', compact('order', 'price', 'all_price', 'count','return_price','return_count','return_all_price'));

        return $pdf->download('before_rnk.pdf');
    }

    public function pko(Order $order)
    {

        $all_price = 0;
        $driverName = '';
        $countragent = $order->counteragent;
        $user = $order->user;

        if ($user) {
            $driver = $user->driver;
            if ($driver) {
                $driverName = $driver->full_name;
            }
        }
        if ($countragent) {
            $recipient[] = $countragent->name_1c;
        }
        $store = $order->store;
        if ($store) {
            $storeName = $store->name;
            $storeAddress = $store->address;
            $storePhone = $store->phone;
            if ($storeName) {
                $recipient[] = $storeName;
            }
            if ($storeAddress) {
                $recipient[] = $storeAddress;
            }
            if ($storePhone) {
                $recipient[] = $storePhone;
            }
        }


        foreach ($order->basket as $basket) {
            if ($basket['type'] == 0) {
                $all_price += $basket['all_price'];
            }
        }

//        return view('pdf.pko',compact('order','all_price','recipient','driverName'));

        PDF::setOptions(['dpi' => 210, 'defaultFont' => 'sans-serif']);

        $pdf = PDF::loadView('pdf.pko', compact('order', 'all_price', 'recipient', 'driverName'));

        return $pdf->download('pko.pdf');
    }

    public function vozvrat(Order $order)
    {

        $price = 0;
        $all_price = 0;
        $count = 0;
        $driverName = '';

        $user = $order->user;
        if ($user) {
            $driver = $user->driver;
            if ($driver) {
                $driverName = $driver->full_name;
            }
        }

        $countragent = $order->counteragent;
        if ($countragent) {
            $recipient[] = $countragent->name_1c;
        }
        $store = $order->store;
        if ($store) {
            $storeName = $store->name;
            $storeAddress = $store->address;
            $storePhone = $store->phone;
            if ($storeName) {
                $recipient[] = $storeName;
            }
            if ($storeAddress) {
                $recipient[] = $storeAddress;
            }
            if ($storePhone) {
                $recipient[] = $storePhone;
            }
        }
        foreach ($order->basket as $basket) {
            if ($basket['type'] == 1) {
                $price += $basket['price'];
                $all_price += $basket['all_price'];
                $count += $basket['count'];
            }
        }
//        return view('pdf.vozvrat',compact('order','price','all_price','count','recipient'));

        PDF::setOptions(['dpi' => 210, 'defaultFont' => 'sans-serif']);

        $pdf = PDF::loadView('pdf.vozvrat', compact('order', 'price', 'all_price', 'count', 'recipient', 'driverName'));

        return $pdf->download('vozvrat.pdf');
    }

    public function back(Order $order): \Illuminate\Http\JsonResponse
    {
        $oldOrder  = OrderUpdateHistory::whereOrderId($order->id)->orderBy('id')->first();
        if ($oldOrder){
            $order->basket = $oldOrder->basket;
            $order->save();
        }

        return $this->cresponse('Successfully');
    }
}
