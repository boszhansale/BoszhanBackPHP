<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Basket;
use App\Models\Brand;
use App\Models\PlanGroup;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlanGroupController extends Controller
{
    function index()
    {
        $planGroups = PlanGroup::all();
        return view('admin.plan-group.index',compact('planGroups'));
    }
    function create()
    {

        $salesreps = User::join('user_roles','user_roles.user_id','users.id')
            ->where('user_roles.role_id',1)
            ->get('users.*');
        $brands = Brand::all();

        return view('admin.plan-group.create',compact('salesreps','brands'));
    }
    function store(Request $request)
    {
        $planGroup = PlanGroup::create($request->only(['name','plan']));

        if ($request->has('plan_group_brands'))
        {
            foreach ($request->get('plan_group_brands') as $item)
            {
                $planGroup->planGroupBrands()->create([
                    'brand_id' => $item['brand_id'],
                    'plan' => $item['plan']
                ]);
            }
        }
        return redirect()->route('admin.plan-group.index');

    }
    function edit(PlanGroup $planGroup)
    {
        return view('admin.plan-group.edit',compact('planGroup'));
    }
    function update(Request $request,PlanGroup $planGroup)
    {
       $planGroup->update($request->only('name','plan'));


        if ($request->has('plan_group_brands'))
        {
            foreach ($request->get('plan_group_brands') as $item)
            {
                $planGroup->planGroupBrands()->updateOrCreate([
                    'id' => $item['plan_group_brand_id'],
                ],[
                    'plan' => $item['plan']
                ]);
            }
        }



        return redirect()->route('admin.plan-group.index');
    }
    function delete(PlanGroup $planGroup)
    {
        $planGroup->delete();

        return redirect()->back();
    }

}
