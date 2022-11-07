<?php

namespace App\Http\Livewire;

use App\Models\Store;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class StoreSalesrepMove extends Component
{
    use WithPagination;

    public $from_salesrep_id = '';

    public $to_salesrep_id = '';

    public function render()
    {
        return view('admin.store.salesrep_move_live', [
            'from_salesreps' => User::query()
                ->where('users.role_id', 1)
                ->where('users.status', 1)
                ->join('stores', 'stores.salesrep_id', 'users.id')
                ->orderBy('users.name')
                ->selectRaw('users.*,COUNT(stores.id) store_count')
                ->groupBy('users.id')
                ->having('store_count', '>=', 1)
                ->get(),
            'to_salesreps' => User::query()
                ->where('role_id', 1)
                ->where('status', 1)
                ->orderBy('users.name')
                ->get('users.*'),

            'from_salesrep_stores_count' => Store::whereSalesrepId($this->from_salesrep_id)->count(),
            'to_salesrep_stores_count' => Store::whereSalesrepId($this->to_salesrep_id)->count(),
        ]);
    }
}
