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
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    function index()
    {
        $query = Order::query();
        return view('admin.order.index',compact('query'));
    }

    function edit(Order $order):View
    {
        $salesreps = User::join('user_roles','user_roles.user_id','users.id')
            ->where('user_roles.role_id',1)
            ->select('users.*')
            ->orderBy('users.name')
            ->get();
        $drivers = User::join('user_roles','user_roles.user_id','users.id')
            ->where('user_roles.role_id',2)
            ->select('users.*')
            ->orderBy('users.name')
            ->get();

        $statuses = Status::all();
        $paymentTypes = PaymentType::all();
        $paymentStatuses = PaymentStatus::all();

        return view('admin.order.edit',compact('order','salesreps','drivers','statuses','paymentTypes','paymentStatuses'));
    }
    function show($orderId)
    {
        $order = Order::withTrashed()->find($orderId);
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
    function recover($id)
    {
        $order = Order::withTrashed()->find($id);
        $order->deleted_at = null;
        $order->save();
        return redirect()->back();
    }

    function exportExcel(Order $order)
    {
        return Excel::download(new OrderExcelExport($order), "order_$order->id.xlsx");
    }
    function waybill(Order $order)
    {

        $pdf = PDF::loadView('pdf.waybill', compact('order'));

        return $pdf->download('waybill.pdf');
    }

    function toOnec()
    {
        Artisan::call('order:report');
        Artisan::call('order:report-return');
        dump('отправлен');


        return redirect()->back();
    }

}
