<?php

namespace App\Console\Commands\Order;

use App\Models\Order;
use App\Models\OrderReport;
use Illuminate\Console\Command;

class ReportCommand extends Command
{
    protected $signature = 'order:report {order_id?}';

    protected $description = 'Generate order report by orders to xml';

    public function handle()
    {
        $order_id = $this->argument('order_id');
        if ($order_id){
            OrderReport::where('order_id',$order_id)->where('type',0)->delete();
        }


        $orders = Order::query()
            ->select('orders.*')
            ->when($order_id,function ($q) use ($order_id) {
                return $q->where('orders.id',$order_id);
            },function ($q){
                return $q ->whereDate('created_at', now());
            })
            ->whereHas('salesrep.counterparty')

            ->with(['salesrep.counterparty', 'store'])
            ->whereDoesntHave('report', function ($q) {
                $q->where('type', 0);
            })

            ->get();

        if (! $orders) {
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
