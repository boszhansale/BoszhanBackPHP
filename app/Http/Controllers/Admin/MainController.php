<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Counteragent;
use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MainController extends Controller
{

    function index():View
    {
        $driverCount = User::join('user_roles','user_roles.user_id','users.id')
            ->where('user_roles.role_id',2)
            ->count();
        $salesrepCount = User::join('user_roles','user_roles.user_id','users.id')
            ->where('user_roles.role_id',1)
            ->count();

        $orderCount = Order::count();
        $storeCount = Store::count();
        $counteragentCount = Counteragent::count();
        $productCount = Product::count();
        $monthName = Carbon::now()->monthName;

        $topSalesrepsByOrder = User::join('orders','orders.salesrep_id','users.id')
            ->join('user_roles','user_roles.user_id','users.id')
            ->where('user_roles.role_id',1)
            ->whereDate('orders.created_at','>=',Carbon::now()->startOfMonth())
            ->limit(10)
            ->groupBy('users.id')
            ->selectRaw('users.*,COUNT(orders.id) as order_count,SUM(orders.purchase_price) as order_price')
            ->orderBy('order_price','desc')
            ->orderBy('order_count','desc')
            ->get();

//        $brands = Brand::join('categories','categories.brand_id','brands.id')
//            ->join('products','products.category_id','categories.id')
//            ->join();
        $topProducts = Product::join('baskets','baskets.product_id','products.id')
            ->join('categories','categories.id','products.category_id')
            ->join('brands','brands.id','categories.brand_id')
            ->selectRaw('products.*,COUNT(baskets.id) as basket_count,SUM(baskets.count) as count,SUM(baskets.all_price) as all_price,brands.name as brand_name,categories.name as category_name')
            ->where('baskets.type',0)
            ->whereDate('baskets.created_at','>=',Carbon::now()->startOfMonth())
            ->orderBy('all_price','desc')
            ->orderBy('count','desc')
            ->groupBy('products.id')
            ->limit(10)
            ->get();

        $months = [];
        $monthReturnPrices = [];
        $monthPurchasePrices = [];

        $weeks = [];
        $weekPurchasePrices = [];
        $weekReturnPrices = [];

        for ($i = 6;$i >= 0;$i--)
        {
            $months[]= Carbon::now()->subMonths($i)->monthName .' '. Carbon::now()->subMonths($i)->year ;
            $monthPurchasePrices[] = (int) Order::whereDate('created_at','>=',Carbon::now()->subMonths($i)->startOfMonth())
                ->whereDate('created_at','<=',Carbon::now()->subMonths($i)->endOfMonth())
                ->sum('purchase_price');
            $monthReturnPrices[] = (int)Order::whereDate('created_at','>=',Carbon::now()->subMonths($i)->startOfMonth())
                ->whereDate('created_at','<=',Carbon::now()->subMonths($i)->endOfMonth())
                ->sum('return_price');
        }
        $startWeekDay = Carbon::now()->startOfWeek();
        for ($i = 0;$i <= 6;$i++)
        {
            $weeks[] = $startWeekDay->dayName;
            $weekPurchasePrices[] = (int) Order::whereDate('created_at',$startWeekDay)
                ->sum('purchase_price');
            $weekReturnPrices[] = (int)Order::whereDate('created_at',$startWeekDay)
                ->sum('return_price');

            $startWeekDay->addDay();
        }

        return view('admin.main',compact('monthName','weeks','weekPurchasePrices','weekReturnPrices','monthPurchasePrices','monthReturnPrices','productCount','months','driverCount','productCount','counteragentCount','topProducts','salesrepCount','orderCount','storeCount','topSalesrepsByOrder'));
    }
}
