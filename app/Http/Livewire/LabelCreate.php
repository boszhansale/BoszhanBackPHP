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
    public $label_product_id;
    public $date;
    public $params;
    public $dateShow;

    public function render()
    {
        $this->labelProducts = LabelProduct::query()
            ->when($this->category_id, function ($query) {
                $query->where('label_category_id', $this->category_id);
            })
            ->orderBy('name_' . $this->lang)
            ->get();
        $this->params = [
            'category_id' => $this->category_id,
            'label_product_id' => $this->label_product_id,
            'date' => $this->date,
            'date_show' => $this->dateShow,
            'lang' => $this->lang,
        ];

        return view('label.create_live');
    }

    public function mount()
    {
        $this->categories = LabelCategory::all();
        $this->dateShow = false;
        $this->date = now()->format('Y-m-d');
    }


}
