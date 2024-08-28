<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LabelSetting;
use Illuminate\Http\Request;

class LabelSettingController extends Controller
{


    public function index()
    {
        $setting = LabelSetting::first();
        return view('admin.label-product.setting', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = LabelSetting::first();
        $setting->cert_kz = $request->get('cert_kz');
        $setting->cert_en = $request->get('cert_en');
        $setting->address_kz = $request->get('address_kz');
        $setting->address_en = $request->get('address_en');
        $setting->date_create_kz = $request->get('date_create_kz');
        $setting->date_create_en = $request->get('date_create_en');
        $setting->date_create_package_kz = $request->get('date_create_package_kz');
        $setting->date_create_package_ru = $request->get('date_create_package_ru');
        $setting->date_create_package_en = $request->get('date_create_package_en');
        $setting->weight_text_kz = $request->get('weight_text_kz');
        $setting->weight_text_en = $request->get('weight_text_en');
        $setting->image_url_1 = $request->get('image_url_1');
        $setting->image_url_2 = $request->get('image_url_2');
        $setting->image_url_3 = $request->get('image_url_3');
        $setting->image_url_4 = $request->get('image_url_4');
        $setting->barcode_size = $request->get('barcode_size');
        $setting->save();

        return back();
    }


}
