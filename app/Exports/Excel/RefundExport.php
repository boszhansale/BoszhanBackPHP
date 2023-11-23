<?php

namespace App\Exports\Excel;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RefundExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public $refunds;

    public function __construct($refunds)
    {
        $this->refunds = $refunds;
    }

    public function view(): View
    {
        return view('exports.excel.refund', [
            'refunds' => $this->refunds,
        ]);
    }
}
