<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\Store;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class OrderDriverMove extends Component
{
    use WithPagination;

    public $from_driver_id ;
    public $to_driver_id ;

    public function render()
    {
        return view('admin.order.driver_move_live', [
            'fromDrivers' => User::query()
                ->where('users.role_id',2)
                ->where('users.status',1)
                ->orderBy('users.name')
                ->groupBy('users.id')
                ->get('users.*'),

            'toDrivers' => User::query()
                ->where('users.role_id',2)
                ->where('users.status',1)
                ->orderBy('users.name')
                ->get('users.*'),

            'orders' => Order::whereDriverId($this->from_driver_id)
                ->latest('id')
                ->where('orders.delivery_date','>=',now()->subDay())
                ->get(),
        ]);
    }
}
