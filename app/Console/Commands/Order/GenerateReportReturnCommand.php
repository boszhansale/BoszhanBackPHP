<?php

namespace App\Console\Commands\Order;

use App\Models\Order;
use App\Models\OrderReport;
use App\Models\Store;
use Illuminate\Console\Command;

class GenerateReportReturnCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:report-return';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate returns report by orders to xml';


    public function handle()
    {



        $query = Order::select('orders.*')
            ->whereHas('salesrep.counterparty')
            ->whereDate('orders.created_at',now())
            ->where('orders.return_price','>',0)
            ->whereIn('orders.id',[15667,15662,15660,15658])
            ->with(["salesrep.counterparty", 'store']);


        $query->whereDoesntHave('report', function ($q) {
            $q->where('type', 1);
        });
//        $query->where('status_id', Order::STATUS_DELIVERED);
        $orders = $query->get();

        if (!$orders) {
            $this->info('There is no orders to generate report for');
            return 0;
        }


        $todayDate = now()->format('Y-m-d');

        $returnsCount = 0;
        $reportsCount = 0;
        $ordersCount = count($orders);

        foreach ($orders as $order) {
            if ( $order->baskets()->where('type', 1)->exists()) {
                $path = OrderReport::generateReturn($order, $todayDate, 1);
                $returnsCount++;
                $this->info("The return for order $order->id is saved here : $path, type is 1");
            }
//            $path = OrderReport::generateReturn($order, $todayDate, 1);
//            $reportsCount++;
//
//            $this->info("The report for order $order->id is saved here : $path, type is 1");
        }
        $this->info("Orders total count $ordersCount, generated reports count $reportsCount, returns count: $returnsCount ");
    }
}
