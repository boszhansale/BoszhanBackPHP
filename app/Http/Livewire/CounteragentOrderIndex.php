<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\Status;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class CounteragentOrderIndex extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;
    public $counteragent_id;
    public $status_id = 'all';
    public $start_date;
    public $end_date;

    function mount($counteragent_id){
        $this->counteragent_id = $counteragent_id;
    }
    public function render()
    {

        $query = Order::with(['store', 'salesrep', 'driver'])
            ->join('stores','stores.id','orders.store_id')
            ->where('stores.counteragent_id',$this->counteragent_id)
            ->where('orders.id', 'LIKE', $this->search . '%')
            ->when($this->status_id != 'all', function ($query) {
                return $query->where('orders.status_id', $this->status_id);
            })

            ->when($this->start_date, function ($query) {
                return $query->whereDate('orders.delivery_date', '>=', $this->start_date);
            })
            ->when($this->end_date, function ($query) {
                return $query->whereDate('orders.delivery_date', '<=', $this->end_date);
            })
            ->select('orders.*')
            ->latest();

        return view('admin.counteragent.order_live', [
            'statuses' => Status::all(),
            'orders' => $query->clone()->paginate(50),
            'order_count' =>  $query->clone()->count(),
            'order_purchase_price' =>  $query->clone()->sum('purchase_price'),
            'order_return_price' => $query->clone()->sum('return_price'),
            'order_return_count' => $query->clone()
                ->where('orders.return_price','>',0)
                ->count(),


        ]);
    }
}
