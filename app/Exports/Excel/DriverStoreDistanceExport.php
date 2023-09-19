<?php

namespace App\Exports\Excel;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DriverStoreDistanceExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */


    public function view(): View
    {
        return view('exports.excel.driver_store_distance');
    }
}
