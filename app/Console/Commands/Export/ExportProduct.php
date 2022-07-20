<?php

namespace App\Console\Commands\Export;

use App\Models\Brand;
use App\Models\Counteragent;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ExportProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'export products';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $oldDB = DB::connection('old')->table('products')->get();
        $products = Product::all();
        foreach ($products as $product) {
           if (!DB::connection('old')->table('products')->where('id',$product->id)->exists()){
               DB::connection('old')->table('products')->insert([
                   'id' => $product->id,
                   'id_1c' => $product->id_1c,
                   'article' => $product->article,
                   'category_id' => $product->category_id,
                   'brand_id' => $product->category->brand_id,
                   'measure_id' => $product->measure,
                   'name' => $product->name,
                   'name_1c' => $product->name,
               ]);
           }

        }

        return 0;
    }
}
