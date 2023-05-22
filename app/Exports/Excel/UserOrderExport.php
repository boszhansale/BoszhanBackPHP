<?php

namespace App\Exports\Excel;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UserOrderExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public $users;
    public $ordersQuery;

    public function __construct($users, $ordersQuery)
    {
        $this->users = $users;
        $this->ordersQuery = $ordersQuery;
    }

    public function view(): View
    {
        return view('exports.excel.user_order', [
            'users' => $this->users,
            'ordersQuery' => $this->ordersQuery,
        ]);
    }
}
