<?php

namespace App\Http\Controllers;

use App\Http\Requests\LabelStoreRequest;
use App\Models\Label;
use App\Models\LabelProduct;
use Barryvdh\DomPDF\Facade\Pdf;

class LabelController extends Controller
{
    public function create()
    {
        return view('label.create');
    }

    public function store(LabelStoreRequest $request)
    {
        $labelProduct = LabelProduct::find($request->label_product_id);

        $label = new Label();
        $label->label_product_id = $labelProduct->id;
        $label->size = $request->get('size');
        $label->weight = $labelProduct->weight;
        $label->date = $request->get('date_show') === '1' ? $request->get('date') : null;
        $label->lang = $request->get('lang');
        $label->barcode = $labelProduct->barcode;
        $label->save();


        return redirect()->route('label.show', $label->id);
    }

    public function show(Label $label)
    {
        return view('label.show', compact('label'));
    }

    public function pdf(Label $label)
    {
        return PDF::loadView('label.show', compact('label'))
            ->download("label.pdf");
    }
}
