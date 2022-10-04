<?php

namespace App\Http\Livewire\Cashier;

use App\Models\Order;
use App\Models\Product;
use App\Models\Status;
use App\Models\Store;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class OrderStatistic extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $status_id;

    public $start_date_return_order_store;

    public $end_date_return_order_store ;

    public $start_date_return_order_salesrep;

    public $end_date_return_order_salesrep;

    public $start_date_return_order_product;

    public $end_date_return_order_product;

    public function mount()
    {
        $this->start_date_return_order_store = now()->subMonth()->format('Y-m-d');
        $this->start_date_return_order_salesrep = now()->subMonth()->format('Y-m-d');
        $this->start_date_return_order_product = now()->subMonth()->format('Y-m-d');
        $this->end_date_return_order_salesrep = now()->format('Y-m-d');
        $this->end_date_return_order_store = now()->format('Y-m-d');
        $this->end_date_return_order_product = now()->format('Y-m-d');
    }

    public function render()
    {
        $orderStores = Store::query()
            ->join('orders','orders.store_id','stores.id')
            ->when($this->start_date_return_order_store,function ($q){
                return $q->whereDate('orders.created_at','>=',$this->start_date_return_order_store);
            })
            ->when($this->end_date_return_order_store,function ($q){
                return $q->whereDate('orders.created_at','<=',$this->end_date_return_order_store);
            })
            ->groupBy('stores.id')
            ->selectRaw('stores.*,COUNT(orders.id) as orders_count,SUM(orders.purchase_price) as sum')
            ->latest('orders_count')
            ->limit(10)
            ->get();
        $returnOrderStores = Store::query()
            ->join('orders','orders.store_id','stores.id')
            ->when($this->start_date_return_order_store,function ($q){
                return $q->whereDate('orders.created_at','>=',$this->start_date_return_order_store);
            })
            ->when($this->end_date_return_order_store,function ($q){
                return $q->whereDate('orders.created_at','<=',$this->end_date_return_order_store);
            })
            ->where('orders.return_price','>',0)
            ->groupBy('stores.id')
            ->selectRaw('stores.*,COUNT(orders.id) as orders_count,SUM(orders.return_price) as sum')
            ->latest('orders_count')
            ->limit(10)
            ->get();
        $orderSalesreps = User::query()
            ->join('orders','orders.salesrep_id','users.id')
            ->when($this->start_date_return_order_salesrep,function ($q){
                return $q->whereDate('orders.created_at','>=',$this->start_date_return_order_salesrep);
            })
            ->when($this->end_date_return_order_salesrep,function ($q){
                return $q->whereDate('orders.created_at','<=',$this->end_date_return_order_salesrep);
            })
            ->where('orders.return_price','>',0)
            ->groupBy('users.id')
            ->selectRaw('users.*,COUNT(orders.id) as orders_count,SUM(orders.purchase_price) as sum')
            ->latest('orders_count')
            ->limit(10)
            ->get();
        $returnOrderSalesreps = User::query()
            ->join('orders','orders.salesrep_id','users.id')
            ->when($this->start_date_return_order_salesrep,function ($q){
                return $q->whereDate('orders.created_at','>=',$this->start_date_return_order_salesrep);
            })
            ->when($this->end_date_return_order_salesrep,function ($q){
                return $q->whereDate('orders.created_at','<=',$this->end_date_return_order_salesrep);
            })
            ->where('orders.return_price','>',0)
            ->groupBy('users.id')
            ->selectRaw('users.*,COUNT(orders.id) as orders_count,SUM(orders.return_price) as sum')
            ->latest('orders_count')
            ->limit(10)
            ->get();

        $orderProducts = Product::query()
            ->join('baskets','baskets.product_id','products.id')
            ->join('orders','orders.id','baskets.order_id')
            ->when($this->start_date_return_order_product,function ($q){
                return $q->whereDate('orders.created_at','>=',$this->start_date_return_order_product);
            })
            ->when($this->end_date_return_order_product,function ($q){
                return $q->whereDate('orders.created_at','<=',$this->end_date_return_order_product);
            })
            ->groupBy('products.id')
            ->selectRaw('products.*,COUNT(orders.id) as orders_count,SUM(orders.purchase_price) as sum')
            ->latest('orders_count')
            ->limit(10)
            ->get();
        $returnOrderProducts = Product::query()
            ->join('baskets','baskets.product_id','products.id')
            ->join('orders','orders.id','baskets.order_id')
            ->when($this->start_date_return_order_product,function ($q){
                return $q->whereDate('orders.created_at','>=',$this->start_date_return_order_product);
            })
            ->when($this->end_date_return_order_product,function ($q){
                return $q->whereDate('orders.created_at','<=',$this->end_date_return_order_product);
            })
            ->where('orders.return_price','>',0)
            ->groupBy('products.id')
            ->selectRaw('products.*,COUNT(orders.id) as orders_count,SUM(orders.return_price) as sum')
            ->latest('orders_count')
            ->limit(10)
            ->get();
        return view('cashier.order.statistic_live',compact('returnOrderStores','returnOrderProducts','returnOrderSalesreps','orderProducts','orderSalesreps','orderStores'));
    }
}
