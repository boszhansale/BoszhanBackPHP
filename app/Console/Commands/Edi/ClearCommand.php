<?php

namespace App\Console\Commands\Edi;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class ClearCommand extends Command
{
    protected $signature = 'edi:clear';

    protected $description = 'parse xml from ftp';

    public function handle()
    {
        $files = Storage::disk('ftp')->files('inbox');
        $date = (int)Carbon::now()->subDays(7)->format('Ymd');
        foreach ($files as $fileName) {
            if (strpos($fileName, 'ORDER')) {
                $d = (int)substr($fileName, 12, 8);
                if ($d <= $date) {
                    Storage::disk('ftp')->delete($fileName);
                }
            } elseif (strpos($fileName, 'RETANN')) {
                $d = (int)substr($fileName, 13, 8);
                if ($d <= $date) {
                    Storage::disk('ftp')->delete($fileName);
                }
            } else {
                $d = (int)substr($fileName, 13, 8);
                if ($d <= $date) {
                    Storage::disk('ftp')->delete($fileName);
                }
            }
        }
    }


}
