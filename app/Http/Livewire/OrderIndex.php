<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\Status;
use App\Models\User;
use Cache;
use Livewire\Component;
use Livewire\WithPagination;

class OrderIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;
    public $salesrepId;
    public $driverId;
    public $storeId;
    public $statusId;
    public $counteragentId;

    public $start_delivery_date;
    public $end_delivery_date;

    public $start_created_at;
    public $end_created_at;

    public function render()
    {


        $query = Order::query()
            ->join('stores', 'stores.id', 'orders.store_id')
            ->when($this->search, function ($q) {
                return $q->where('orders.id', 'LIKE', $this->search . '%');
            })
            ->when(\Auth::user()->isSupervisor(), function ($q) {
                return $q->whereIn('orders.salesrep_id', \Auth::user()->supervisorsSalesreps()->pluck('users.id')->toArray());
            })
            ->when($this->statusId, function ($q) {
                return $q->where('orders.status_id', $this->statusId);
            })
            ->when($this->driverId, function ($q) {
                return $q->where('orders.driver_id', $this->driverId);
            })
            ->when($this->storeId, function ($q) {
                return $q->where('orders.store_id', $this->storeId);
            })
            ->when($this->counteragentId, function ($q) {
                return $q->where('stores.counteragent_id', $this->counteragentId);
            })
            ->when($this->salesrepId, function ($q) {
                return $q->where('orders.salesrep_id', $this->salesrepId);
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
            'drivers' => Cache::remember('drivers', 60, function () {
                return User::query()
                    ->where('role_id', 2)
                    ->where('users.status', 1)
                    ->orderBy('users.name')
                    ->get('users.*');
            }),
            'salesreps' => Cache::remember('salesreps', 60, function () {
                return User::query()
                    ->where('role_id', 1)
                    ->where('status', 1)
                    ->orderBy('users.name')
                    ->get('users.*');
            }),
            'statuses' => Cache::rememberForever('statuses', function () {
                return Status::all();
            }),

            'orders' => $query->clone()
                ->with(['store', 'salesrep', 'driver', 'store.counteragent', 'paymentType', 'paymentStatus'])
                ->withTrashed()
                ->paginate(100),
//            'query' => $query,
//
//
//            'order_purchase_price' => $query->clone()->sum('orders.purchase_price'),
//            'order_return_price' => $query->clone()->sum('orders.return_price'),
//            'order_return_count' => $query->clone()->where('orders.return_price', '>', 0)->count(),
//
//            'count' => $query->clone()->count(),
//            'closed_count' => $query->clone()->whereNotNull('delivered_date')->count(),

        ]);
    }

    public function mount()
    {

    }
}
