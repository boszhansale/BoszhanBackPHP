<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class Edi extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;


    public function render()
    {
        $query = Order::query()
            ->whereNotNull('number')
            ->whereDate('created_at', now())
            ->with(['store', 'salesrep', 'driver'])
            ->whereDoesntHave('report')
            ->latest()
            ->select('orders.*');

        return view('admin.order.edi_live', [
            'orders' => $query->clone()->get(),
//
            'order_purchase_price' => $query->clone()->sum('orders.purchase_price'),
            'order_return_price' => $query->clone()->sum('orders.return_price'),

        ]);
    }

    function delete($id)
    {
        Order::where('id', $id)->forceDelete();
    }
}
