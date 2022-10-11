<?php

namespace App\Console\Commands;

use App\Models\Brand;
use App\Models\BrandPlanUser;
use App\Models\PlanGroup;
use App\Models\PlanGroupBrand;
use App\Models\PlanGroupUser;
use App\Models\Product;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Nette\Utils\Image;
use Spatie\ImageOptimizer\OptimizerChain;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Spatie\ImageOptimizer\Optimizers\Jpegoptim;
use Spatie\ImageOptimizer\Optimizers\Pngquant;

class ImageOptimize extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'image:optimize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = ' image optimize command';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $optimizerChain = (new OptimizerChain)
            ->addOptimizer(new Jpegoptim([
                '-m85', // set maximum quality to 85%
                '--strip-all',  // this strips out all text information such as comments and EXIF data
                '--all-progressive',  // this will make sure the resulting image is a progressive one
            ]))

            ->addOptimizer(new Pngquant([
                '--force',
            ]));
        foreach (Product::cursor() as $product) {
            $this->info("optimize $product->name");
            foreach ($product->images as $image){
                $imagePath = Storage::disk('public')->path($image->getRawOriginal('path'));



                $beforeSize =  Storage::disk('public')->size($image->getRawOriginal('path'));
                $this->info("before file size $beforeSize , fileName = $image->path");

                $optimizerChain->optimize($imagePath);

                $afterSize =  Storage::disk('public')->size($image->getRawOriginal('path'));
                $this->info("after file size $afterSize , fileName = $image->path");
            }
        }

        return 0;
    }
}
