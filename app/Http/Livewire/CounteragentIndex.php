<?php

namespace App\Http\Livewire;

use App\Models\Counteragent;
use App\Models\Order;
use App\Models\Status;
use App\Models\Store;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
class CounteragentIndex extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search ;
    public function render()
    {
        return view('admin.counteragent.index_live',[
            'counteragents' => Counteragent::when($this->search,function ($q){
                return $q->where(function ($qq){
                    return $qq->where('name','LIKE',"%$this->search%")
                        ->orWhere('bin','LIKE',"%$this->search%");
                });
            })

            ->orderBy('counteragents.id','desc')
            ->paginate(30),

        ]);
    }
}
