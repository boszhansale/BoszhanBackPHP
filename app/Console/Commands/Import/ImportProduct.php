<?php

namespace App\Console\Commands\Import;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'import products';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $oldDB = DB::connection('old')->table('products')->get();
        foreach ($oldDB as $old) {
            $product = Product::updateOrCreate(
                ['id' => $old->id],
                [
                    'category_id' => $old->category_id,
                    'id_1c' => $old->id_1c,
                    'article' => $old->article,
                    'measure' => $old->measure_id,
                    'name' => $old->name_1c,
                    'barcode' => $old->barcode,
                    'remainder' => $old->remainder,
                    'enabled' => $old->enabled,
                    'presale_id' => $old->presale_id,
                    'rating' => $old->rating,
                ]
            );
//            $product->prices()->delete();
//            $product->prices()->createMany([
//                [
//                    'price' => $old->price,
//                    'price_type_id' => 1,
//                ],
//                [
//                    'price' => $old->off_price,
//                    'price_type_id' => 2,
//                ],
//                [
//                    'price' => $old->price_a,
//                    'price_type_id' => 3,
//                ],
//                [
//                    'price' => $old->price_horeca,
//                    'price_type_id' => 4,
//                ],
//            ]);
        }

        return 0;
    }
}
