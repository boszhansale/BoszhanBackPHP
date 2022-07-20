<?php

namespace App\Http\Controllers\Api;

use App\Filters\Category\BrandNameFilter;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Scopes\EnabledScope;
use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;

class CategoryController extends Controller
{

    public function allCategory()
    {
        
        $categories = Category::withoutGlobalScope(EnabledScope::class)->get();
        return view('admin.categories.index', compact('categories'));
    }


    public function index()
    {

        $categories = QueryBuilder::for(Category::class)
            ->allowedFilters(
                AllowedFilter::partial('name'),
                AllowedFilter::exact('brand_id'),
                AllowedFilter::exact('id'),
                AllowedFilter::custom('brand_name', new BrandNameFilter())
            )
            ->get();

        return $this->cresponse('All categories', $categories);
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.categories.create2', compact('categories'));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request, Category $category)
    {
        $category->name = $request->name;
        $category->name_1c = $request->name;
        $category->save();

        return redirect('admin/category/all');

    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', [
            'category' => $category
        ]);
    }

    public function update(Request $request, Category $category)
    {

        $category->name = $request->input('name');
        $category->name_1c = $request->input('name');
        $category->brand_id = $request->input('brand_id');
        $category->enabled = $request->input('enabled');
        $category->save();

        return redirect()->back()->withSuccess('Категория успешно изменено');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->back()->withSuccess('Категория успешно удалена');
    }

}
