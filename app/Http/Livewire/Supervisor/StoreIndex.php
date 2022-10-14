<?php

namespace App\Http\Livewire\Supervisor;

use App\Models\Counteragent;
use App\Models\Store;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class StoreIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;

    public $salesrepId;

    public $counteragentId;

    public $start_date;

    public $end_date;

    public function render()
    {
        $q = Store::query()
            ->join('users', 'users.id', 'stores.salesrep_id')
            ->join('supervisor_salesreps', 'supervisor_salesreps.salesrep_id', 'users.id')
            ->where('users.status', 1)
            ->where('supervisor_salesreps.supervisor_id', \Auth::id())
            ->when($this->search, function ($q) {
                return $q->where(function ($qq) {
                    return $qq->where('name', 'LIKE', "%$this->search%")
                        ->orWhere('phone', 'LIKE', "%$this->search%")
                        ->orWhere('address', 'LIKE', "%$this->search%");
                });
            })
            ->when($this->salesrepId, function ($q) {
                return $q->where(function ($qq) {
                    return $qq->where('stores.salesrep_id', $this->salesrepId)
                        ->orWhere('store_salesreps.salesrep_id', $this->salesrepId);
                });
            })
            ->when($this->counteragentId, function ($q) {
                return $q->where('counteragent_id', $this->counteragentId);
            })
            ->when($this->start_date, function ($query) {
                return $query->whereDate('stores.created_at', '>=', $this->start_date);
            })
            ->when($this->end_date, function ($query) {
                return $query->whereDate('stores.created_at', '<=', $this->end_date);
            })
            ->groupBy('stores.id')
            ->orderBy('stores.id', 'desc');

        return view('supervisor.store.index_live', [
            'salesreps' => User::query()
                ->join('supervisor_salesreps', 'supervisor_salesreps.salesrep_id', 'users.id')
                ->where('supervisor_salesreps.supervisor_id', \Auth::id())
                ->where('users.role_id', 1)
                ->where('users.status', 1)
                ->orderBy('users.name')
                ->get('users.*'),
            'counteragents' => Counteragent::query()
                ->join('stores', 'stores.counteragent_id', 'counteragents.id')
                ->join('users', 'users.id', 'stores.salesrep_id')
                ->join('supervisor_salesreps', 'supervisor_salesreps.salesrep_id', 'users.id')
                ->where('users.status', 1)
                ->where('supervisor_salesreps.supervisor_id', \Auth::id())
                ->orderBy('counteragents.name')
                ->groupBy('counteragents.id')
                ->select('counteragents.*')
                ->get(),
            'stores' => $q->clone()->select('stores.*')->paginate(50),
            'store_count' => $q->clone()->count(),

        ]);
    }

    public function delete($id)
    {
        Store::where('id', $id)->delete();
    }
}
