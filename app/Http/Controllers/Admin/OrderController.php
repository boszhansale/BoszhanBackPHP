<?php

namespace App\Http\Controllers\Admin;

use App\Exports\Excel\OrderExcelExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrderUpdateRequest;
use App\Models\DriverSalesrep;
use App\Models\Order;
use App\Models\PaymentStatus;
use App\Models\PaymentType;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    function index()
    {
        return view('admin.order.index');
    }
    function create()
    {
        $roles = Role::all();
        $salesreps = User::join('user_roles','user_roles.user_id','users.id')
            ->where('user_roles.role_id',1)
            ->select('users.*')
            ->get();
        $drivers = User::join('user_roles','user_roles.user_id','users.id')
            ->where('user_roles.role_id',2)
            ->select('users.*')
            ->get();
        return view('admin.user.create',compact('roles','salesreps','drivers'));
    }
    function store(Request $request)
    {
        $user = new User();
        $user->name = $request->get('name');
        $user->id_1c = $request->get('id_1c');
        $user->login = $request->get('login');
        $user->phone = $request->get('phone');
        $user->id_1c = $request->get('id_1c');
        $user->winning_access = $request->has('winning_access');
        $user->payout_access = $request->has('payout_access');
        if ($request->has('password')){
            $user->password = Hash::make($request->get('password'));
        }
        $user->save();


        if ($request->has('drivers')){
            foreach ($request->get('drivers') as $driver) {
                DriverSalesrep::updateOrCreate(
                    [
                        'driver_id' => $driver,
                        'salesrep_id' => $user->id
                    ],
                    [
                        'driver_id' => $driver,
                        'salesrep_id' => $user->id
                    ]
                );
            }
        }
        if ($request->has('salesreps')){
            foreach ($request->get('salesreps') as $salesrep) {
                DriverSalesrep::updateOrCreate(
                    [
                        'driver_id' => $user->id,
                        'salesrep_id' => $salesrep
                    ],
                    [
                        'driver_id' => $user->id,
                        'salesrep_id' => $salesrep
                    ]
                );
            }
        }
        if ($request->has('roles')){
            foreach ($request->get('roles') as $role_id) {
                UserRole::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'role_id' => $role_id
                    ],
                    [
                        'user_id' => $user->id,
                        'role_id' => $role_id
                    ]
                );
            }
        }


        return redirect()->route('admin.user.index');

    }

    function edit(Order $order):View
    {
        $salesreps = User::join('user_roles','user_roles.user_id','users.id')
            ->where('user_roles.role_id',1)
            ->select('users.*')
            ->get();
        $drivers = User::join('user_roles','user_roles.user_id','users.id')
            ->where('user_roles.role_id',2)
            ->select('users.*')
            ->get();

        $statuses = Status::all();
        $paymentTypes = PaymentType::all();
        $paymentStatuses = PaymentStatus::all();

        return view('admin.order.edit',compact('order','salesreps','drivers','statuses','paymentTypes','paymentStatuses'));
    }
    function show(Order $order)
    {
        return view('admin.order.show',compact('order'));
    }
    function update(OrderUpdateRequest $request,Order $order)
    {

        $order->update($request->validated());

        return redirect()->back();

    }
    function delete(Order $order)
    {
        $order->delete();
        return redirect()->back();
    }
    function recover(Order $order)
    {
        $order->deleted_at = null;
        $order->save();
        return redirect()->back();
    }

    function exportExcel(Order $order)
    {
        return Excel::download(new OrderExcelExport($order), "order_$order->id.xlsx");
    }

}
