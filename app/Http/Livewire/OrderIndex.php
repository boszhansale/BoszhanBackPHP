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
    public $salesrep_id = 'all';
    public $driver_id = 'all';
    public $status_id = 'all';
    public $start_date;
    public $end_date;

    public function render()
    {
        return view('livewire.order-index', [
            'drivers' => User::join('user_roles', 'user_roles.user_id', 'users.id')
                ->where('role_id', 2)
                ->orderBy('users.name')
                ->get('users.*'),
            'salesreps' => User::join('user_roles', 'user_roles.user_id', 'users.id')
                ->where('role_id', 1)
                ->orderBy('users.name')
                ->get('users.*'),
            'statuses' => Status::all(),

            'orders' => Order::with(['store', 'salesrep', 'driver'])
                ->where('orders.id', 'LIKE', $this->search . '%')
                ->when($this->status_id != 'all', function ($query) {
                    return $query->where('orders.status_id', $this->status_id);
                })
                ->when($this->driver_id != 'all', function ($query) {
                    return $query->where('orders.driver_id', $this->driver_id);
                })
                ->when($this->salesrep_id != 'all', function ($query) {
                    return $query->where('orders.salesrep_id', $this->salesrep_id);
                })
                ->when($this->start_date, function ($query) {
                    return $query->whereDate('orders.delivery_date', '>=', $this->start_date);
                })
                ->when($this->end_date, function ($query) {
                    return $query->whereDate('orders.delivery_date', '<=', $this->end_date);
                })
                ->latest()
                ->paginate(50),

            'order_count' => Order::when($this->salesrep_id != 'all', function ($q) {
                    return $q->where('salesrep_id', $this->salesrep_id);
                })
                ->when($this->status_id != 'all', function ($query) {
                    return $query->where('orders.status_id', $this->status_id);
                })
                ->when($this->driver_id != 'all', function ($query) {
                    return $query->where('orders.driver_id', $this->driver_id);
                })
                ->when($this->salesrep_id != 'all', function ($query) {
                    return $query->where('orders.salesrep_id', $this->salesrep_id);
                })
                ->when($this->start_date, function ($query) {
                    return $query->whereDate('orders.delivery_date', '>=', $this->start_date);
                })
                ->when($this->end_date, function ($query) {
                    return $query->whereDate('orders.delivery_date', '<=', $this->end_date);
                })
                ->count(),
            'order_purchase_price' => Order::when($this->salesrep_id != 'all', function ($q) {
                    return $q->where('salesrep_id', $this->salesrep_id);
                })->when($this->status_id != 'all', function ($query) {
                    return $query->where('orders.status_id', $this->status_id);
                })
                ->when($this->driver_id != 'all', function ($query) {
                    return $query->where('orders.driver_id', $this->driver_id);
                })
                ->when($this->salesrep_id != 'all', function ($query) {
                    return $query->where('orders.salesrep_id', $this->salesrep_id);
                })
                ->when($this->start_date, function ($query) {
                    return $query->whereDate('orders.delivery_date', '>=', $this->start_date);
                })
                ->when($this->end_date, function ($query) {
                    return $query->whereDate('orders.delivery_date', '<=', $this->end_date);
                })->sum('purchase_price'),

            'order_return_price' => Order::when($this->salesrep_id != 'all', function ($q) {
                return $q->where('salesrep_id', $this->salesrep_id);
            })->when($this->status_id != 'all', function ($query) {
                return $query->where('orders.status_id', $this->status_id);
            })
                ->when($this->driver_id != 'all', function ($query) {
                    return $query->where('orders.driver_id', $this->driver_id);
                })
                ->when($this->salesrep_id != 'all', function ($query) {
                    return $query->where('orders.salesrep_id', $this->salesrep_id);
                })
                ->when($this->start_date, function ($query) {
                    return $query->whereDate('orders.delivery_date', '>=', $this->start_date);
                })
                ->when($this->end_date, function ($query) {
                    return $query->whereDate('orders.delivery_date', '<=', $this->end_date);
                })->sum('return_price'),

            'order_return_count' => Order::when($this->salesrep_id != 'all', function ($q) {
                return $q->where('salesrep_id', $this->salesrep_id);
            })->when($this->status_id != 'all', function ($query) {
                return $query->where('orders.status_id', $this->status_id);
            })
                ->when($this->driver_id != 'all', function ($query) {
                    return $query->where('orders.driver_id', $this->driver_id);
                })
                ->when($this->salesrep_id != 'all', function ($query) {
                    return $query->where('orders.salesrep_id', $this->salesrep_id);
                })
                ->when($this->start_date, function ($query) {
                    return $query->whereDate('orders.delivery_date', '>=', $this->start_date);
                })
                ->when($this->end_date, function ($query) {
                    return $query->whereDate('orders.delivery_date', '<=', $this->end_date);
                })
                ->where('orders.return_price','>',0)
                ->count(),


        ]);
    }
}
