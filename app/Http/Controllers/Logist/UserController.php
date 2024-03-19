<?php

namespace App\Http\Controllers\Logist;

use App\Exports\Excel\RiderExport;
use App\Exports\Excel\UserOrderExport;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\RiderDriver;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function drivers()
    {
        return response()->view('logist.user.drivers');
    }

    public function riders()
    {
        return response()->view('logist.user.riders');
    }

    public function edit(User $user)
    {


        $riders = User::query()
            ->where('users.role_id', 10)
            ->where('users.status', 1)
            ->select('users.*')
            ->orderBy('users.name')
            ->get();

        return view('logist.user.edit', compact('user', 'riders'));
    }

    public function update(Request $request, User $user)
    {

        if ($request->has('rider_id')) {
            RiderDriver::where('driver_id', $user->id)->delete();
            RiderDriver::create(
                [
                    'rider_id' => $request->get('rider_id'),
                    'driver_id' => $user->id,
                ]
            );
        } else {
            RiderDriver::where('driver_id', $user->id)->delete();
        }


        return redirect()->back();
    }

    public function statusChange(User $user, $status)
    {
        $user->status = $status;
        $user->save();
    }


    public function riderExcel(Request $request)
    {
        $orders = Order::query()
            ->whereNotNull('rider_id')
            ->when($request->get('start_date'), function ($q) {
                $q->whereDate('orders.delivery_date', '>=', \request('start_date'));
            })
            ->when($request->get('end_date'), function ($q) {
                $q->whereDate('orders.delivery_date', '<=', \request('end_date'));
            })
            ->when($request->get('rider_id'), function ($q) {
                $q->where('orders.rider_id', \request('rider_id'));
            })
            ->join('baskets', 'baskets.order_id', 'orders.id')
            ->join('products', 'products.id', 'baskets.product_id')
            ->select([
                'orders.id',
                'products.name',
                'products.measure',
                'orders.delivery_date',
                'orders.driver_id',
                'orders.rider_id',
                'orders.store_id',
                'baskets.count',
                'baskets.type',
            ])
            ->orderBy('orders.id', 'desc')
            ->with(['rider', 'driver', 'store'])
            ->get();

        return Excel::download(new RiderExport($orders), 'riders.xlsx');
    }

    public function statisticByOrderExcel(Request $request)
    {
        $ordersQuery = Order::query()
            ->select('orders.*')
            ->join('stores', 'stores.id', 'orders.store_id')
            ->when($request->has('from'), function ($q) {
                $q->whereDate('orders.created_at', '>=', \request('from'));
            })
            ->when($request->has('to'), function ($q) {
                $q->whereDate('orders.created_at', '<=', \request('to'));
            })
            ->whereNull('orders.removed_at');

        $users = User::query()
            ->whereIn('id', $request->get('users'))
            ->where('status', 1)
            ->where('role_id', 1)
            ->get();

        return Excel::download(new UserOrderExport($users, $ordersQuery), 'статистика.xlsx');

    }
}
