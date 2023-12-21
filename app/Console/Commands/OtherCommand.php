<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\RiderDriver;
use Carbon\Carbon;
use Illuminate\Console\Command;

class OtherCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'other:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'TESTING';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {


        $date = Carbon::parse('2023-12-04')->format('Y-m-d');

        $orders = Order::query()
            ->whereDate('delivery_date', $date)
            ->whereNull('rider_id')
            ->get();


        foreach ($orders as $order) {
            $riderDriver = RiderDriver::where('driver_id', $order->driver_id)->latest()->first();
            if (!$riderDriver) continue;

            $order->rider_id = $riderDriver->rider_id;
            $order->save();
        }


        return 0;
    }
}
