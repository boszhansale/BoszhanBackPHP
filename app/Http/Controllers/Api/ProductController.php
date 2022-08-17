<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginAuthRequest;
use App\Http\Requests\Api\ProductIndexRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    function index(ProductIndexRequest $request)
    {
        $products = Product::when($request->has('category_id'),function ($query){
            return $query->where('category_id',\request('category_id'));
        })
        ->where('products.remainder','>',0)
        ->with(['images','prices.priceType','counteragentPrices.counteragent'])
        ->get();


        return response()->json($products);
    }
}
