<?php

namespace App\Http\Controllers\Supervisor;

use App\Exports\Excel\OrderExcelExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrderUpdateRequest;
use App\Models\Order;
use App\Models\PaymentStatus;
use App\Models\PaymentType;
use App\Models\Status;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    public function index()
    {

        return view('supervisor.order.index');
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

        return view(
            'supervisor.order.edit',
            compact('order', 'salesreps', 'drivers', 'statuses', 'paymentTypes', 'paymentStatuses')
        );
    }

    public function show($orderId)
    {
        $order = Order::withTrashed()->find($orderId);

        return view('supervisor.order.show', compact('order'));
    }

    public function update(OrderUpdateRequest $request, Order $order)
    {
        $order->update($request->validated());

        return redirect()->back();
    }

    public function remove(Order $order)
    {
        $order->removed_at = Carbon::now();
        $order->save();

        return redirect()->back();
    }

    public function recover($id)
    {
        $order = Order::withTrashed()->find($id);
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


    public function statistic()
    {
        return \view('supervisor.order.statistic');
    }

    public function history(Order $order)
    {
        return \view('supervisor.order.history', compact('order'));
    }


    public function driverMove()
    {
        return \view('supervisor.order.driver_move');
    }

    public function driverMoving(Request $request)
    {
        Order::whereIn('id', $request->get('orders'))
            ->update(['driver_id' => $request->get('to_driver_id')]);

        return redirect()->route('supervisor.user.show', $request->get('to_driver_id'));
    }
}
