<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\UserPosition;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redis;

class SavePositionsToDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'positions:save';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::where('status', 1)->get();

        foreach ($users as $user) {

            $key = 'positions:' . $user->id;
            $positions = Redis::lrange($key, 0, -1);
            if (count($positions) > 0) {
                foreach ($positions as $position) {
                    $positionData = json_decode($position, true);
                    $date = Carbon::parse($positionData['created_at']);
                    $exists = UserPosition::query()
                        ->whereDate('created_at', $date)
                        ->where('user_id', $positionData['user_id'])
                        ->where('lat', $positionData['lat'])
                        ->where('lng', $positionData['lng'])
                        ->exists();
                    if (!$exists) {
                        UserPosition::create([
                            'lat' => $positionData['lat'],
                            'lng' => $positionData['lng'],
                            'user_id' => $positionData['user_id'],
                            'created_at' => $date,
                        ]);
                    }
                    unset($positionData, $exists);
                }

                try {
                    Redis::ltrim($key, -1, 0);
                } catch (\Exception $e) {
                    dd($e->getMessage());
                }
            }
        }
    }
}
