<?php

namespace App\Console\Commands\Order;

use App\Models\Order;
use App\Models\Roadmap;
use App\Models\User;
use App\Models\Waypoint;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use function Symfony\Component\Translation\t;

class DistributeOrdersForDeliveryCommand extends Command
{

    const COMPANY_LATITUDE = 43.374577;
    const COMPANY_LONGITUDE = 76.931272;

    const MAX_ORDERS_ON_COURIER = 50;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'distribute:delivery';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Distribute all orders for delivery across drivers';

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
        $drivers = User::drivers()
            ->withCount('waypoints')
            ->get();

        $totalOrdersForDelivery = 0;


        foreach ($drivers as $driver) {
            $roadmap = new Roadmap();
            $roadmap->user_id = $driver->id;
            $roadmap->save();

            $orders = $this->getOrders($driver);

            foreach ($orders as $order) {
                $data = [
                    'order_id' => $order->id,
                    'roadmap_id' => $roadmap->id,
                    'data' => ['data' => 'todo'],
//                    'distance' => Artisan::call('maps:getDistance', [
//                        'point1' => self::COMPANY_LATITUDE . ':' . self::COMPANY_LONGITUDE,
//                        'point2' => $order->address['latitude'] . ':' . $order->address['longitude']
//                    ])
                //@TODO нужно протестировать изменения которые по строителю при добавлении заказа,
                    //@TODO после чего подключить нормальные координаты с фронта
                    'distance' => 123,
                ];
                Waypoint::storeNewInstance($data);

                $order->status = 2;
                $order->save();

                $totalOrdersForDelivery++;
            }

        }
        $this->info('Done.Total amount of orders distributed for delivery:' . $totalOrdersForDelivery);

        return 0;
    }

    public function getOrders($driver)
    {
        $orders = $driver->driverOrders()
            ->forDelivery()
            ->get();

        return $orders;
    }

}
