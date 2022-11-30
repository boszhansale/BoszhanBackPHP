<?php

namespace App\Console\Commands;

use App\Models\CounteragentUser;
use App\Models\Store;
use App\Models\StoreSalesrep;
use Illuminate\Console\Command;

class CounteragentUserCopy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'counteragent_user:copy {from} {to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'copy counteragent user access';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $fromUserId = $this->argument('from');
        $toUserId = $this->argument('to');

        $counteragentUsers = CounteragentUser::whereUserId($fromUserId)->get();

        
        foreach ($counteragentUsers as $counteragentUser) {
            CounteragentUser::firstOrCreate([
                'user_id' => $toUserId,
                'counteragent_id' => $counteragentUser->counteragent_id
            ], [
                'user_id' => $toUserId,
                'counteragent_id' => $counteragentUser->counteragent_id
            ]);
        }

        $storeSalesreps = StoreSalesrep::whereSalesrepId($fromUserId)->get();
        foreach ($storeSalesreps as $storeSalesrep) {
            StoreSalesrep::firstOrCreate([
                'salesrep_id' => $toUserId,
                'store_id' => $storeSalesrep->store_id
            ], [
                'salesrep_id' => $toUserId,
                'store_id' => $storeSalesrep->store_id
            ]);
        }

        $stores = Store::whereSalesrepId($fromUserId)->get();
        foreach ($stores as $store) {
            StoreSalesrep::firstOrCreate([
                'salesrep_id' => $toUserId,
                'store_id' => $store->id
            ], [
                'salesrep_id' => $toUserId,
                'store_id' => $store->id
            ]);
        }

        $this->info('copy ' . count($counteragentUsers));


        return 0;
    }
}
