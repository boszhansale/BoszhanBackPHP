<?php

namespace App\Http\Controllers\Api\Salesrep;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $planGroupUser = $user->planGroupUser;
        $group = $planGroupUser->planGroup;
        $planBrands = $user->brandPlans()->where('plan', '>', 0)->with('brand')->get();

        $data['plan'] = $planGroupUser->plan;
        $data['completed'] = $planGroupUser->completed;

        $data['brands'] = [];

        foreach ($planBrands as $planBrand) {
            $item['plan'] = $planBrand->plan;
            $item['completed'] = $planBrand->completed;
            $item['brand'] = $planBrand->brand;

            $data['brands'][] = $item;
        }

        $data['group_name'] = $group->name;

        $data['group_position'] = $planGroupUser->position;

        $data['group_plan'] = $group->plan;
        $data['group_completed'] = $group->completed;
        $data['group_brands'] = [];

        foreach ($group->planGroupBrands as $planBrand) {
            $item['plan'] = $planBrand->plan;
            $item['completed'] = $planBrand->completed;
            $item['brand'] = $planBrand->brand;

            $data['group_brands'][] = $item;
        }

        return response()->json($data);
    }
}
