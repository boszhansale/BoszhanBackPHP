<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LabelProduct;
use App\Models\LabelSetting;
use Illuminate\Http\Request;

class LabelProductController extends Controller
{
    public function index()
    {

        return view('admin.label-product.index');
    }

    public function create()
    {
        $setting = LabelSetting::first();
        return view('admin.label-product.create', compact('setting'));
    }

    public function store(Request $request)
    {
//        if (mb_strlen($request->composition_kz) > 1500) {
//            return back()->withErrors("длинный текст");
//        }
        $labelProduct = new LabelProduct();

        $labelProduct->measure = $request->get('measure');
        $labelProduct->weight = $request->get('weight');
        $labelProduct->barcode = $request->get('barcode');
        $labelProduct->label_category_id = $request->get('label_category_id');

        $labelProduct->name_kz = $request->get('name_kz');
        $labelProduct->name_en = $request->get('name_en');
        $labelProduct->kz_ru_margin = $request->get('kz_ru_margin');
        $labelProduct->composition_kz = $request->get('composition_kz');
        $labelProduct->composition_ru = $request->get('composition_ru');
        $labelProduct->composition_en = $request->get('composition_en');
        $labelProduct->cert_kz = $request->get('cert_kz');
        $labelProduct->cert_en = $request->get('cert_en');
        $labelProduct->address_kz = $request->get('address_kz');
        $labelProduct->address_en = $request->get('address_en');
        $labelProduct->date_create_kz = $request->get('date_create_kz');
        $labelProduct->date_create_en = $request->get('date_create_en');
        $labelProduct->align = $request->get('align');
        $labelProduct->date_type = $request->get('date_type');
        $labelProduct->date_create_package_kz = $request->get('date_create_package_kz');
        $labelProduct->date_create_package_ru = $request->get('date_create_package_ru');
        $labelProduct->date_create_package_en = $request->get('date_create_package_en');
        $labelProduct->weight_text_kz = $request->get('weight_text_kz');
        $labelProduct->weight_text_en = $request->get('weight_text_en');
        $labelProduct->image_url_1 = $request->get('image_url_1');
        $labelProduct->image_url_2 = $request->get('image_url_2');
        $labelProduct->image_url_3 = $request->get('image_url_3');
        $labelProduct->image_url_4 = $request->get('image_url_4');
        $labelProduct->save();

        return redirect()->route('cashier.label-product.index');
    }

    public function edit(LabelProduct $labelProduct)
    {
        return view('admin.label-product.edit', compact('labelProduct'));
    }

    public function update(Request $request, LabelProduct $labelProduct)
    {
//        if (mb_strlen($request->composition_kz) > 1500) {
//            return back()->withErrors("длинный текст описании");
//        }
        $labelProduct->measure = $request->get('measure');
        $labelProduct->barcode = $request->get('barcode');
        $labelProduct->weight = $request->get('weight');
        $labelProduct->label_category_id = $request->get('label_category_id');
        $labelProduct->name_kz = $request->get('name_kz');
        $labelProduct->name_en = $request->get('name_en');
        $labelProduct->kz_ru_margin = $request->get('kz_ru_margin');
        $labelProduct->composition_kz = $request->get('composition_kz');
        $labelProduct->composition_ru = $request->get('composition_ru');
        $labelProduct->composition_en = $request->get('composition_en');
        $labelProduct->cert_kz = $request->get('cert_kz');
        $labelProduct->cert_en = $request->get('cert_en');
        $labelProduct->address_kz = $request->get('address_kz');
        $labelProduct->address_en = $request->get('address_en');
        $labelProduct->date_create_kz = $request->get('date_create_kz');
        $labelProduct->date_create_en = $request->get('date_create_en');
        $labelProduct->align = $request->get('align');
        $labelProduct->date_type = $request->get('date_type');
        $labelProduct->date_create_package_kz = $request->get('date_create_package_kz');
        $labelProduct->date_create_package_ru = $request->get('date_create_package_ru');
        $labelProduct->date_create_package_en = $request->get('date_create_package_en');
        $labelProduct->weight_text_kz = $request->get('weight_text_kz');
        $labelProduct->weight_text_en = $request->get('weight_text_en');
        $labelProduct->image_url_1 = $request->get('image_url_1');
        $labelProduct->image_url_2 = $request->get('image_url_2');
        $labelProduct->image_url_3 = $request->get('image_url_3');
        $labelProduct->image_url_4 = $request->get('image_url_4');
        $labelProduct->save();

        return redirect()->route('cashier.label-product.index');
    }

    public function delete(LabelProduct $labelProduct)
    {
        $labelProduct->delete();

        return redirect()->back();
    }

}
