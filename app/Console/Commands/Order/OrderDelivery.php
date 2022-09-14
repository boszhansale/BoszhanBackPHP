<?php

namespace App\Console\Commands\Order;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;

class OrderDelivery extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:delivery';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'order status 2';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Order::where('orders.status_id', 1)
             ->whereDate('orders.delivery_date', Carbon::now())
             ->update([
                 'status_id' => 2,
             ]);

        return 0;
    }
}
