<?php

namespace App\Http\Controllers\Api\Driver;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\OrderUpdateRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $lat = Auth::user()->lat;
        $lng = Auth::user()->lng;

        $orders = Auth::user()->driverOrders()
            ->when($lat or $lng, function ($q) use ($lng, $lat) {
                return $q->selectRaw("ST_Distance_Sphere(point('$lng','$lat'),point(stores.lng,stores.lat)) AS distance, orders.*")
                    ->join('stores', 'stores.id', 'orders.store_id');
            })
            ->when(Auth::id() == 286, function ($q) {
                $q->where(function ($qq) {
                    $qq->whereDate('orders.delivery_date', now())->orWhereDate('orders.delivery_date', now()->subDay());;
                });
            }, function ($q) {
                $q->whereDate('orders.delivery_date', now());
            })
            ->when($request->has('id'), function ($q) use ($request) {
                $q->where('orders.id', $request->get('id'));
            })
            ->where('orders.status_id', 2)
            ->with(['store', 'baskets', 'baskets.product'])
            ->get();

//        if  (Auth::user()->login == 'nazh'){
//            $orders = Auth::user()->driverOrders()
//                ->whereDate('orders.delivery_date', now())
//                ->where('orders.status_id', 2)
//                ->with(['store', 'baskets', 'baskets.product'])
//                ->limit(17)
//                ->orderBy('id','desc')
//                ->get();
//        }

        return response()->json(OrderResource::collection($orders));
    }

    public function delivered(Request $request): JsonResponse
    {
        $orders = Auth::user()
            ->driverOrders()
            ->whereIn('orders.status_id', [3, 4, 5, 6])
//            ->whereDate('created_at','>=',Carbon::now()->subDays(3))
            ->whereDate('orders.delivery_date', now())
            ->with(['store', 'baskets', 'baskets.product'])
            ->get();

//        $orders = Order::join('driver_store_representatives', 'driver_store_representatives.store_representative_id', 'orders.user_id')
//            ->join('stores', 'stores.id', 'orders.store_id')
//            ->where('driver_store_representatives.driver_id', Auth::user()->id)
//            ->whereIn('orders.status', [3, 4, 5, 6])
//            ->whereDate('orders.updated_at', '=', Carbon::today())
//            ->select('orders.*', 'stores.name as store_name', 'stores.id as store_id', 'stores.address as store_address')
//            ->groupBy('orders.id')
//            ->get();

        return response()->json(OrderResource::collection($orders));
    }

    public function update(OrderUpdateRequest $request, Order $order)
    {
        if ($request->has('status_id')) {
            $order->status_id = $request->get('status_id');
            if ($request->get('status_id') == Order::STATUS_DELIVERED) {
                $order->delivered_date = now();
                if ($order->payment_type_id == Order::PAYMENT_CASH or $order->payment_type_id == Order::PAYMENT_KASPI) {
                    $order->payment_status_id = Order::PAYMENT_STATUS_PAID;
                }
            }
        }
        if ($request->has('payment_type_id')) {
            $order->payment_type_id = $request->get('payment_type_id');
            switch ($order->payment_type_id) {
                case Order::PAYMENT_CASH:
                    $order->status_id = Order::STATUS_DELIVERED;
                    $order->payment_full = $request->get('payment_full');
                    $order->delivered_date = now();
                    $order->payment_status_id = Order::PAYMENT_STATUS_PAID;
                    if ($request->has('payment_partial')) {
                        $order->payment_partial = $request->get('payment_partial');
                    }
                    break;
                case Order::PAYMENT_CARD:
                    $order->status_id = Order::STATUS_DELIVERED;
                    $order->delivered_date = now();
                    break;
                case Order::PAYMENT_KASPI:
                    $order->status_id = Order::STATUS_DELIVERED;
                    $order->delivered_date = now();
                    $order->payment_status_id = Order::PAYMENT_STATUS_PAID;
                    $order->payment_full = $request->get('payment_full');
                    if ($request->has('kaspi_phone')) {
                        $order->kaspi_phone = $request->get('kaspi_phone');
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
        if ($request->has('winning_name')) {
            $order->winning_name = $request->get('winning_name');
        }
        if ($request->has('winning_phone')) {
            $order->winning_phone = $request->get('winning_phone');
        }
        if ($request->has('lat')) {
            $order->lat = $request->get('lat');
        }
        if ($request->has('lng')) {
            $order->lng = $request->get('lng');
        }
        $order->save();
        if ($request->has('comment')) {
            $order->comments()->create([
                'user_id' => Auth::id(),
                'description' => $request->get('comment'),
            ]);
        }

//        if ($request->has('baskets')) {
//            $basketUpdateAction = new BasketUpdateAction();
//            $basketUpdateAction->execute($request->get('baskets'), $order);
//        }

        return response()->json(['message' => 'Успешно']);
    }

    public function info()
    {
        $query = Auth::user()->driverOrders()
            ->where('orders.status_id', 3)
            ->whereDate('orders.delivery_date', now());

        $data['full_name'] = Auth::user()->name;
        $data['count_all'] = Auth::user()->driverOrders()
            ->where('delivery_date', now())
            ->count();
        $data['count_finished'] = Auth::user()->driverOrders()
            ->whereDate('delivered_date', now())
            ->count();

        $data['cash'] = round($query->clone()
                ->where('payment_type_id', 1)
                ->sum('orders.purchase_price') - $query->clone()
                ->where('payment_type_id', 1)
                ->sum('orders.return_price'));

        $data['card'] = round($query->clone()
                ->where('payment_type_id', 2)
                ->sum('orders.purchase_price') - $query->clone()
                ->where('payment_type_id', 2)
                ->sum('orders.return_price'));
        $data['kaspi'] = round($query->clone()
                ->where('payment_type_id', 4)
                ->sum('orders.purchase_price') - $query->clone()
                ->where('payment_type_id', 4)
                ->sum('orders.return_price'));

        $data['delay'] = $query->clone()
            ->where('payment_type_id', 3)
            ->sum('orders.purchase_price');

        $data['total_purchase_price'] = $query->clone()
            ->sum('purchase_price');
        $data['total_return_price'] = $query->clone()
            ->sum('return_price');

        return response()->json($data);
    }

    public function rnk(Order $order)
    {
        $price = $order->baskets()->where('type', 0)->sum('price');
        $all_price = $order->purchase_price;
        $return_price = $order->return_price;
        $count = $order->baskets()->where('type', 0)->count();

        $counteragent = $order->store->counteragent;
        if ($counteragent) {
            $recipient[] = $counteragent->name;
        }
        if ($order->store->name) {
            $recipient[] = $order->store->name;
        }
        if ($order->store->address) {
            $recipient[] = $order->store->address;
        }
        if ($order->store->phone) {
            $recipient[] = $order->store->phone;
        }

        $qr_price = $all_price - $return_price;

        return view('pdf.rnk', compact('order', 'price', 'qr_price', 'all_price', 'count', 'recipient'));
        PDF::setOptions(['dpi' => 210, 'defaultFont' => 'sans-serif']);

        $pdf = PDF::loadView('pdf.rnk', compact('order', 'price', 'qr_price', 'all_price', 'count', 'recipient'));

        return $pdf->download('rnk.pdf');
    }

    public function beforeRnk(Order $order)
    {
        $price = $order->baskets()->where('type', 0)->sum('price');
        $all_price = $order->purchase_price;
        $count = $order->baskets()->where('type', 0)->count();

        $return_price = $order->baskets()->where('type', 1)->sum('price');
        $return_all_price = $order->return_price0;
        $return_count = $order->baskets()->where('type', 1)->count();

        return view('pdf.before_rnk', compact('order', 'price', 'all_price', 'count', 'return_price', 'return_count', 'return_all_price'));
        PDF::setOptions(['dpi' => 210, 'defaultFont' => 'sans-serif']);

        $pdf = PDF::loadView('pdf.before_rnk', compact('order', 'price', 'all_price', 'count', 'return_price', 'return_count', 'return_all_price'));

        return $pdf->download('before_rnk.pdf');
    }

    public function pko(Order $order)
    {
        $all_price = $order->purchase_price;
        $counteragent = $order->store->counteragent;

        if ($counteragent) {
            $recipient[] = $counteragent->name;
        }
        $store = $order->store;
        if ($store->name) {
            $recipient[] = $store->name;
        }
        if ($store->address) {
            $recipient[] = $store->address;
        }
        if ($store->phone) {
            $recipient[] = $store->phone;
        }

        return view('pdf.pko', compact('order', 'all_price', 'recipient'));

        PDF::setOptions(['dpi' => 210, 'defaultFont' => 'sans-serif']);

        $pdf = PDF::loadView('pdf.pko', compact('order', 'all_price', 'recipient'));

        return $pdf->download('pko.pdf');
    }

    public function vozvrat(Order $order)
    {
        $price = $order->baskets()->where('type', 1)->sum('price');
        $all_price = $order->return_price;
        $count = $order->baskets()->where('type', 1)->count();

        if ($order->store->counteragent) {
            $recipient[] = $order->store->counteragent;
        }
        $store = $order->store;
        if ($store->name) {
            $recipient[] = $store->name;
        }
        if ($store->address) {
            $recipient[] = $store->address;
        }
        if ($store->phone) {
            $recipient[] = $store->phone;
        }

        return view('pdf.vozvrat', compact('order', 'price', 'all_price', 'count', 'recipient'));

        PDF::setOptions(['dpi' => 210, 'defaultFont' => 'sans-serif']);

        $pdf = PDF::loadView('pdf.vozvrat', compact('order', 'price', 'all_price', 'count', 'recipient'));

        return $pdf->download('vozvrat.pdf');
    }
}
