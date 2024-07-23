<?php

namespace App\Http\Controllers\Admin;

use App\Exports\Excel\RefundExport;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RefundController extends Controller
{
    public function index(Request $request)
    {
        $salesrep_id = $request->get('salesrep_id');
        $store_id = $request->get('store_id');
        $counteragent_id = $request->get('counteragent_id');
        return view('admin.refund.index', compact('salesrep_id', 'store_id', 'counteragent_id'));
    }

    public function excel(Request $request)
    {

        $query = Order::query()
            ->join('stores', 'stores.id', 'orders.store_id')
            ->join('baskets', 'baskets.order_id', 'orders.id')
            ->join('products', 'baskets.product_id', 'products.id')
            ->where('baskets.type', 0)
            ->whereNull('stores.deleted_at')
            ->whereNull('baskets.deleted_at')
            ->when($request->get('storeId'), function ($q) {
                return $q->where('orders.store_id', \request('storeId'));
            })
            ->when($request->get('salesrepId'), function ($q) {
                return $q->where('orders.salesrep_id', \request('salesrepId'));
            })
            ->when($request->get('start_created_at'), function ($q) {
                return $q->whereDate('orders.created_at', '>=', \request('start_created_at'));
            })
            ->when($request->get('end_created_at'), function ($q) {
                return $q->whereDate('orders.created_at', '<=', \request('end_created_at'));
            });

        $refunds = Order::query()
            ->join('stores', 'stores.id', 'orders.store_id')
            ->join('baskets', 'baskets.order_id', 'orders.id')
            ->join('products', 'baskets.product_id', 'products.id')
            ->join('reason_refunds', 'baskets.reason_refund_id', 'reason_refunds.id')
            ->where('baskets.type', 1)
            ->whereNull('stores.deleted_at')
            ->whereNull('baskets.deleted_at')
            ->when($request->get('search'), function ($q) {
                return $q->where('products.id', 'LIKE', '%' . \request('search') . '%');
            })
            ->when($request->get('storeId'), function ($q) {
                return $q->where('orders.store_id', \request('storeId'));
            })
            ->when($request->get('salesrepId'), function ($q) {
                return $q->where('orders.salesrep_id', \request('salesrepId'));
            })
            ->when($request->get('start_created_at'), function ($q) {
                return $q->whereDate('orders.created_at', '>=', \request('start_created_at'));
            })
            ->when($request->get('end_created_at'), function ($q) {
                return $q->whereDate('orders.created_at', '<=', \request('end_created_at'));
            })
            ->latest()
            ->select(['orders.*', 'products.id as product_id', 'products.name', 'baskets.count', 'baskets.price', 'baskets.all_price', 'reason_refunds.title', 'products.measure'])
            ->with(['store.counteragent', 'salesrep'])
            ->get();


        return Excel::download(new RefundExport($refunds, $query), 'refund_' . request('start_created_at') . '_' . request('end_created_at') . '.xlsx');
    }

}
