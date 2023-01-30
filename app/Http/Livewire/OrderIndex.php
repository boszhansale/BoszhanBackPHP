<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\Status;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class OrderIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;

    public $salesrep_id;

    public $driver_id;

    public $status_id;

    public $start_delivery_date;
    public $end_delivery_date;

    public $start_created_at;
    public $end_created_at;

    public function render()
    {
        $query = Order::query()
            ->join('stores', 'stores.id', 'orders.store_id')
            ->with(['store', 'salesrep', 'driver'])
            ->when($this->search, function ($q) {
                return $q->where('orders.id', 'LIKE', $this->search . '%');
            })
            ->when(\Auth::user()->isSupervisor(), function ($q) {
                return $q->whereIn('orders.salesrep_id', \Auth::user()->supervisorsSalesreps()->pluck('users.id')->toArray());
            })
            ->when($this->status_id, function ($q) {
                return $q->where('orders.status_id', $this->status_id);
            })
            ->when($this->driver_id, function ($q) {
                return $q->where('orders.driver_id', $this->driver_id);
            })
            ->when($this->salesrep_id, function ($q) {
                return $q->where('orders.salesrep_id', $this->salesrep_id);
            })
            ->when($this->start_delivery_date, function ($q) {
                return $q->whereDate('orders.delivery_date', '>=', $this->start_delivery_date);
            })
            ->when($this->end_delivery_date, function ($q) {
                return $q->whereDate('orders.delivery_date', '<=', $this->end_delivery_date);
            })
            ->when($this->start_created_at, function ($q) {
                return $q->whereDate('orders.created_at', '>=', $this->start_created_at);
            })
            ->when($this->end_created_at, function ($q) {
                return $q->whereDate('orders.created_at', '<=', $this->end_created_at);
            })
            ->latest()
            ->select('orders.*');

        return view('admin.order.index_live', [
            'drivers' => User::query()
                ->where('role_id', 2)
                ->where('users.status', 1)
                ->orderBy('users.name')
                ->get('users.*'),
            'salesreps' => User::query()
                ->where('role_id', 1)
                ->where('status', 1)
                ->orderBy('users.name')
                ->get('users.*'),
            'statuses' => Status::all(),

            'orders' => $query->clone()->withTrashed()->paginate(50),
            'query' => $query,

//            'order_count' => $query->clone()->count(),
//            'order_legal_count' => $query->clone()->whereNotNull('stores.counteragent_id')->count(),
//            'order_individual_count' => $query->clone()->whereNull('stores.counteragent_id')->count(),
//
//
            'order_purchase_price' => $query->clone()->sum('orders.purchase_price'),
            'order_return_price' => $query->clone()->sum('orders.return_price'),
//            'order_return_count' => $query->clone()
//                ->where('orders.return_price', '>', 0)
//                ->count(),

        ]);
    }
}
