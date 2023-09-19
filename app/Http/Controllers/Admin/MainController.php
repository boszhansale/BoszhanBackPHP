<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Counteragent;
use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Cache;
use Carbon\Carbon;
use Illuminate\View\View;

class MainController extends Controller
{
    public function index(): View
    {
        $driverCount = Cache::remember('driver_count', now()->addDay(), function () {
            return User::join('user_roles', 'user_roles.user_id', 'users.id')
                ->where('user_roles.role_id', 2)
                ->count();
        });

        // Cache the salesrep count
        $salesrepCount = Cache::remember('salesrep_count', now()->addDay(), function () {
            return User::join('user_roles', 'user_roles.user_id', 'users.id')
                ->where('user_roles.role_id', 1)
                ->count();
        });

        // Cache the order count
        $orderCount = Cache::remember('order_count', now()->addDay(), function () {
            return Order::count();
        });

        // Cache the store count
        $storeCount = Cache::remember('store_count', now()->addDay(), function () {
            return Store::count();
        });

        // Cache the counteragent count
        $counteragentCount = Cache::remember('counteragent_count', now()->addDay(), function () {
            return Counteragent::count();
        });

        // Cache the product count
        $productCount = Cache::remember('product_count', now()->addDay(), function () {
            return Product::count();
        });

        $monthName = Carbon::now()->monthName;

        // Cache the top salesreps by order
        $topSalesrepsByOrder = Cache::remember('top_salesreps_by_order', now()->addDay(), function () {
            return User::join('orders', 'orders.salesrep_id', 'users.id')
                ->join('user_roles', 'user_roles.user_id', 'users.id')
                ->where('user_roles.role_id', 1)
                ->whereDate('orders.created_at', '>=', Carbon::now()->startOfMonth())
                ->limit(10)
                ->groupBy('users.id')
                ->selectRaw('users.*,COUNT(orders.id) as order_count,SUM(orders.purchase_price) as order_price')
                ->orderBy('order_price', 'desc')
                ->orderBy('order_count', 'desc')
                ->get();
        });
//        $brands = Brand::join('categories','categories.brand_id','brands.id')
//            ->join('products','products.category_id','categories.id')
//            ->join();
        $topProducts = Cache::remember('top_products', now()->addDay(), function () {

            return Product::join('baskets', 'baskets.product_id', 'products.id')
                ->join('categories', 'categories.id', 'products.category_id')
                ->join('brands', 'brands.id', 'categories.brand_id')
                ->selectRaw('products.*,COUNT(baskets.id) as basket_count,SUM(baskets.count) as count,SUM(baskets.all_price) as all_price,brands.name as brand_name,categories.name as category_name')
                ->where('baskets.type', 0)
                ->whereDate('baskets.created_at', '>=', Carbon::now()->startOfMonth())
                ->orderBy('all_price', 'desc')
                ->orderBy('count', 'desc')
                ->groupBy('products.id')
                ->limit(10)
                ->get();
        });
        $months = Cache::remember('months', now()->addDay(), function () {
            $data = [];
            for ($i = 6; $i >= 0; $i--) {
                $data[] = Carbon::now()->subMonths($i)->monthName . ' ' . Carbon::now()->subMonths($i)->year;
            }

            return $data;
        });
        $monthReturnPrices = Cache::remember('monthReturnPrices', now()->addDay(), function () {
            $data = [];
            for ($i = 6; $i >= 0; $i--) {
                $data[] = (int)Order::whereDate('created_at', '>=', Carbon::now()->subMonths($i)->startOfMonth())
                    ->whereDate('created_at', '<=', Carbon::now()->subMonths($i)->endOfMonth())
                    ->sum('return_price');
            }

            return $data;
        });;
        $monthPurchasePrices = Cache::remember('monthPurchasePrices', now()->addDay(), function () {
            $data = [];
            for ($i = 6; $i >= 0; $i--) {
                $data[] = (int)Order::whereDate('created_at', '>=', Carbon::now()->subMonths($i)->startOfMonth())
                    ->whereDate('created_at', '<=', Carbon::now()->subMonths($i)->endOfMonth())
                    ->sum('purchase_price');
            }

            return $data;
        });

        $weeks = Cache::remember('weeks', now()->addDay(), function () {
            $startWeekDay = Carbon::now()->startOfWeek();
            $data = [];
            for ($i = 0; $i <= 6; $i++) {
                $data[] = $startWeekDay->dayName;
                $startWeekDay->addDay();
            }

            return $data;
        });
        $weekPurchasePrices = Cache::remember('weekPurchasePrices', now()->addDay(), function () {
            $startWeekDay = Carbon::now()->startOfWeek();
            $data = [];
            for ($i = 0; $i <= 6; $i++) {
                $data[] = (int)Order::whereDate('created_at', $startWeekDay)
                    ->sum('purchase_price');
                $startWeekDay->addDay();
            }

            return $data;
        });
        $weekReturnPrices = Cache::remember('weekReturnPrices', now()->addDay(), function () {
            $startWeekDay = Carbon::now()->startOfWeek();
            $data = [];
            for ($i = 0; $i <= 6; $i++) {
                $data[] = (int)Order::whereDate('created_at', $startWeekDay)
                    ->sum('return_price');
                $startWeekDay->addDay();
            }

            return $data;
        });


        return view('admin.main', compact('monthName', 'weeks', 'weekPurchasePrices', 'weekReturnPrices', 'monthPurchasePrices', 'monthReturnPrices', 'productCount', 'months', 'driverCount', 'productCount', 'counteragentCount', 'topProducts', 'salesrepCount', 'orderCount', 'storeCount', 'topSalesrepsByOrder'));
    }
}
