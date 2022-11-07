<?php

namespace App\Http\Livewire;

use App\Models\Store;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class StoreDriverMove extends Component
{
    use WithPagination;

    public $from_driver_id;

    public $to_driver_id;

    public function render()
    {
        return view('admin.store.driver_move_live', [
            'from_drivers' => User::query()
                ->where('users.role_id', 2)
                ->where('users.status', 1)
                ->join('stores', 'stores.driver_id', 'users.id')
                ->orderBy('users.name')
                ->selectRaw('users.*,COUNT(stores.id) store_count')
                ->groupBy('users.id')
                ->having('store_count', '>=', 1)
                ->get(),
            'to_drivers' => User::query()
                ->where('role_id', 2)
                ->where('status', 1)
                ->orderBy('users.name')
                ->get('users.*'),

            'from_driver_stores_count' => $this->from_driver_id ? Store::whereDriverId($this->from_driver_id)->count(
            ) : 0,
            'to_driver_stores_count' => $this->to_driver_id ? Store::whereDriverId($this->to_driver_id)->count() : 0,
        ]);
    }
}
