<?php

namespace App\Console\Commands;

use App\Exports\Excel\DriverStoreDistanceExport;
use App\Mail\SendDriverStoreDistanceExcel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class DriverStoreDistanceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'driver:store-distance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $filename = 'excel/driver_store_distance/' . now()->format('Y_m_d') . '.xlsx';

        Excel::store(new DriverStoreDistanceExport(), $filename, 'public');
        $this->info('Отчет сгенерирован.');
        Mail::to(config('mail.emails'))->send(new SendDriverStoreDistanceExcel($filename));
        $this->info('Отчет был отправлен!');

        return 0;
    }
}
