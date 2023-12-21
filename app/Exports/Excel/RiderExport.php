<?php

namespace App\Exports\Excel;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RiderExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public $orders;

    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    public function view(): View
    {
        return view('exports.excel.rider', [
            'orders' => $this->orders,
        ]);
    }

}
