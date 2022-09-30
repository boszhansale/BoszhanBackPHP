<?php

namespace App\Console\Commands;

use App\Models\Basket;
use App\Models\BrandPlanUser;
use App\Models\CounteragentUser;
use App\Models\PlanGroup;
use App\Models\PlanGroupBrand;
use App\Models\PlanGroupUser;
use App\Models\Store;
use App\Models\StoreSalesrep;
use Carbon\Carbon;
use Illuminate\Console\Command;

class StoreSalesrepCopy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'store_salesrep:copy {from} {to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'copy store salesrep access';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $fromUserId = $this->argument('from');
        $toUserId = $this->argument('to');

        $stores = Store::whereSalesrepId($fromUserId)->get();

        foreach ($stores as $store) {
            StoreSalesrep::updateOrCreate([
                'salesrep_id' => $toUserId,
                'store_id' => $store->id
            ],[
                'salesrep_id' => $toUserId,
                'store_id' => $store->id
            ]);
        }
        $this->info('copy '.count($stores));


        return 0;
    }
}
