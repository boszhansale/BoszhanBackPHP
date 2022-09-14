<?php

namespace App\Console\Commands\Import;

use App\Models\Counteragent;
use App\Models\Store;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportStore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:store';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'import stores';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $oldDB = DB::connection('old')->table('stores')->get();

        foreach ($oldDB as $old) {
            $counteragent = Counteragent::whereBin($old->bin)->first();
            $store = Store::updateOrCreate(
                ['id' => $old->id],
                [
                    'salesrep_id' => $old->seller_id,
                    'counteragent_id' => $counteragent ? $counteragent->id : null,
                    'name' => $old->name,
                    'phone' => $old->phone,
                    'bin' => $old->bin,
                    'id_1c' => $old->id_onec,
                    'address' => $old->address,
                    //                    'lat' => $old->latitude,
                    //                    'lng' => $old->longitude,
                    'created_at' => $old->created_at,
                ]
            );
        }

        return 0;
    }
}
