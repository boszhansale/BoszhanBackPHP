<?php

namespace App\Console\Commands\Order;

use App\Models\OrderReport;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class   SendGeneratedReportsTo1CFTP extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:reports';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send generated xml files from generate:reports to 1c FTP server';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    private $orderReport;

    public function __construct()
    {
        parent::__construct();

        $this->orderReport = new OrderReport();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $reports = OrderReport::where('status', 1)
            ->get();

        foreach ($reports as $report) {
            try {

                $this->orderReport->sendTo1C($report);

                if ($this->orderReport->sendingStatus === 'success') {
                    $report->status = OrderReport::STATUS_SENT_TO_1C;
                } else {
                    $report->status = OrderReport::STATUS_FAILED_SENDING_TO_1C;
                }

                $report->save();
            } catch (Exception $e) {
                $this->error($e->getMessage());

                $report->status = OrderReport::STATUS_FAILED_SENDING_TO_1C;
                $report->save();

                logger("Order with id: $report->order_id, report with id: $report->id not sent!!!");
                logger($e->getMessage());

                throw new Exception($report->order_id . " order failed while sending report to 1c");
            }
        }

        $this->info("Reports sent to the 1c");

        return 0;
    }
}
