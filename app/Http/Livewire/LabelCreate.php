<?php

namespace App\Http\Livewire;

use App\Models\LabelCategory;
use App\Models\LabelProduct;
use Livewire\Component;
use Livewire\WithPagination;

class LabelCreate extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $lang = 'kz';
    public $labelProducts;
    public $categories;
    public $category_id;

    public function render()
    {
        $this->labelProducts = LabelProduct::query()
            ->when($this->category_id, function ($query) {
                $query->where('label_category_id', $this->category_id);
            })
            ->orderBy('name_' . $this->lang)
            ->get();

        return view('label.create_live');
    }

    public function mount()
    {
        $this->categories = LabelCategory::all();
    }


}
