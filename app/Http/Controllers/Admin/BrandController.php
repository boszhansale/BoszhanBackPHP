<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductStoreRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\DriverSalesrep;
use App\Models\PriceType;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductPriceType;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BrandController extends Controller
{
    function index()
    {
        $brands = Brand::leftJoin('categories','categories.brand_id','brands.id')
            ->selectRaw('brands.*,COUNT(categories.id) as category_count')
            ->groupBy('brands.id')
            ->get();
        return view('admin.brand.index',compact('brands'));
    }
    function create()
    {

        return view('admin.brand.create');
    }
    function store(Request $request)
    {
        $brand = new Brand();
        $brand->name = $request->get('name');
        $brand->save();
        return redirect()->route('admin.brand.index');

    }
    function edit(Brand $brand)
    {

        return view('admin.brand.edit',compact('brand'));
    }
    function update(Request $request,Brand $brand)
    {
        $brand->name = $request->get('name');
        $brand->save();
        return redirect()->route('admin.brand.index');
    }
    function delete(Brand $brand)
    {
        $brand->delete();

        return redirect()->back();
    }

}
