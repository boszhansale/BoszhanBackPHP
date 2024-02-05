<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LabelProduct;
use Illuminate\Http\Request;

class LabelProductController extends Controller
{
    public function index()
    {
        $labelProducts = LabelProduct::query()->latest()->get();

        return view('admin.label-product.index', compact('labelProducts'));
    }

    public function create()
    {
        return view('admin.label-product.create');
    }

    public function store(Request $request)
    {
        $labelProduct = new LabelProduct();

        $labelProduct->weight = $request->get('weight');
        $labelProduct->barcode = $request->get('barcode');
        $labelProduct->label_category_id = $request->get('label_category_id');

        $labelProduct->name_kz = $request->get('name_kz');
        $labelProduct->name_en = $request->get('name_en');
        $labelProduct->composition_kz = $request->get('composition_kz');
        $labelProduct->composition_en = $request->get('composition_en');
        $labelProduct->cert_kz = $request->get('cert_kz');
        $labelProduct->cert_en = $request->get('cert_en');
        $labelProduct->address_kz = $request->get('address_kz');
        $labelProduct->address_en = $request->get('address_en');
        $labelProduct->date_create_kz = $request->get('date_create_kz');
        $labelProduct->date_create_en = $request->get('date_create_en');
        $labelProduct->save();

        return redirect()->route('cashier.label-product.index');
    }

    public function edit(LabelProduct $labelProduct)
    {
        return view('admin.label-product.edit', compact('labelProduct'));
    }

    public function update(Request $request, LabelProduct $labelProduct)
    {
        $labelProduct->barcode = $request->get('barcode');
        $labelProduct->weight = $request->get('weight');
        $labelProduct->label_category_id = $request->get('label_category_id');
        $labelProduct->name_kz = $request->get('name_kz');
        $labelProduct->name_en = $request->get('name_en');
        $labelProduct->composition_kz = $request->get('composition_kz');
        $labelProduct->composition_en = $request->get('composition_en');
        $labelProduct->cert_kz = $request->get('cert_kz');
        $labelProduct->cert_en = $request->get('cert_en');
        $labelProduct->address_kz = $request->get('address_kz');
        $labelProduct->address_en = $request->get('address_en');
        $labelProduct->date_create_kz = $request->get('date_create_kz');
        $labelProduct->date_create_en = $request->get('date_create_en');
        $labelProduct->save();

        return redirect()->route('cashier.label-product.index');
    }

    public function delete(LabelProduct $labelProduct)
    {
        $labelProduct->delete();

        return redirect()->back();
    }

}
