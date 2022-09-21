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
            'fromDrivers' => User::join('user_roles', 'user_roles.user_id', 'users.id')
                ->where('user_roles.role_id',2)
                ->where('users.status',1)
                ->orderBy('users.name')
                ->groupBy('users.id')
                ->get('users.*'),

            'toDrivers' => User::join('user_roles', 'user_roles.user_id', 'users.id')
                ->where('user_roles.role_id',2)
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
