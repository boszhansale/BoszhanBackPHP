<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LabelCategory;
use App\Models\LabelProduct;
use Illuminate\Http\Request;

class LabelController extends Controller
{
    public function categories()
    {
        return response()->json(LabelCategory::pluck('name')->toArray());
    }

    public function products(Request $request)
    {
        $lang = $request->lang ?? 'kz';
        $products = LabelProduct::query()
            ->join('label_categories', 'label_categories.id', '=', 'label_products.label_category_id')
            ->where('label_categories.name', $request->category)
            ->select('label_products.name_' . $lang)
            ->pluck('label_products.name_' . $lang)
            ->toArray();
        return response()->json($products);
    }
}
