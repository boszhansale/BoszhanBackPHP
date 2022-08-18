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

class OtherCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'other:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'TESTING';

    /**
     * Execute the console command.
     *
     * @return int
     *
     */

    public function handle()
    {



        return 0;
    }
}
