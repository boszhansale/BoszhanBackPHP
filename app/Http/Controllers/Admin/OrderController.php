<?php

namespace App\Http\Controllers\Admin;

use App\Exports\Excel\OrderExcelExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrderManyUpdateRequest;
use App\Http\Requests\Admin\OrderUpdateRequest;
use App\Models\Order;
use App\Models\PaymentStatus;
use App\Models\PaymentType;
use App\Models\Status;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    public function index()
    {
        $query = Order::query();

        return view('admin.order.index', compact('query'));
    }

    public function edit(Order $order): View
    {
        $salesreps = User::query()
            ->where('users.role_id', 1)
            ->where('users.status', 1)
            ->select('users.*')
            ->orderBy('users.name')
            ->get();
        $drivers = User::query()
            ->where('users.role_id', 2)
            ->where('users.status', 1)
            ->select('users.*')
            ->orderBy('users.name')
            ->get();

        $statuses = Status::all();
        $paymentTypes = PaymentType::all();
        $paymentStatuses = PaymentStatus::all();

        return view('admin.order.edit', compact('order', 'salesreps', 'drivers', 'statuses', 'paymentTypes', 'paymentStatuses'));
    }

    public function update(OrderUpdateRequest $request, Order $order)
    {
        $order->update($request->validated());

        return redirect()->back();
    }

    public function manyEdit(Request $request): View
    {
        $orders = $request->get('orders');
        $salesreps = User::query()
            ->where('users.role_id', 1)
            ->where('users.status', 1)
            ->select('users.*')
            ->orderBy('users.name')
            ->get();
        $drivers = User::query()
            ->where('users.role_id', 2)
            ->where('users.status', 1)
            ->select('users.*')
            ->orderBy('users.name')
            ->get();

        $statuses = Status::all();
        $paymentTypes = PaymentType::all();
        $paymentStatuses = PaymentStatus::all();

        return view('admin.order.many-edit', compact('orders', 'salesreps', 'drivers', 'statuses', 'paymentTypes', 'paymentStatuses'));
    }

    public function manyUpdate(OrderManyUpdateRequest $request)
    {
        foreach ($request->get('orders') as $order_id) {
            $order = Order::find($order_id);
            if (!$order) {
                continue;
            }
            if ($request->get('salesrep_id')) {
                $order->salesrep_id = $request->get('salesrep_id');
            }
            if ($request->get('driver_id')) {
                $order->driver_id = $request->get('driver_id');
            }
            if ($request->get('status_id')) {
                $order->status_id = $request->get('status_id');
            }
            if ($request->get('payment_status_id')) {
                $order->payment_status_id = $request->get('payment_status_id');
            }
            if ($request->get('payment_type_id')) {
                $order->payment_type_id = $request->get('payment_type_id');
            }
            if ($request->get('delivered_date')) {
                $order->delivered_date = $request->get('delivered_date');
            }
            if ($request->get('delivery_date')) {
                $order->delivery_date = $request->get('delivery_date');
            }
            $order->save();
        }
        return redirect()->route('admin.order.index');
    }

    public function show($orderId)
    {
        $order = Order::withTrashed()->find($orderId);

        return view('admin.order.show', compact('order'));
    }

    public function delete(Order $order)
    {
        $order->delete();

        return redirect()->back();
    }

    public function remove(Order $store)
    {
        $store->removed_at = now();
        $store->save();
        return redirect()->back();
    }

    public function recover($id)
    {

        $order = Order::where('id',$id)->withTrashed()->first();
        $order->removed_at = null;
        $order->deleted_at = null;
        $order->save();

        return redirect()->back();
    }

    public function exportExcel(Order $order)
    {
        return Excel::download(new OrderExcelExport($order), "order_$order->id.xlsx");
    }

    public function waybill(Order $order)
    {
        $pdf = PDF::loadView('pdf.waybill', compact('order'));

        return $pdf->download('waybill.pdf');
    }

    public function toOnec()
    {
        Artisan::call('order:report');
        Artisan::call('order:report-return');
        dump('отправлен');

        return redirect()->back();
    }

    public function driverMove()
    {
        return \view('admin.order.driver_move');
    }

    public function driverMoving(Request $request)
    {
        Order::whereIn('id', $request->get('orders'))
            ->update(['driver_id' => $request->get('to_driver_id')]);

        return redirect()->route('admin.user.show', $request->get('to_driver_id'));
    }

    public function statistic()
    {
        return \view('admin.order.statistic');
    }

    public function history(Order $order)
    {
        return \view('admin.order.history', compact('order'));
    }

    public function ediParse()
    {
        Artisan::call('order:parse');

    }
}
