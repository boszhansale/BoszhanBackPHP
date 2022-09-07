<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductStoreRequest;
use App\Imports\CounteragentsImport;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Counteragent;
use App\Models\PaymentType;
use App\Models\PriceType;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductPriceType;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class CounteragentController extends Controller
{
    function index()
    {
        $counteragents = Counteragent::all();
        return view('admin.counteragent.index',compact('counteragents'));
    }
    function create()
    {
        $paymentTypes = PaymentType::all();
        $priceTypes = PriceType::all();
        $salesreps = User::join('user_roles','user_roles.user_id','users.id')
            ->select('users.*')
            ->where('user_roles.role_id',1)
            ->orderBy('users.name')
            ->get();

        return view('admin.counteragent.create',compact('priceTypes','paymentTypes','salesreps'));
    }
    function show(Counteragent $counteragent)
    {
        return \view('admin.counteragent.show',compact('counteragent'));
    }
    function store(Request $request)
    {
        $counteragent = new Counteragent();
        $counteragent->name = $request->get('name');
        $counteragent->id_1c = $request->get('id_1c');
        $counteragent->bin = $request->get('bin');
        $counteragent->payment_type_id = $request->get('payment_type_id');
        $counteragent->price_type_id = $request->get('price_type_id');
        $counteragent->discount = $request->get('discount');
        $counteragent->enabled = $request->has('enabled');
        $counteragent->delivery_time = $request->get    ('delivery_time');
        $counteragent->save();
        if ($request->has('salesreps')){
            foreach ($request->get('salesreps') as $userId) {
                $counteragent->counteragentUsers()->updateOrCreate(
                    ['user_id' => $userId,'counteragent_id'=>$counteragent->id],
                    ['user_id' => $userId,'counteragent_id'=>$counteragent->id],
                );
            }
        }
        return redirect()->route('admin.counteragent.index');

    }
    function edit(Product $product,Counteragent $counteragent)
    {
        $paymentTypes = PaymentType::all();
        $priceTypes = PriceType::all();
        $salesreps = User::join('user_roles','user_roles.user_id','users.id')
            ->select('users.*')
            ->where('user_roles.role_id',1)
            ->orderBy('users.name')
            ->get();
        return view('admin.counteragent.edit',compact('priceTypes','paymentTypes','counteragent','salesreps'));
    }
    function update(Request $request,Counteragent $counteragent)
    {
        $counteragent->name = $request->get('name');
        $counteragent->id_1c = $request->get('id_1c');
        $counteragent->bin = $request->get('bin');
        $counteragent->payment_type_id = $request->get('payment_type_id');
        $counteragent->price_type_id = $request->get('price_type_id');
        $counteragent->discount = $request->get('discount');
        $counteragent->enabled = $request->has('enabled');
        $counteragent->delivery_time = $request->get('delivery_time');
        $counteragent->save();


        if ($request->has('salesreps')){
            $counteragent->counteragentUsers()->delete();

            foreach ($request->get('salesreps') as $userId) {
                $counteragent->counteragentUsers()->updateOrCreate(
                    ['user_id' => $userId,'counteragent_id'=>$counteragent->id],
                    ['user_id' => $userId,'counteragent_id'=>$counteragent->id],
                );
            }
        }

        return redirect()->route('admin.counteragent.index');

    }
    function delete(Counteragent $counteragent)
    {

        $counteragent->delete();

        return redirect()->route('admin.counteragent.index');
    }
    function order(Counteragent $counteragent)
    {
        return \view('admin.counteragent.order',compact('counteragent'));
    }


    function import(Request $request)
    {
        return view('admin.counteragent.import');
    }
    function importing(Request $request)
    {
       $collect =  Excel::import(new CounteragentsImport, $request->file('file'));
        dd($collect);
    }


}
