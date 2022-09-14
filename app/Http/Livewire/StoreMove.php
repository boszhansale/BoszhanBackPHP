<?php

namespace App\Http\Livewire;

use App\Models\Store;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class StoreMove extends Component
{
    use WithPagination;

    public $from_salesrep_id = '';

    public $to_salesrep_id = '';

    public function render()
    {
        return view('livewire.store-move', [
            'from_salesreps' => User::join('user_roles', 'user_roles.user_id', 'users.id')
                ->join('stores', 'stores.salesrep_id', 'users.id')
                 ->orderBy('users.name')
                ->selectRaw('users.*,COUNT(stores.id) store_count')
                ->groupBy('users.id')
                ->having('store_count', '>=', 1)
                 ->get(),
            'to_salesreps' => User::join('user_roles', 'user_roles.user_id', 'users.id')
                ->orderBy('users.name')
                 ->get('users.*'),

            'from_salesrep_stores_count' => Store::whereSalesrepId($this->from_salesrep_id)->count(),
            'to_salesrep_stores_count' => Store::whereSalesrepId($this->to_salesrep_id)->count(),
        ]);
    }
}
