<?php

namespace App\Http\Livewire;

use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class DriverIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;

    public $start_date;

    public $end_date;

    public function render()
    {
        return view('admin.user.drivers_live', [
            'users' => User::select('users.*')
                ->when($this->search, function ($q) {
                    return $q->where(function ($qq) {
                        return $qq->where('users.name', 'LIKE', '%' . $this->search . '%')
                            ->orWhere('users.login', 'LIKE', '%' . $this->search . '%')
                            ->orWhere('users.id', 'LIKE', '%' . $this->search . '%');
                    });
                })
                ->where('users.role_id', 2)
                ->groupBy('users.id')
                ->orderBy('status', 'asc')
                ->orderBy('id', 'desc')
                ->paginate(15),
        ]);
    }

    public function mount()
    {
        $this->start_date = Carbon::now()->format('Y-m-d');
        $this->end_date = Carbon::now()->format('Y-m-d');
    }

    public function statusChange($userId, $status)
    {
        User::whereId($userId)->update([
            'status' => $status,
        ]);
    }
}
