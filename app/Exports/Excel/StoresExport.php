<?php

namespace App\Exports\Excel;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class StoresExport implements FromView, WithColumnFormatting
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public $stores;

    public function __construct($stores)
    {
        $this->stores = $stores;
    }

    public function view(): View
    {
        return view('exports.excel.store', [
            'stores' => $this->stores,
        ]);
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_NUMBER,
            'D' => NumberFormat::FORMAT_TEXT,
            'F' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}
