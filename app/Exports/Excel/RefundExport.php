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
    public $query;

    public function __construct($refunds, $query)
    {
        $this->refunds = $refunds;
        $this->query = $query;
    }

    public function view(): View
    {
        return view('exports.excel.refund', [
            'refunds' => $this->refunds,
            'query' => $this->query
        ]);
    }
}
