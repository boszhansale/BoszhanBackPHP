<?php

namespace App\Console\Commands\Import;

use App\Models\Brand;
use App\Models\Counteragent;
use App\Models\Store;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportBrand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:brand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'import brands';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $oldDB = DB::connection('old')->table('brands')->get();

        foreach ($oldDB as $old) {
            Brand::updateOrCreate(
                ['id' => $old->id],
                [
                    'name' => $old->name,
                ]
            );


        }

        return 0;
    }
}
