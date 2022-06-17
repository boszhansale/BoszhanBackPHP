<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductStoreRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\DriverSalesrep;
use App\Models\Order;
use App\Models\PlanGroup;
use App\Models\PlanGroupUser;
use App\Models\PriceType;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductPriceType;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class UserController extends Controller
{
    function index()
    {
        $users = User::all();
        return view('admin.user.index',compact('users'));
    }
    function show(User $user)
    {
        $driverOrders = $user->driverOrders()->paginate(20);
        $salesrepOrders = $user->salesrepOrders()->paginate(20);
        return view('admin.user.show',compact('user','driverOrders','salesrepOrders'));
    }
    function create($roleId)
    {
        $roles = Role::all();
        $salesreps = User::join('user_roles','user_roles.user_id','users.id')
            ->where('user_roles.role_id',1)
            ->select('users.*')
            ->get();
        $drivers = User::join('user_roles','user_roles.user_id','users.id')
            ->where('user_roles.role_id',2)
            ->select('users.*')
            ->get();
        $planGroups = PlanGroup::all();
        $brands = Brand::all();
        return view('admin.user.create',compact('roles','brands','salesreps','drivers','planGroups','roleId'));
    }
    function store(Request $request)
    {
        $user = new User();
        $user->name = $request->get('name');
        $user->id_1c = $request->get('id_1c');
        $user->login = $request->get('login');
        $user->phone = $request->get('phone');
        $user->id_1c = $request->get('id_1c');
        $user->winning_access = $request->has('winning_access');
        $user->payout_access = $request->has('payout_access');
        $user->password = Hash::make($request->get('password'));
        $user->save();


        if ($request->has('drivers')){
            foreach ($request->get('drivers') as $driver) {
                DriverSalesrep::updateOrCreate(
                    [
                        'driver_id' => $driver,
                        'salesrep_id' => $user->id
                    ],
                    [
                        'driver_id' => $driver,
                        'salesrep_id' => $user->id
                    ]
                );
            }
        }
        if ($request->has('salesreps')){
            foreach ($request->get('salesreps') as $salesrep) {
                DriverSalesrep::updateOrCreate(
                    [
                        'driver_id' => $user->id,
                        'salesrep_id' => $salesrep
                    ],
                    [
                        'driver_id' => $user->id,
                        'salesrep_id' => $salesrep
                    ]
                );
            }
        }
        if ($request->has('roles')){
            foreach ($request->get('roles') as $role_id) {
                UserRole::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'role_id' => $role_id
                    ],
                    [
                        'user_id' => $user->id,
                        'role_id' => $role_id
                    ]
                );

                if ($role_id == 1){
                    PlanGroupUser::create([
                        'plan_group_id' => $request->get('plan_group_id'),
                        'plan' => $request->get('plan'),
                        'user_id' => $user->id,
                    ]);
                }
            }
        }

        if ($request->has('brand_plans'))
        {
            foreach ($request->get('brand_plans') as $item)
            {
                $user->brandPlans()->create([
                    'brand_id' => $item['brand_id'],
                    'plan' => $item['plan']
                ]);
            }
        }

        return redirect()->route('admin.user.index');

    }
    function edit(User $user)
    {
        $roles = Role::all();
        $salesreps = User::join('user_roles','user_roles.user_id','users.id')
            ->where('user_roles.role_id',1)
            ->select('users.*')
            ->get();
        $drivers = User::join('user_roles','user_roles.user_id','users.id')
            ->where('user_roles.role_id',2)
            ->select('users.*')
            ->get();
        $planGroups = PlanGroup::all();
        return view('admin.user.edit',compact('user','roles','salesreps','drivers','planGroups'));
    }
    function update(Request $request,User $user)
    {

        $user->name = $request->get('name');
        $user->id_1c = $request->get('id_1c');
        $user->login = $request->get('login');
        $user->phone = $request->get('phone');
        $user->id_1c = $request->get('id_1c');
        $user->winning_access = $request->has('winning_access');
        $user->payout_access = $request->has('payout_access');
        if ($request->has('password')){
            $user->password = Hash::make($request->get('password'));
        }
        $user->save();


        if ($request->has('drivers')){
            foreach ($request->get('drivers') as $driver) {
                DriverSalesrep::updateOrCreate(
                    [
                        'driver_id' => $driver,
                        'salesrep_id' => $user->id
                    ],
                    [
                        'driver_id' => $driver,
                        'salesrep_id' => $user->id
                    ]
                );
            }
        }
        if ($request->has('salesreps')){
            foreach ($request->get('salesreps') as $salesrep) {
                DriverSalesrep::updateOrCreate(
                    [
                        'driver_id' => $user->id,
                        'salesrep_id' => $salesrep
                    ],
                    [
                        'driver_id' => $user->id,
                        'salesrep_id' => $salesrep
                    ]
                );
            }
        }
        if ($request->has('roles')){

            $user->userRoles()->delete();
            foreach ($request->get('roles') as $role_id) {
                UserRole::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'role_id' => $role_id
                    ],
                    [
                        'user_id' => $user->id,
                        'role_id' => $role_id
                    ]
                );

                if ($role_id == 1){
//                    PlanGroupUser::whereUserId($user->id)->delete();
//
//                    PlanGroupUser::create([
//                        'plan_group_id' => $request->get('plan_group_id'),
//                        'plan' => $request->get('plan'),
//                        'user_id' => $user->id,
//                    ]);

                    PlanGroupUser::updateOrCreate(
                        [
                            'user_id' => $user->id
                        ],
                        [
                            'plan_group_id' => $request->get('plan_group_id'),
                            'plan' => $request->get('plan'),
                            'user_id' => $user->id,
                        ]
                    );
                }
            }
        }

//        if ($request->file('images')){
//
//            foreach ($request->file('images') as $image) {
//                $productImage = new ProductImage();
//                $productImage->product_id = $product->id;
//                $productImage->name = $image->getClientOriginalName();
//                $productImage->path =  Storage::disk('public')->put("images",$image);
//                $productImage->save();
//            }
//        }

        if ($request->has('brand_plans'))
        {
            foreach ($request->get('brand_plans') as $item)
            {
                $user->brandPlans()->updateOrCreate([
                    'id' => $item['brand_plan_id'],
                ],[
                    'plan' => $item['plan']
                ]);
            }
        }

        return redirect()->back();

    }
    function delete(User $user)
    {


        $user->delete();

        return redirect()->back();
    }

}
