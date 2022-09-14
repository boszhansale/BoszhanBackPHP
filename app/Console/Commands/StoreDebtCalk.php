<?php

namespace App\Console\Commands;

use App\Models\Store;
use Illuminate\Console\Command;

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
            $store->debt = $store->orders()->where('payment_status_id', 2)->sum('purchase_price') - $store->orders()->where('payment_status_id', 1)->sum('purchase_price');
            $store->save();
        }

        return 0;
    }
}
