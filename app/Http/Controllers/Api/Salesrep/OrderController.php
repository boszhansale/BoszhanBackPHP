<?php

namespace App\Http\Controllers\Api\Salesrep;

use App\Actions\BasketCreateAction;
use App\Actions\OrderCreateAction;
use App\Actions\OrderPriceAction;
use App\Actions\OrderUpdateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\OrderStoreRequest;
use App\Http\Requests\Api\OrderUpdateRequest;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Auth::user()
            ->salesrepOrders()
            ->join('stores', 'stores.id', 'orders.store_id')
            ->when($request->has('store_id'), function ($q) {
                $q->where('orders.store_id', \request('store_id'));
            })
            ->when($request->has('counteragent_id'), function ($q) {
                $q->where('stores.counteragent_id', \request('counteragent_id'));
            })
            ->when($request->has('start_date'), function ($q) {
                return $q->whereDate('orders.created_at', '>=', \request('start_date'));
            })
            ->when($request->has('end_date'), function ($q) {
                return $q->whereDate('orders.created_at', '<=', \request('end_date'));
            })
            ->when(!$request->has('start_date') and !$request->has('end_date'), function ($q) {
                return $q->whereDate('orders.created_at', '>=', Carbon::yesterday());
            })
            ->select('orders.*')
            ->with([
                'baskets' => function ($q) {
                    $q->with('product');
                },
                'store'
            ])
            ->latest()
            ->get();


        return response()->json($orders);
    }


    public function store(OrderStoreRequest $request, OrderCreateAction $action, BasketCreateAction $basketCreateAction)
    {
        $order = $action->execute($request->validated(), Auth::user());
        $basketCreateAction->execute($request->get('baskets'), $order);
        $order = OrderPriceAction::execute($order);
        //Проверка если контрагент в группе сотрудники, то отправляем на фтп 1с
        if ($order->store->counteragent) {
            if ($order->store->counteragent->group_id == 3 or $order->store->counteragent->to_1c == 1) {
                Artisan::call('order:report ' . $order->id);
                Artisan::call('order:report-return ' . $order->id);
            }
        }

        return response()->json($order);
    }

    public function show($id): JsonResponse
    {
        $order = Order::with(['baskets', 'store', 'status', 'paymentType', 'paymentStatus', 'comments'])->findOrFail(
            $id
        );

        return response()->json($order);
    }

    public function update(OrderUpdateRequest $request, Order $order, OrderUpdateAction $action): JsonResponse
    {
        $order = $action->execute($request->validated(), $order);
//        $order->baskets()->delete();
        return response()->json($order);
    }

    public function delete(Order $order)
    {
        $order->delete();
        return response()->json(['message' => 'Успешно удалено']);
    }

    public function plan()
    {
        $user = Auth::user();

        $planGroupUser = $user->planGroupUser;
        $group = $planGroupUser->planGroup;
        $planBrands = $user->brandPlans()->where('plan', '>', 0)->with('brand')->get();

        $data['plan'] = $planGroupUser->plan;
        $data['completed'] = $planGroupUser->completed;

        $data['brands'] = [];

        foreach ($planBrands as $planBrand) {
            $item['plan'] = $planBrand->plan;
            $item['completed'] = $planBrand->completed;
            $item['brand'] = $planBrand->brand;

            $data['brands'][] = $item;
        }

        $data['group_name'] = $group->name;

        $data['group_position'] = $planGroupUser->position;

        $data['group_plan'] = $group->plan;
        $data['group_completed'] = $group->completed;
        $data['group_brands'] = [];

        foreach ($group->planGroupBrands as $planBrand) {
            $item['plan'] = $planBrand->plan;
            $item['completed'] = $planBrand->completed;
            $item['brand'] = $planBrand->brand;

            $data['group_brands'][] = $item;
        }

        return response()->json($data);
    }

    public function info(Request $request)
    {
        //юр лица кол заявок
        //юр лица кол возврат
        //юр лица кол игр
        $user = Auth::user();

        $orders = $user->salesrepOrders()->individual()->today()->get('orders.*');
        $data['individual_orders'] = count($orders);
        $data['individual_purchase'] = 0;
        $data['individual_return'] = 0;
        $data['individual_return_count'] = $user->salesrepOrders()->individual()->today()->where(
            'return_price',
            '>',
            0
        )->count();
        $data['individual_games'] = 0;
        $data['individual_games_wins'] = 0;
        foreach ($orders as $order) {
            $data['individual_games'] += 0;//$order->bonusGames()->count();
            $data['individual_games_wins'] += 0;//$order->bonusGames()->sum('win');
            $data['individual_purchase'] += $order->purchase_price;
            $data['individual_return'] += $order->return_price;
        }
        //30011

        $orders = $user->salesrepOrders()->legalEntity()->today()->get('orders.*');
        $data['legal_entity_orders'] = count($orders);
        $data['legal_entity_purchase'] = 0;
        $data['legal_entity_return'] = 0;
        $data['legal_entity_count_return'] = $user->salesrepOrders()->legalEntity()->today()->where(
            'return_price',
            '>',
            0
        )->count();
        $data['legal_entity_games'] = 0;
        $data['legal_entity_games_wins'] = 0;
        foreach ($orders as $order) {
            $data['legal_entity_games'] += 0;// $order->bonusGames()->count();
            $data['legal_entity_games_wins'] += 0;// $order->bonusGames()->sum('win');
            $data['legal_entity_purchase'] += $order->purchase_price;
            $data['legal_entity_return'] += $order->return_price;
        }

        return \response()->json($data);
    }
}
