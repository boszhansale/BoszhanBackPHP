<?php

namespace App\Http\Livewire\Cashier;

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

    public $start_date;

    public $end_date;

    public function render()
    {
        $query = Order::with(['store', 'salesrep', 'driver'])
            ->when($this->search, function ($q) {
                return $q->where('orders.id', 'LIKE', $this->search.'%');
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
            ->when($this->start_date, function ($q) {
                return $q->whereDate('orders.delivery_date', '>=', $this->start_date);
            })
            ->when($this->end_date, function ($q) {
                return $q->whereDate('orders.delivery_date', '<=', $this->end_date);
            })
            ->latest();

        return view('cashier.order.index_live', [
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
            'order_count' => $query->clone()->count(),
            'order_purchase_price' => $query->clone()->sum('purchase_price'),
            'order_return_price' => $query->clone()->sum('return_price'),
            'order_return_count' => $query->clone()
                ->where('orders.return_price', '>', 0)
                ->count(),

        ]);
    }
}
