<?php

namespace App\Http\Controllers\Api\Driver;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\OrderUpdateRequest;
use App\Models\Order;
use App\Models\OrderComment;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    function index(Request $request):JsonResponse
    {
        $orders = Auth::user()->driverOrders()
            ->whereDate('orders.delivery_date',now())
            ->where('orders.status_id',2)
            ->get();

        return response()->json($orders);
    }

    function delivered(Request $request):JsonResponse
    {
        $orders = Auth::user()
            ->driverOrders()
//            ->whereIn('orders.status_id', [3, 4, 5, 6])
            ->get();

//        $orders = Order::join('driver_store_representatives', 'driver_store_representatives.store_representative_id', 'orders.user_id')
//            ->join('stores', 'stores.id', 'orders.store_id')
//            ->where('driver_store_representatives.driver_id', Auth::user()->id)
//            ->whereIn('orders.status', [3, 4, 5, 6])
//            ->whereDate('orders.updated_at', '=', Carbon::today())
//            ->select('orders.*', 'stores.name as store_name', 'stores.id as store_id', 'stores.address as store_address')
//            ->groupBy('orders.id')
//            ->get();

        return  response()->json($orders);
    }

    function update(OrderUpdateRequest $request,Order $order)
    {
        if ($order->has('status_id'))
        {
            $order->status_id = $request->get('status_id');
            if ($order->status == Order::STATUS_DELIVERED) {
                $order->delivered_date = now();
            }
        }
        if ($request->has('payment_type_id'))
        {
            $order->payment_type_id = $request->get('payment_type_id');
            switch ($order->payment_type_id) {
                case Order::PAYMENT_CASH:
                    $order->status_id = Order::STATUS_DELIVERED;
                    $order->payment_full = $request->get('payment_full');
                    if ($request->has('payment_partial')) {
                        $order->payment_partial = $request->get('payment_partial');
                    }
                    break;
                case Order::PAYMENT_CARD:
                    $order->status_id = Order::STATUS_DELIVERED;
                    break;
                case Order::PAYMENT_KASPI:
                    $order->status_id = Order::STATUS_DELIVERED;
                    $order->payment_full = $request->get('payment_full');

                    if ($request->has('kaspi_phone')) {
//                        $order->kaspi_phone = $request->get('kaspi_phone');
                    }
                    if ($request->has('payment_partial')) {
                        $order->payment_partial = $request->get('payment_partial');
                    }
//                dispatch(new PushSendJob(User::whereRole(User::ROLE_CASHIER)->deviceTokens(), [
//                    'title' => 'Вставлен счет на оплату',
//                    'body' => "заявка №$order->id ",
//                    'order_id' => $order->id,
//                    'sound' => 'default'
//                ],4));

                    break;
                case Order::PAYMENT_DELAY:
                    $order->status_id = Order::STATUS_CONFIRMATION;
                    break;

            }
        }
        if ($request->has('winning_name'))
        {
            $order->winning_name = $request->get('winning_name');
        }
        if ($request->has('winning_phone'))
        {
            $order->winning_phone = $request->get('winning_phone');
        }

        $order->save();

        if ($request->has('comment'))
        {
            $order->comments()->create([
                'user_id' => Auth::id(),
                'description' => $request->get('comment')
            ]);
        }


    }


    function info()
    {
        $query = Auth::user()->driverOrders()
            ->where('orders.status_id',3)
            ->whereDate('orders.delivery_date',now());

        $data['full_name'] = Auth::user()->name;
        $data['cash'] =  $query->clone()
            ->where('payment_type_id',1)
            ->count();
        $data['card'] =$query->clone()
            ->where('payment_type_id',2)
            ->count();
        $data['delay'] =$query->clone()
            ->where('payment_type_id',3)
            ->count();
        $data['total_purchase_price'] = $query->clone()
            ->sum('purchase_price');
        $data['total_return_price'] =$query->clone()
            ->sum('return_price');

        return response()->json($data);
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

}
