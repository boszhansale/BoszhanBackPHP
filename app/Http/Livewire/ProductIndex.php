<?php

namespace App\Http\Livewire;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Status;
use App\Models\User;
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


    public function mount()
    {
        $this->categories = Category::all();
    }

    public function render()
    {
        return view('livewire.product-index',[
            'brands' => Brand::all(),
            'categories' =>   $this->categories,
            'products' => Product::where('products.name','LIKE','%'.$this->search.'%')
                ->join('categories','categories.id','products.category_id')
                ->when($this->brand_id != 'all',function ($q){
                    return $q->where('categories.brand_id',$this->brand_id);
                })
                ->when($this->category_id != 'all',function ($q){
                    return $q->where('categories.id',$this->category_id);
                })
                ->with('category')
                ->select('products.*')
                ->orderBy('products.name')
                ->paginate(25)
        ]);
    }

    public function updatedBrandId($value)
    {
        $this->categories = Category::whereBrandId($value)->get();
    }
}
