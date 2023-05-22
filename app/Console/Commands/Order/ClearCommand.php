<?php

namespace App\Console\Commands\Order;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class ClearCommand extends Command
{
    protected $signature = 'order:clear';

    protected $description = 'parse xml from ftp';

    public function handle()
    {
        $files = Storage::disk('ftpOrder')->files('/');

        $date = (int)Carbon::now()->subDays(7)->format('Ymd');
        foreach ($files as $fileName) {
            if (strripos($fileName, 'ORDER') !== false) {
                $d = (int)substr($fileName, 6, 8);
                if ($d <= $date) {
                    Storage::disk('ftpOrder')->delete($fileName);
                }
            } elseif (strripos($fileName, 'RETURN') !== false) {
                $d = (int)substr($fileName, 7, 8);
                if ($d <= $date) {
                    Storage::disk('ftpOrder')->delete($fileName);
                }
            }
        }
    }


}
