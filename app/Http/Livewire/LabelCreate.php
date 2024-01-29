<?php

namespace App\Http\Livewire;

use App\Models\LabelProduct;
use Livewire\Component;
use Livewire\WithPagination;

class LabelCreate extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $lang = 'kz';
    public $labelProducts;

    public function render()
    {
        $this->labelProducts = LabelProduct::orderBy('name_' . $this->lang)->get();

        return view('label.create_live');
    }


}
