<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class RiderIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;

    public $start_date;
    public $end_date;
    public $riders;
    public $riderId;

    public function render()
    {
        return view('admin.user.riders_live', [
            'orders' => Order::query()
                ->whereNotNull('rider_id')
                ->when($this->start_date, function ($q) {
                    $q->whereDate('orders.delivery_date', '>=', $this->start_date);
                })
                ->when($this->end_date, function ($q) {
                    $q->whereDate('orders.delivery_date', '<=', $this->end_date);
                })
                ->when($this->riderId, function ($q) {
                    $q->where('orders.rider_id', $this->riderId);
                })
                ->join('baskets', 'baskets.order_id', 'orders.id')
                ->join('products', 'products.id', 'baskets.product_id')
                ->select([
                    'orders.id',
                    'products.name',
                    'products.measure',
                    'orders.delivery_date',
                    'orders.driver_id',
                    'orders.rider_id',
                    'orders.store_id',
                    'baskets.count',
                    'baskets.type',
                ])
                ->orderBy('orders.id', 'desc')
                ->with(['rider', 'driver', 'store'])
                ->paginate(25),
        ]);
    }

    public function mount()
    {
        $this->start_date = Carbon::now()->format('Y-m-d');
        $this->end_date = Carbon::now()->format('Y-m-d');

        $this->riders = User::query()
            ->where('status', 1)
            ->where('users.role_id', 10)
            ->orderBy('users.name')
            ->get();
    }

    public function statusChange($userId, $status)
    {
        User::whereId($userId)->update([
            'status' => $status,
        ]);
    }
}
