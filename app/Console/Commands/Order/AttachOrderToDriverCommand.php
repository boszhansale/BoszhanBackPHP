<?php

namespace App\Console\Commands\Order;

use App\Models\DeliveryOrder;
use App\Models\Order;
use App\Models\User;
use Illuminate\Console\Command;

class AttachOrderToDriverCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attach:order_to_driver {order_id} {driver_id} {latitude} {longitude} {status=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Attach order to driver';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $driverId = $this->argument('driver_id');

        if (!User::find($driverId)) {
            $this->error("User with id {$driverId} not found");
            return 0;
        }

        if (User::find($driverId)->role != User::ROLE_DRIVER) {
            $this->error("User with id {$driverId} not a driver");
            return 0;
        }

        $orderId = $this->argument('order_id');

        if (!Order::find($orderId)) {
            $this->error("Order with id {$orderId} not found");
            return 0;
        }

        DeliveryOrder::query()->create([
           'order_id' => $orderId,
           'driver_id' => $driverId,
           'latitude' => $this->argument('latitude'),
           'longitude' => $this->argument('longitude'),
           'status' => $this->argument('status')
        ]);

        $this->info('The order was attached to driver, DeliveryOrder stored');

        return 0;
    }
}
