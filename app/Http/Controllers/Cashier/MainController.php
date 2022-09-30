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

        return \view('cashier.counteragent.show',compact('counteragent'));
    }
    public function order(Counteragent $counteragent)
    {

        return \view('cashier.counteragent.order',compact('counteragent'));
    }
}
