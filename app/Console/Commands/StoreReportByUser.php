<?php

namespace App\Console\Commands;

use App\Exports\Excel\StoresExport;
use App\Models\Store;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class StoreReportByUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'store:report_by_user {user_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'export stores by user_id';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $userId = $this->argument('user_id');


        $stores = Store::whereNotNull('salesrep_id')
            ->with('salesrep')
            ->where('salesrep_id', $userId)
            ->get();

        foreach ($stores as $store) {
            $store->id_sell = 300000000000000 + $store->id;
            $store->save();
        }


        $filename = "excel/stores/by_user/$userId" . '_stores_list.xlsx';

        Excel::store(new StoresExport($stores), $filename, 'public');
        $url = \Storage::disk('public')->url($filename);

        $this->info('Отчет сгенерирован.');
        $this->info($url);


        return 0;
    }
}
