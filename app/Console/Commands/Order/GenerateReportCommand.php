<?php

namespace App\Console\Commands\Order;

use App\Models\Order;
use App\Models\OrderReport;
use Illuminate\Console\Command;

class GenerateReportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:report {type=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate order, waybill and returns report by orders to xml';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    private $orderReport;

    public function __construct()
    {
        parent::__construct();
        $this->orderReport = new OrderReport();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $orderType = (int)$this->argument('type');
        if ($orderType != 2) {
            $query = Order::whereHas('salesrep.counterparty')
                ->with(["salesrep.counterparty", 'store']);
        } else {
            $query = Order::where('rnk_generate', false)->where('status', 3);
        }

        if ($orderType === OrderReport::REPORT_TYPE_ORDER) {
            $query->whereDoesntHave('report', function ($q) use ($orderType) {
                $q->where('type', $orderType);
            });
        } else {
            $query->whereDoesntHave('report', function ($q) use ($orderType) {
                $q->where('type', $orderType);
            });
            $query->where('status', Order::STATUS_DELIVERED);
        }
        //$orders = [Order::find(5201)];
        $orders = $query->get();
        //$orders = Order::where('id', '>', '3927')->get();
        //Order::where('user_id','16')->where('id', '>', '3927')->get();

        if (!$orders) {
            $this->info('There is no orders to generate report for');
            return 0;
        }
        $todayDate = now()->format('Y-m-d');

        $returnsCount = 0;
        $reportsCount = 0;
        $ordersCount = count($orders);

        foreach ($orders as $order) {

            if ($orderType == 2) {
                $order->rnk_generate = true;
                $order->save();
            }
            if ($orderType != 2 and $order->baskets->where('type', 1)->count() > 0) {
                $path = OrderReport::generate($order, $todayDate, 1);
                $returnsCount++;
                $this->info("The return for order $order->id is saved here : $path, type is 1");
            }
            $path = OrderReport::generate($order, $todayDate, $orderType);
            $reportsCount++;

            $this->info("The report for order $order->id is saved here : $path, type is $orderType");
        }
        $this->info("Orders total count $ordersCount, generated reports count $reportsCount, returns count: $returnsCount ");
    }
}
