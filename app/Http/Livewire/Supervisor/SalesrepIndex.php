<?php

namespace App\Http\Livewire\Supervisor;

use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class SalesrepIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;

    public $start_date;

    public $end_date;

    public function render()
    {
        return view('supervisor.user.salesreps_live', [
            'users' => User::query()
                ->leftJoin('supervisor_salesreps', 'supervisor_salesreps.salesrep_id', 'users.id')
                ->when(\Auth::id() == 217, function ($q) {

                }, function ($q) {
                    $q->where('supervisor_salesreps.supervisor_id', \Auth::id());
                })
                ->select('users.*')
                ->when($this->search, function ($q) {
                    return $q->where(function ($qq) {
                        return $qq->where('users.name', 'LIKE', '%' . $this->search . '%')
                            ->orWhere('users.login', 'LIKE', '%' . $this->search . '%')
                            ->orWhere('users.id', 'LIKE', '%' . $this->search . '%');
                    });
                })
                ->where('users.role_id', 1)
                ->where('status', 1)
                ->groupBy('users.id')
                ->orderBy('id', 'desc')
                ->get(),
        ]);
    }

    public function mount()
    {
        $this->start_date = Carbon::now()->format('Y-m-d');
        $this->end_date = Carbon::now()->addDay()->format('Y-m-d');
    }

    public function statusChange($userId, $status)
    {
        User::whereId($userId)->update([
            'status' => $status,
        ]);
    }
}
