<?php

namespace App\Http\Livewire\Cashier;

use App\Models\Counteragent;
use Livewire\Component;
use Livewire\WithPagination;

class CounteragentIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;

    public function render()
    {
        return view('cashier.counteragent.index_live', [
            'counteragents' => Counteragent::when($this->search, function ($q) {
                return $q->where(function ($qq) {
                    return $qq->where('name', 'LIKE', "%$this->search%")
                        ->orWhere('bin', 'LIKE', "%$this->search%");
                });
            })

            ->orderBy('counteragents.name')
            ->paginate(30),

        ]);
    }
}
