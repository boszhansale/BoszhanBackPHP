<?php

namespace App\Console\Commands;

use App\Models\Brand;
use App\Models\BrandPlanUser;
use App\Models\PlanGroup;
use App\Models\PlanGroupBrand;
use App\Models\PlanGroupUser;
use App\Models\User;
use Illuminate\Console\Command;

class PlanInit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plan:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'plan init';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $salesreps = User::join('user_roles', 'user_roles.user_id', 'users.id')
            ->where('user_roles.role_id', 1)
            ->get('users.*');

        $brands = Brand::all();
        $planGroups = PlanGroup::all();

        foreach ($planGroups as $planGroup) {
            foreach ($brands as $brand) {
                PlanGroupBrand::firstOrCreate(
                    [
                        'plan_group_id' => $planGroup->id,
                        'brand_id' => $brand->id,
                    ],
                    [
                        'plan_group_id' => $planGroup->id,
                        'brand_id' => $brand->id,
                    ]

                );
            }
            foreach ($salesreps as $salesrep) {
                PlanGroupUser::firstOrCreate(
                    [
                        'plan_group_id' => PlanGroup::first()->id,
                        'user_id' => $salesrep->id,
                    ],
                    [
                        'plan_group_id' => PlanGroup::first()->id,
                        'user_id' => $salesrep->id,
                    ]
                );

                foreach ($brands as $brand) {
                    BrandPlanUser::firstOrCreate(
                        [
                            'brand_id' => $brand->id,
                            'user_id' => $salesrep->id,
                        ],
                        [
                            'brand_id' => $brand->id,
                            'user_id' => $salesrep->id,
                        ]
                    );
                }
            }
        }

        return 0;
    }
}
