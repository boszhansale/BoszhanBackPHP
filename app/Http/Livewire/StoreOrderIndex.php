<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\Status;
use Livewire\Component;
use Livewire\WithPagination;

class StoreOrderIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;

    public $store_id;

    public $status_id = 'all';

    public $start_date;

    public $end_date;

    public function mound($store_id)
    {
        $this->store_id = $store_id;
    }

    public function render()
    {
        $query = Order::with(['store', 'salesrep', 'driver'])
            ->where('store_id', $this->store_id)
            ->where('orders.id', 'LIKE', $this->search.'%')
            ->when($this->status_id != 'all', function ($query) {
                return $query->where('orders.status_id', $this->status_id);
            })

            ->when($this->start_date, function ($query) {
                return $query->whereDate('orders.delivery_date', '>=', $this->start_date);
            })
            ->when($this->end_date, function ($query) {
                return $query->whereDate('orders.delivery_date', '<=', $this->end_date);
            })
            ->latest();

        return view('admin.store.order_live', [
            'statuses' => Status::all(),
            'orders' => $query->clone()->paginate(50),
            'order_count' => $query->clone()->count(),
            'order_purchase_price' => $query->clone()->sum('purchase_price'),
            'order_return_price' => $query->clone()->sum('return_price'),
            'order_return_count' => $query->clone()
                ->where('orders.return_price', '>', 0)
                ->count(),
        ]);
    }
}
