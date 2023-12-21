<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ProductIndexRequest;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(ProductIndexRequest $request)
    {
        $products = Product::when($request->has('category_id'), function ($query) {
            return $query->where('category_id', \request('category_id'));
        })
            ->when($request->has('id'), function ($query) {
                return $query->where('id', \request('id'));
            })
            ->where('products.remainder', '>', 0)
            ->with(['images', 'prices.priceType', 'counteragentPrices.counteragent'])
            ->get();

        return response()->json($products);
    }
}
