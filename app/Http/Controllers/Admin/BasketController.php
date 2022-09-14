<?php

namespace App\Http\Controllers\Admin;

use App\Actions\OrderPriceAction;
use App\Http\Controllers\Controller;
use App\Models\Basket;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class BasketController extends Controller
{
    public function create(Order $order, $type)
    {
        $products = Product::all();

        return view('admin.basket.create', compact('order', 'products', 'type'));
    }

    public function store(Request $request, Order $order)
    {
        $product = Product::findOrFail($request->get('product_id'));

        $basket = new Basket();
        $basket->order_id = $order->id;
        $basket->count = $request->get('count');
        $basket->product_id = $product->id;
        $basket->price = $request->get('price');
        $basket->all_price = (int) $request->get('price') * (int) $request->get('count');
        $basket->type = $request->get('type');
        $basket->save();
        OrderPriceAction::execute($order);

        return redirect()->route('admin.order.show', $order->id);
    }

    public function edit(Basket $basket)
    {
        $products = Product::all();

        return view('admin.basket.edit', compact('basket', 'products'));
    }

    public function update(Request $request, Basket $basket)
    {
        $basket->count = $request->get('count');
        $basket->price = $request->get('price');
        $basket->all_price = (int) $request->get('price') * (int) $request->get('count');
        $basket->save();
        OrderPriceAction::execute($basket->order);

        return redirect()->route('admin.order.show', $basket->order_id);
    }

    public function delete(Basket $basket)
    {
        $basket->delete();

        return redirect()->back();
    }
}
