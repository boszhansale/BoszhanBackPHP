<?php

namespace App\Http\Livewire;

use App\Models\Brand;
use App\Models\Category;
use App\Models\PriceType;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;

    public $brand_id = 'all';

    public $category_id = 'all';

    public $categories = [];
    public $brands = [];
    public $priceTypes = [];

    public function mount()
    {
        $this->categories = Category::orderBy('name')
            ->where('enabled', 1)
            ->get();
        $this->brands = Brand::all();
        $this->priceTypes = PriceType::all();
    }

    public function render()
    {


        $products = Product::query()
            ->select('products.*')
            ->when($this->search, function ($q) {
                return $q->where(function ($qq) {
                    return $qq->where('products.name', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('products.id', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('products.article', 'LIKE', '%' . $this->search . '%');
                });
            })
            ->join('categories', 'categories.id', 'products.category_id')
            ->when($this->brand_id != 'all', function ($q) {
                return $q->where('categories.brand_id', $this->brand_id);
            })
            ->when($this->category_id != 'all', function ($q) {
                return $q->where('categories.id', $this->category_id);
            })
            ->with(['category', 'images', 'prices'])
            ->orderBy('products.article')
            ->paginate(10);

        return view('livewire.product-index', [
            'brands' => $this->brands,
            'priceTypes' => $this->priceTypes,
            'categories' => $this->categories,
            'products' => $products,
        ]);
    }

    public function updatedBrandId($value)
    {
        $this->categories = Category::whereBrandId($value)->get();
    }
}
