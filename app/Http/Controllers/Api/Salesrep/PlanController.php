<?php

namespace App\Http\Controllers\Api\Salesrep;

use App\Actions\BasketCreateAction;
use App\Actions\OrderCreateAction;
use App\Actions\OrderPriceAction;
use App\Actions\OrderUpdateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\OrderStoreRequest;
use App\Http\Requests\Api\OrderUpdateRequest;
use App\Models\Basket;
use App\Models\Order;
use App\Models\PaymentStatus;
use App\Models\PaymentType;
use App\Models\PlanGroupUser;
use App\Models\PriceType;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{
    function index()
    {
        $user = Auth::user();

        $planGroupUser = $user->planGroupUser;
        $group = $planGroupUser->planGroup;
        $planBrands = $user->brandPlans()->where('plan','>',0)->with('brand')->get();

        $data['plan'] = $planGroupUser->plan;
        $data['completed'] = $planGroupUser->completed;

        $data['brands'] = [];


        foreach ($planBrands as $planBrand) {
            $item['plan'] = $planBrand->plan;
            $item['completed'] = $planBrand->completed;
            $item['brand'] = $planBrand->brand;

            $data['brands'][]=$item;
        }

        $data['group_name'] = $group->name;

        $data['group_position'] =  $planGroupUser->position;




        $data['group_plan'] = $group->plan;
        $data['group_completed'] = $group->completed;
        $data['group_brands'] = [];

        foreach ($group->planGroupBrands as $planBrand) {
            $item['plan'] = $planBrand->plan;
            $item['completed'] = $planBrand->completed;
            $item['brand'] = $planBrand->brand;

            $data['group_brands'][]=$item;
        }




        return response()->json($data);
    }
}
