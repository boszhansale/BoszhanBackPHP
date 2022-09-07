<?php

namespace App\Console\Commands;

use App\Models\Basket;
use App\Models\Brand;
use App\Models\BrandPlanUser;
use App\Models\Counteragent;
use App\Models\Order;
use App\Models\PlanGroup;
use App\Models\PlanGroupBrand;
use App\Models\PlanGroupUser;
use App\Models\Store;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class StoreDebtCalk extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'debt:calk';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'store debt calculate';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $stores = Store::all();

        foreach ($stores as $store) {
            $store->debt = $store->orders()->where('payment_status_id',2)->sum('purchase_price') - $store->orders()->where('payment_status_id',1)->sum('purchase_price');
            $store->save();
        }

        return 0;
    }
}
