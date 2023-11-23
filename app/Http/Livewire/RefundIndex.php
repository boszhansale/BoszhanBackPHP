<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\Status;
use App\Models\User;
use Cache;
use Livewire\Component;
use Livewire\WithPagination;

class RefundIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;
    public $salesrepId;
    public $storeId;

    public $start_created_at;
    public $end_created_at;

    public function render()
    {
        $query = Order::query()
            ->join('stores', 'stores.id', 'orders.store_id')
            ->join('baskets', 'baskets.order_id', 'orders.id')
            ->join('products', 'baskets.product_id', 'products.id')
            ->join('reason_refunds', 'baskets.reason_refund_id', 'reason_refunds.id')
            ->where('baskets.type', 1)
            ->when($this->search, function ($q) {
                return $q->where('products.name', 'LIKE', '%' . $this->search . '%');
            })
            ->when($this->storeId, function ($q) {
                return $q->where('orders.store_id', $this->storeId);
            })
            ->when($this->salesrepId, function ($q) {
                return $q->where('orders.salesrep_id', $this->salesrepId);
            })
            ->when($this->start_created_at, function ($q) {
                return $q->whereDate('orders.created_at', '>=', $this->start_created_at);
            })
            ->when($this->end_created_at, function ($q) {
                return $q->whereDate('orders.created_at', '<=', $this->end_created_at);
            })
            ->latest()
            ->select(['orders.*', 'products.name', 'baskets.count', 'baskets.price', 'reason_refunds.title', 'products.measure'])
            ->with(['store.counteragent', 'salesrep']);

        return view('admin.refund.index_live', [
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
            'refunds' => $query->paginate(50),
        ]);
    }

    public function mount()
    {
        $this->start_created_at = now()->format('Y-m-d');
    }
}
