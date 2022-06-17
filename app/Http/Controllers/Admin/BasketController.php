<?php

namespace App\Http\Controllers\Admin;

use App\Actions\OrderPriceAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductStoreRequest;
use App\Models\Basket;
use App\Models\Brand;
use App\Models\Category;
use App\Models\DriverSalesrep;
use App\Models\Order;
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

class BasketController extends Controller
{
    function create(Order $order,$type)
    {
        $products = Product::all();
        return view('admin.basket.create',compact('order','products','type'));
    }
    function store(Request $request,Order $order)
    {
        $product = Product::findOrFail($request->get('product_id'));

        $basket = new Basket();
        $basket->order_id = $order->id;
        $basket->count = $request->get('count');
        $basket->product_id = $product->id;
        $basket->price= $request->get('price');
        $basket->all_price= (int)$request->get('price') * (int)$request->get('count');
        $basket->type= $request->get('type');
        $basket->save();
        OrderPriceAction::execute($order);

        return redirect()->route('admin.order.show',$order->id);

    }
    function edit(Basket $basket)
    {
        $products = Product::all();
        return view('admin.basket.edit',compact('basket','products'));
    }
    function update(Request $request,Basket $basket)
    {
        $basket->count = $request->get('count');
        $basket->price= $request->get('price');
        $basket->all_price= (int)$request->get('price') * (int)$request->get('count');
        $basket->save();
        OrderPriceAction::execute($basket->order);
        return redirect()->route('admin.order.show',$basket->order_id);
    }
    function delete(Basket $basket)
    {
        $basket->delete();

        return redirect()->back();
    }

}
