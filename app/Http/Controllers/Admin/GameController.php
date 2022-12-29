<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index(Brand $brand)
    {
        return view('admin.game.index');
    }

    public function edit(Category $category)
    {
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $category->name = $request->get('name');
        $category->enabled = $request->has('enabled');
        $category->save();

        return redirect()->route('admin.category.index', $category->brand_id);
    }

    public function delete(Category $category)
    {
        $brand_id = $category->brand_id;
        $category->delete();

        return redirect()->route('admin.category.index', $brand_id);
    }
}
