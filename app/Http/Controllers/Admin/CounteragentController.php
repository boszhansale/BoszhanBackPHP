<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\CounteragentsImport;
use App\Models\Counteragent;
use App\Models\PaymentType;
use App\Models\PriceType;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CounteragentController extends Controller
{
    public function index()
    {
        $counteragents = Counteragent::all();

        return view('admin.counteragent.index', compact('counteragents'));
    }

    public function create()
    {
        $paymentTypes = PaymentType::all();
        $priceTypes = PriceType::all();
        $salesreps = User::join('user_roles', 'user_roles.user_id', 'users.id')
            ->select('users.*')
            ->where('user_roles.role_id', 1)
            ->orderBy('users.name')
            ->get();

        return view('admin.counteragent.create', compact('priceTypes', 'paymentTypes', 'salesreps'));
    }

    public function show(Counteragent $counteragent)
    {
        return \view('admin.counteragent.show', compact('counteragent'));
    }

    public function store(Request $request)
    {
        $counteragent = new Counteragent();
        $counteragent->name = $request->get('name');
        $counteragent->id_1c = $request->get('id_1c');
        $counteragent->bin = $request->get('bin');
        $counteragent->payment_type_id = $request->get('payment_type_id');
        $counteragent->price_type_id = $request->get('price_type_id');
        $counteragent->discount = $request->get('discount');
        $counteragent->enabled = $request->has('enabled');
        $counteragent->delivery_time = $request->get('delivery_time');
        $counteragent->save();
        if ($request->has('salesreps')) {
            foreach ($request->get('salesreps') as $userId) {
                $counteragent->counteragentUsers()->updateOrCreate(
                    ['user_id' => $userId, 'counteragent_id' => $counteragent->id],
                    ['user_id' => $userId, 'counteragent_id' => $counteragent->id],
                );
            }
        }

        return redirect()->route('admin.counteragent.index');
    }

    public function edit(Product $product, Counteragent $counteragent)
    {
        $paymentTypes = PaymentType::all();
        $priceTypes = PriceType::all();
        $salesreps = User::join('user_roles', 'user_roles.user_id', 'users.id')
            ->select('users.*')
            ->where('user_roles.role_id', 1)
            ->orderBy('users.name')
            ->get();

        return view('admin.counteragent.edit', compact('priceTypes', 'paymentTypes', 'counteragent', 'salesreps'));
    }

    public function update(Request $request, Counteragent $counteragent)
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

        if ($request->has('salesreps')) {
            $counteragent->counteragentUsers()->delete();

            foreach ($request->get('salesreps') as $userId) {
                $counteragent->counteragentUsers()->updateOrCreate(
                    ['user_id' => $userId, 'counteragent_id' => $counteragent->id],
                    ['user_id' => $userId, 'counteragent_id' => $counteragent->id],
                );
            }
        }

        return redirect()->route('admin.counteragent.index');
    }

    public function delete(Counteragent $counteragent)
    {
        $counteragent->delete();

        return redirect()->route('admin.counteragent.index');
    }

    public function order(Counteragent $counteragent)
    {
        return \view('admin.counteragent.order', compact('counteragent'));
    }

    public function import(Request $request)
    {
        return view('admin.counteragent.import');
    }

    public function importing(Request $request)
    {
        $collect = Excel::import(new CounteragentsImport, $request->file('file'));
        dd($collect);
    }
}
