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
        $query = Order::with(['store', 'salesrep', 'driver'])
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
            ->latest();
        return view('admin.order.index_index', [
            'drivers' => User::join('user_roles', 'user_roles.user_id', 'users.id')
                ->where('role_id', 2)
                ->orderBy('users.name')
                ->get('users.*'),
            'salesreps' => User::join('user_roles', 'user_roles.user_id', 'users.id')
                ->where('role_id', 1)
                ->orderBy('users.name')
                ->get('users.*'),
            'statuses' => Status::all(),

            'orders' => $query->clone()->withTrashed()->paginate(50),
            'order_count' => $query->clone()->count(),
            'order_purchase_price' => $query->clone()->sum('purchase_price'),
            'order_return_price' => $query->clone()->sum('return_price'),
            'order_return_count' => $query->clone()
                ->where('orders.return_price','>',0)
                ->count(),


        ]);
    }
}
