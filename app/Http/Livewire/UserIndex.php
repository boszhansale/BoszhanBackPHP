<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\Status;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
class UserIndex extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $roleId;
    public $search;
    public $sort = 'id';
    public $sortBy = 'desc';


    public function render()
    {
        return view('livewire.user-index',[
            'users' => User::where('users.name','LIKE',$this->search.'%')
                ->join('user_roles','user_roles.user_id','users.id')
                ->when($this->roleId,function ($q){
                    return $q->where('user_roles.role_id',$this->roleId);
                })
                ->orderBy($this->sort,$this->sortBy)
                ->select('users.*')
                ->get()
        ]);
    }
}
