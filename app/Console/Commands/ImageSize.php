<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImageSize extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'image:size';

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

        $total = 0;
        foreach (Product::cursor() as $product) {
            $this->info("optimize $product->name");
            foreach ($product->images as $image) {
                try {

                    $size = Storage::disk('public')->size($image->getRawOriginal('path'));
                    $this->info("file size " . $this->convertBytesToMegabytes($size) . " , fileName = $image->path");
                    $total += $size;

                } catch (\Exception $e) {
                    $this->error($e->getMessage());
                    continue;
                }
            }
        }
        $this->info("Total size = " . $this->convertBytesToMegabytes($total));

        return 0;
    }

    function convertBytesToMegabytes($bytes): string
    {
        return round($bytes / 1048576, 2) . ' MB';
    }

}
