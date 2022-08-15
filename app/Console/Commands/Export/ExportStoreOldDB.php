<?php

namespace App\Console\Commands\Export;

use App\Actions\OldDbOrderCreateAction;
use App\Exports\Excel\StoresExport;
use App\Mail\SendStoreExcel;
use App\Models\Brand;
use App\Models\Counteragent;
use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class ExportStoreOldDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:store_old_db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'export stores to OLD DB';

    /**
     * Execute the console command.
     *
     * @return int
     *
     */

    public function handle()
    {

//        $oldDB = DB::connection('old')->table('products')->get();
        $stores = Store::limit(1000)->get();


        foreach ($stores as $store) {
            DB::connection('old')->table('stores')->updateOrInsert([
                'id' => $store->id,
                'name' => $store->name,
                'seller_id' => $store->salesrep_id,
                'phone' => $store->phone,
                'address' => $store->address,
                'bin' => $store->bin,
                'latitude' => $store->lat,
                'longitude' => $store->lng,
                'id_onec' => $store->id_1c,
            ]);

        }

        return 0;


    }
}
