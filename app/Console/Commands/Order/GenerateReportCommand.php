<?php

namespace App\Console\Commands\Order;

use App\Models\Order;
use App\Models\OrderReport;
use App\Models\Store;
use Illuminate\Console\Command;

class GenerateReportCommand extends Command
{
    protected $signature = 'generate:report';
    protected $description = 'Generate order report by orders to xml';


    public function handle()
    {

        $orders = Order::select('orders.*')
            ->whereHas('salesrep.counterparty')
            ->whereDate('created_at',now())
            ->with(["salesrep.counterparty", 'store'])
            ->whereDoesntHave('report', function ($q) {
                $q->where('type', 0);
            })
            ->get();

        if (!$orders) {
            $this->info('There is no orders to generate report for');
            return 0;
        }
        $todayDate = now()->format('Y-m-d');

        $returnsCount = 0;
        $reportsCount = 0;
        $ordersCount = count($orders);

        foreach ($orders as $order) {

            $path = OrderReport::generate($order, $todayDate);
            $reportsCount++;

            $this->info("The report for order $order->id is saved here : $path, type is 0");
        }
        $this->info("Orders total count $ordersCount, generated reports count $reportsCount, returns count: $returnsCount ");
    }
}
