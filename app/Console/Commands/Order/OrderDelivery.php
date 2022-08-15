<?php

namespace App\Console\Commands\Order;

use App\Actions\OldDbOrderCreateAction;
use App\Actions\OldDbOrderUpdateAction;
use App\Models\Brand;
use App\Models\Counteragent;
use App\Models\Order;
use App\Models\Store;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Exception;
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

       Order::where('orders.status_id',1)
            ->whereDate('orders.delivery_date',Carbon::now())
            ->update([
                'status_id' => 2
            ]);


        return 0;
    }
}
