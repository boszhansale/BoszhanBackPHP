<?php

namespace App\Console\Commands;

use App\Models\UserPosition;
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

        $userId = 255;
        $date = now()->format('Y-m-d');
        $positions = UserPosition::query()
            ->where('user_id', $userId)
            ->whereDate('created_at', $date)
            ->get();

        foreach ($positions as $position) {
            UserPosition::query()
                ->where('user_id', $userId)
                ->whereDate('created_at', $date)
                ->where('id', '<>', $position->id)
                ->where('lat', $position->lat)
                ->where('lng', $position->lng)
                ->whereTime('created_at', '>=', $position->created_at->format('H:i') . ':00')
                ->whereTime('created_at', '<=', $position->created_at->format('H:i') . ':59')
                ->delete();
        }


        return 0;
    }
}
