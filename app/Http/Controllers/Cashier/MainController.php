<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Counteragent;
use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\View\View;

class MainController extends Controller
{
    public function index(): View
    {
        return view('cashier.main');
    }
    public function show(Counteragent $counteragent)
    {
        $orders = Order::query()
            ->join('stores','stores.id','orders.store_id')
            ->where('stores.counteragent_id',$counteragent->id)
            ->whereIn('payment_status_id',[2,3])
            ->where('status_id',3)
            ->orderBy('orders.id')
            ->select('orders.*')
            ->get();
        return \view('cashier.counteragent.show',compact('counteragent','orders'));
    }

}
