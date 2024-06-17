<?php

namespace App\Http\Livewire;

use App\Models\LabelCategory;
use App\Models\LabelProduct;
use Livewire\Component;
use Livewire\WithPagination;

class LabelProductIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;
    public $label_category_id;

    public $categories = [];

    public function mount()
    {
        $this->categories = LabelCategory::orderBy('name')
            ->get();

    }

    public function render()
    {


        $products = LabelProduct::query()
            ->when($this->search, function ($q) {
                return $q->where('label_products.name_kz', 'LIKE', '%' . $this->search . '%');
            })
            ->when($this->label_category_id, function ($q) {
                return $q->where('label_products.label_category_id', $this->label_category_id);
            })
            ->orderBy('label_products.name_kz', 'asc')
            ->with('category')
            ->paginate(60);

        return view('admin.label-product.index_live', [
            'categories' => $this->categories,
            'labelProducts' => $products,
        ]);
    }
}
