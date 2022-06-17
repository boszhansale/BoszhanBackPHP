<?php

namespace App\Exports\Excel;

use App\Models\Store;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class StoresExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public $stores ;

    public function __construct($stores)
    {
        $this->stores = $stores;
    }

    public function view(): View
    {


        return view('exports.excel.store', [
            'stores' => $this->stores
        ]);
    }
}
