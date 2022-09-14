<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class OtherCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'other:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'TESTING';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return 0;
    }
}
