<?php

namespace App\Console\Commands;

use App\Models\Basket;
use App\Models\Brand;
use App\Models\BrandPlanUser;
use App\Models\Counteragent;
use App\Models\Order;
use App\Models\PlanGroup;
use App\Models\PlanGroupBrand;
use App\Models\PlanGroupUser;
use App\Models\Store;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PlanCalk extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plan:calk';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'plan calculate';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $date = Carbon::now()->startOfMonth();
        PlanGroup::query()->update(['completed' => 0]);
        PlanGroupUser::query()->update(['completed' => 0]);
        BrandPlanUser::query()->update(['completed' => 0]);
        PlanGroupBrand::query()->update(['completed' => 0]);



        foreach (PlanGroupUser::all() as $planGroupUser) {
                $planGroup = $planGroupUser->planGroup;

                $sum = Basket::join('orders','orders.id','baskets.order_id')
                    ->where('orders.salesrep_id',$planGroupUser->user_id)
                    ->whereDate('orders.created_at','>=',$date)
                    ->groupBy('orders.id')
                    ->sum('orders.purchase_price');


                $planGroupUser->update(['completed' => $sum]);
                $planGroup->increment('completed',$sum);

                $positionUsers = PlanGroupUser::where('plan_group_id',$planGroup->id)->latest('completed')->get();
                foreach ($positionUsers  as $key => $positionUser) {
                    if ($positionUser->user_id == $planGroupUser->user_id ){
                        $positionUser->update(['position' =>  $key + 1]);
                        break;
                    }
                }

        }

        foreach (BrandPlanUser::all() as $brandPlanUser) {
            $sum = Basket::join('orders','orders.id','baskets.order_id')
                ->join('products','products.id','baskets.product_id')
                ->join('categories','categories.id','products.category_id')
                ->where('orders.salesrep_id',$brandPlanUser->user_id)
                ->where('categories.brand_id',$brandPlanUser->brand_id)
                ->whereDate('orders.created_at','>=',$date)
                ->groupBy('orders.id')
                ->sum('orders.purchase_price');

                $brandPlanUser->update(['completed' => $sum]);
        }

        foreach (PlanGroupBrand::all() as $planGroupBrand){
            $sum = BrandPlanUser::join('plan_group_users','plan_group_users.user_id','brand_plan_users.user_id')
                ->where('brand_id',$planGroupBrand->brand_id)
                ->groupBy('brand_plan_users.id')
                ->sum('brand_plan_users.completed');


            $planGroupBrand->update(['completed' => $sum]);
        }

        return 0;
    }
}
