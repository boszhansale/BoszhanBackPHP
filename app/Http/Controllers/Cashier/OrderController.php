<?php

namespace App\Http\Controllers\Cashier;

use App\Exports\Excel\OrderExcelExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrderUpdateRequest;
use App\Models\Counteragent;
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

        return view('cashier.order.index', compact('query'));
    }

    public function show($orderId)
    {
        $order = Order::withTrashed()->find($orderId);

        return view('cashier.order.show', compact('order'));
    }

    public function order(Counteragent $counteragent)
    {

        return \view('cashier.counteragent.order',compact('counteragent'));
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
        return \view('cashier.order.statistic');
    }

    public function history(Order $order)
    {
        return \view('cashier.order.history',compact('order'));
    }
}
