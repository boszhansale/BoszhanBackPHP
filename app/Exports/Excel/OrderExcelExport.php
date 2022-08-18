<?php

namespace App\Exports\Excel;

use App\Models\Order;
use App\Models\Store;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OrderExcelExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public Order $order ;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function view(): View
    {
        return view('exports.excel.order', [
            'order' => $this->order,
            'store' => $this->order->store
        ]);
    }
}
