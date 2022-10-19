<?php

namespace App\Http\Livewire;

use App\Models\Counteragent;
use Livewire\Component;
use Livewire\WithPagination;

class CounteragentIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;
    public $group;

    public function render()
    {
        return view('admin.counteragent.index_live', [
            'counteragents' => Counteragent::query()
                ->when($this->search, function ($q) {
                    return $q->where(function ($qq) {
                        return $qq->where('name', 'LIKE', "%$this->search%")
                            ->orWhere('bin', 'LIKE', "%$this->search%");
                    });
                })
                ->when($this->group, function ($q) {
                    $q->where('group', $this->group);
                })
                ->orderBy('counteragents.name')
                ->paginate(30),
            'groups' => Counteragent::query()
                ->whereNotNull('group')
                ->groupBy('group')
                ->pluck('group')
                ->toArray(),

        ]);
    }
}
