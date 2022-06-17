<?php

namespace App\Console\Commands\Import;

use App\Models\Brand;
use App\Models\Counteragent;
use App\Models\Store;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class ImportAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'import all';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Artisan::call('import:user');
        Artisan::call('import:counterparty');
        Artisan::call('import:counteragent');
        Artisan::call('import:store');

        return 0;
    }
}
