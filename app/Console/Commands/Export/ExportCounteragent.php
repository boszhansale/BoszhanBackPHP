<?php

namespace App\Console\Commands\Export;

use App\Actions\OldDbOrderCreateAction;
use App\Actions\OldDbOrderUpdateAction;
use App\Models\Brand;
use App\Models\Counteragent;
use App\Models\Order;
use App\Models\Store;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Exception;
class ExportCounteragent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:counteragent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'export counteragent to old DB';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
//        $query = DB::connection('old')->table('orders')->exists();


        $counteragents = Counteragent::all();
        foreach ($counteragents as $counteragent)
        {
            $oldCounteragent = DB::connection('old')->table('counteragents')
                ->where('id',$counteragent->id)
                ->exists();

            if (!$oldCounteragent){
                DB::connection('old')->table('counteragents')->insert([
                    'id' => $counteragent->id,
                    'name_1c' => $counteragent->name,
                    'id_1c' => $counteragent->id_1c,
                    'bin' => $counteragent->bin,
                    'priceStatus' => $counteragent->price_type_id,
                    'paymentType' => $counteragent->payment_type_id,
                ]);
            }
        }


        return 0;
    }
}
