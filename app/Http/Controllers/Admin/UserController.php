<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductStoreRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Counteragent;
use App\Models\CounteragentUser;
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
    function position(Request $request,User $user):View
    {
        $positions = $user->userPositions()
            ->when($request->has('date'),function ($q){
                return $q->whereDate('created_at',\request('date'));
            },function ($q){
                return $q->whereDate('created_at',now());
            })
            ->selectRaw('user_positions.*, TIME(created_at) as time')
            ->get();
        return view('admin.user.position',compact('user','positions'));
    }
    function order(Request $request,User $user,$role)
    {

        return view('admin.user.order',compact('user','role'));
    }
    function create($roleId)
    {
        $roles = Role::all();
        $salesreps = User::join('user_roles','user_roles.user_id','users.id')
            ->where('user_roles.role_id',1)
            ->select('users.*')
            ->orderBy('users.name')
            ->get();
        $drivers = User::join('user_roles','user_roles.user_id','users.id')
            ->where('user_roles.role_id',2)
            ->select('users.*')
            ->orderBy('users.name')
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
        $user->inventory_number = $request->get('inventory_number');
        $user->sim_number = $request->get('sim_number');
        $user->case = $request->has('case');
        $user->screen_security = $request->has('screen_security');

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
        if ($request->has('counteragents')){
            foreach ($request->get('counteragents') as $counteragentId) {
                CounteragentUser::create([
                    'user_id' => $user->id,
                    'counteragent_id' => $counteragentId
                ]);
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
            ->orderBy('users.name')
            ->get();
        $drivers = User::join('user_roles','user_roles.user_id','users.id')
            ->where('user_roles.role_id',2)
            ->select('users.*')
            ->orderBy('users.name')
            ->get();
        $counteragents = Counteragent::orderBy('name')->get();
        $planGroups = PlanGroup::all();
        return view('admin.user.edit',compact('user','roles','salesreps','drivers','planGroups','counteragents'));
    }
    function update(Request $request,User $user)
    {

        $user->name = $request->get('name');
        $user->id_1c = $request->get('id_1c');
        $user->login = $request->get('login');
        $user->phone = $request->get('phone');
        $user->id_1c = $request->get('id_1c');
        $user->inventory_number = $request->get('inventory_number');
        $user->sim_number = $request->get('sim_number');
        $user->case = $request->has('case');
        $user->screen_security = $request->has('screen_security');
        $user->winning_access = $request->has('winning_access');
        $user->payout_access = $request->has('payout_access');
        if ($request->has('password')){
            $user->password = Hash::make($request->get('password'));
        }
        $user->save();



        if ($request->has('drivers')){
            DriverSalesrep::where('salesrep_id',$user->id)->delete();

            foreach ($request->get('drivers') as $driver) {
                DriverSalesrep::create(
                    [
                        'driver_id' => $driver,
                        'salesrep_id' => $user->id
                    ]
                );
            }
        }
        if ($request->has('salesreps')){
            DriverSalesrep::where('driver_id',$user->id)->delete();
            foreach ($request->get('salesreps') as $salesrep) {
                DriverSalesrep::create(
                    [
                        'driver_id' => $user->id,
                        'salesrep_id' => $salesrep
                    ]
                );
            }
        }
        if ($request->has('counteragents')){
           CounteragentUser::whereUserId($user->id)->delete();

            foreach ($request->get('counteragents') as $counteragentId) {
               CounteragentUser::create([
                  'user_id' => $user->id,
                  'counteragent_id' => $counteragentId
               ]);
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
    function statusChange(User $user,$status)
    {
        $user->status = $status;
        $user->save();
    }
    function delete(User $user)
    {


        $user->delete();

        return redirect()->back();
    }

    function drivers()
    {
        return response()->view('admin.user.drivers')    ;
    }
    function salesreps()
    {
        return response()->view('admin.user.salesreps')    ;
    }
}
