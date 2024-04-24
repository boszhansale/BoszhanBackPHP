<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LabelStoreRequest;
use App\Models\Label;
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

    public function store(LabelStoreRequest $request)
    {

        $labelProduct = LabelProduct::where('name_kz', $request->label_product_name)->orWhere('name_en', $request->label_product_name)->latest()->first();
        if (!$labelProduct) {
            return response()->json(['message' => 'не найден'], 400);
        }
        $label = new Label();
        $label->label_product_id = $labelProduct->id;
        $label->size = $request->get('size');
        $label->weight = $request->get('weight');
        $label->date = $request->get('date_show') == true ? $request->get('date') : null;
        $label->lang = $request->get('lang');
        $label->barcode = $labelProduct->barcode;
        $label->save();


        $data = [
            'id' => (string)$label->id,
            'name' => $label->getName(),
            'barcode' => $label->barcode,
            'weight' => $label->getWeighName() . ': ' . $label->weight . ' ' . $label->getMeasure() . ' +/-3%',
            'cert' => $label->getCert(),
            'address' => strip_tags($label->getAddress()),
            'date_create' => $label->date ? $label->getDateCreate() . ' ' . $label->date : '',
            'date_code' => $label->getCreateAtNumber(),
            'composition' => $label->getComposition(),
        ];


        return response()->json($data);
    }
}
