<?php

namespace App\Console\Commands\Import;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Counteragent;
use App\Models\Store;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:category';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'import category';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $oldDB = DB::connection('old')->table('categories')->whereNotNull('brand_id')->get();

        foreach ($oldDB as $old) {
            Category::updateOrCreate(
                ['id' => $old->id],
                [
                    'name' => $old->name_1c,
                    'brand_id' => $old->brand_id,
                    'enabled' => $old->enabled,
                ]
            );


        }

        return 0;
    }
}
