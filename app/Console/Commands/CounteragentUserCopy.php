<?php

namespace App\Console\Commands;

use App\Models\Basket;
use App\Models\BrandPlanUser;
use App\Models\CounteragentUser;
use App\Models\PlanGroup;
use App\Models\PlanGroupBrand;
use App\Models\PlanGroupUser;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CounteragentUserCopy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'counteragent_user:copy {from} {to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'copy counteragent user access';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $fromUserId = $this->argument('from');
        $toUserId = $this->argument('to');
        $counteragentUsers = CounteragentUser::whereUserId($fromUserId)->get();
        foreach ($counteragentUsers as $counteragentUser) {
            $new = CounteragentUser::firstOrCreate([
                'user_id' => $toUserId,
                'counteragent_id' => $counteragentUser->counteragent_id
            ],[
                'user_id' => $toUserId,
                'counteragent_id' => $counteragentUser->counteragent_id
            ]);
        }
        $this->info('copy '.count($counteragentUsers));


        return 0;
    }
}
