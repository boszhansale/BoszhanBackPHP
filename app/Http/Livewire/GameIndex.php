<?php

namespace App\Http\Livewire;

use App\Models\Game;
use App\Models\Store;
use Livewire\Component;
use Livewire\WithPagination;

class GameIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;

    public $start_date;

    public $end_date;

    public function render()
    {
        $games = Game::query()
            ->when($this->search, function ($q) {
                return $q->where(function ($qq) {
                    return $qq->where('name', 'LIKE', "%$this->search%")
                        ->orWhere('phone', 'LIKE', "%$this->search%")
                        ->orWhere('address', 'LIKE', "%$this->search%");
                });
            })
            ->when($this->start_date, function ($query) {
                return $query->whereDate('games.created_at', '>=', $this->start_date);
            })
            ->when($this->end_date, function ($query) {
                return $query->whereDate('games.created_at', '<=', $this->end_date);
            })
            ->groupBy('games.game')
            ->orderBy('stores.id_edi', 'asc')
            ->orderBy('stores.id', 'desc');

        return view('admin.game.index_live', [
            'games' => $games
        ]);
    }

    public function delete($id)
    {
        Store::where('id', $id)->delete();
    }
}
