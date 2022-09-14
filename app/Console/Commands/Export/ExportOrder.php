<?php

namespace App\Console\Commands\Export;

use App\Actions\OldDbOrderCreateAction;
use App\Actions\OldDbOrderUpdateAction;
use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ExportOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'export order to old DB';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
//        $query = DB::connection('old')->table('orders')->exists();

        $orders = Order::where('db_export', 0)->with(['store'])->get();
        foreach ($orders as $order) {
            if (count($order->baskets) == 0) {
                continue;
            }
            $action = new OldDbOrderCreateAction();
            $action->execute($order);

//            $action = new OldDbOrderUpdateAction();
//            $action->execute($order);
        }

        return 0;
    }
}
