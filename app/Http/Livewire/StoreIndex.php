<?php

namespace App\Http\Livewire;

use App\Models\Counteragent;
use App\Models\Order;
use App\Models\Status;
use App\Models\Store;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
class StoreIndex extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search ;
    public $salesrepId;
    public $counteragentId;

    public function render()
    {
        return view('livewire.store-index',[
           'salesreps' => User::join('user_roles','user_roles.user_id','users.id')
               ->orderBy('users.name')
               ->groupBy('users.id')
                ->get('users.*'),
            'counteragents' => Counteragent::orderBy('name')->get(),
            'stores' => Store::when($this->search,function ($q){
                return $q->where(function ($qq){
                    return $qq->where('name','LIKE',"%$this->search%")
                        ->orWhere('phone','LIKE',"%$this->search%")
                        ->orWhere('address','LIKE',"%$this->search%");
                });
            })
            ->when($this->salesrepId,function ($q){
                return $q->where('salesrep_id',$this->salesrepId);
            })
            ->when($this->counteragentId,function ($q){
                return $q->where('counteragent_id',$this->counteragentId);
            })
            ->orderBy('stores.id','desc')
            ->paginate(50),
            'store_count' => Store::when($this->search,function ($q){
                return $q->where(function ($qq){
                    return $qq->where('name','LIKE',"%$this->search%")
                        ->orWhere('phone','LIKE',"%$this->search%")
                        ->orWhere('address','LIKE',"%$this->search%");
                });
            })
            ->when($this->salesrepId,function ($q){
                return $q->where('salesrep_id',$this->salesrepId);
            })
            ->when($this->counteragentId,function ($q){
                return $q->where('counteragent_id',$this->counteragentId);
            })
            ->orderBy('stores.id','desc')
            ->count()

        ]);
    }


    function delete($id)
    {
        Store::where('id',$id)->delete();
    }
}
