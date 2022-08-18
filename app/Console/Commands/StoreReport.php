<?php

namespace App\Console\Commands;

use App\Actions\OldDbOrderCreateAction;
use App\Exports\Excel\StoresExport;
use App\Mail\SendStoreExcel;
use App\Models\Brand;
use App\Models\Counteragent;
use App\Models\Order;
use App\Models\Store;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class StoreReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'store:report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'export stores to 1C';

    /**
     * Execute the console command.
     *
     * @return int
     *
     */

    public function handle()
    {

        $stores = Store::whereNotNull('salesrep_id')
            ->with('salesrep')
            ->whereDate('created_at',now())
            ->get();

        $filename = 'excel/stores/'.now()->format('Y_m_d') . "_stores_list.xlsx";

        Excel::store(new StoresExport($stores),$filename,'public');
        $this->info('Отчет сгенерирован.');
        Mail::to(config('mail.emails'))->send(new SendStoreExcel($filename));

        $this->info('Отчет был отправлен!');


        return 0;
    }
}
