<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Counteragent;
use App\Models\CounteragentUser;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StoreController extends Controller
{
    public function index()
    {
        $stores = Store::paginate(50);

        return view('supervisor.store.index', compact('stores'));
    }

    public function create()
    {
        $salesreps = User::query()
            ->join('supervisor_salesreps', 'supervisor_salesreps.salesrep_id', 'users.id')
            ->where('supervisor_salesreps.supervisor_id', \Auth::id())
            ->where('users.role_id', 1)
            ->where('users.status', 1)
            ->select('users.*')
            ->orderBy('users.name')
            ->get();
        $drivers = User::query()
            ->where('users.role_id', 2)
            ->where('users.status', 1)
            ->select('users.*')
            ->orderBy('users.name')
            ->get();
        $counteragents = Counteragent::orderBy('name')->get();

        return view('supervisor.store.create', compact('salesreps', 'drivers', 'counteragents'));
    }

    public function store(Request $request)
    {
        $store = new Store();
        $store->name = $request->get('name');
        $store->id_sell = $request->get('id_sell');
        $store->phone = $request->get('phone');
        $store->bin = $request->get('bin');
        $store->salesrep_id = $request->get('salesrep_id');
        $store->driver_id = $request->get('driver_id');
        $store->counteragent_id = $request->get('counteragent_id');
        $store->district_id = $request->get('district_id');
        $store->address = $request->get('address');
        $store->lat = $request->get('lat');
        $store->lng = $request->get('lng');
        $store->discount = $request->get('discount');
        $store->enabled = $request->has('enabled');
        $store->save();

        return redirect()->route('supervisor.store.index');
    }

    public function edit(Store $store)
    {
        $salesreps = User::query()
            ->join('supervisor_salesreps', 'supervisor_salesreps.salesrep_id', 'users.id')
            ->where('supervisor_salesreps.supervisor_id', \Auth::id())
            ->where('users.role_id', 1)
            ->where('users.status', 1)
            ->select('users.*')
            ->orderBy('users.name')
            ->get();
        $drivers = User::query()
            ->where('users.role_id', 2)
            ->where('users.status', 1)
            ->select('users.*')
            ->orderBy('users.name')
            ->get();

        $counteragents = Counteragent::query()
            ->join('stores', 'stores.counteragent_id', 'counteragents.id')
            ->join('users', 'users.id', 'stores.salesrep_id')
            ->join('supervisor_salesreps', 'supervisor_salesreps.salesrep_id', 'users.id')
            ->where('users.status', 1)
            ->where('supervisor_salesreps.supervisor_id', \Auth::id())
            ->orderBy('counteragents.name')
            ->groupBy('counteragents.id')
            ->select('counteragents.*')
            ->get();
        return view('supervisor.store.edit', compact('salesreps', 'drivers', 'store', 'counteragents'));
    }

    public function update(Request $request, Store $store)
    {
        $store->name = $request->get('name');
        $store->id_sell = $request->get('id_sell');
        $store->phone = $request->get('phone');
        $store->bin = $request->get('bin');
        $store->salesrep_id = $request->get('salesrep_id');

        $store->driver_id = $request->get('driver_id');

        $store->counteragent_id = $request->get('counteragent_id');
        $store->district_id = $request->get('district_id');
        $store->address = $request->get('address');
        $store->lat = $request->get('lat');
        $store->lng = $request->get('lng');
        $store->discount = $request->get('discount');
        $store->enabled = $request->has('enabled');
        $store->save();

        if ($request->has('salesreps')) {
            foreach ($request->get('salesreps') as $userId) {
                $store->salesreps()->updateOrCreate(
                    ['salesrep_id' => $userId, 'store_id' => $store->id],
                    ['salesrep_id' => $userId, 'store_id' => $store->id],
                );
            }
        } else {
            $store->salesreps()->delete();
        }

        return redirect()->back();
    }

    public function show(Request $request, Store $store)
    {
//        $orders = Order::limit(400)->offset(1600)->get();
//        foreach ($orders as $order) {
//            $store = $order->store;
//            $counteragent = $store->counteragent;
//            $priceType = $counteragent ? $counteragent->priceType: PriceType::find(1);
//
//            $discount = $counteragent ? $counteragent->discount: 0;
//            $discount = $discount == 0 ? $store->discount : $discount;
//
//            foreach ($order->baskets as $value) {
//                $product = Product::find($value['product_id']);
//
//                if (!$product) continue;
//                $productPriceType = $product->prices()->where('price_type_id',$priceType->id)->first();
//                $discount = $discount == 0 ?  $product->discount : $discount;
//
//                if (!$productPriceType) continue;
//                if ($value['type'] == 1){
//                    $basket = Basket::join('orders','orders.id','baskets.order_id')
//                        ->where('orders.salesrep_id',$order->salesrep_id)
//                        ->where('baskets.type',0)
//                        ->where('orders.store_id',$order->store_id)
//                        ->where('baskets.product_id',$product->id)
//                        ->latest('baskets.id')
//                        ->first();
//                    if ($basket){
//                        $value['price'] = $basket->price;
//                    }else {
//                        $value['price'] = $this->discount($productPriceType->price,$discount);
//                    }
//                }else{
//                    $discount = $discount == 0 ?  $product->discount : $discount;
//                    $value['price'] = $this->discount($productPriceType->price,$discount);
//                }
//                $value['all_price'] = $value['count'] * $value['price'];
//
//                $value->save();
//            }
//        }

        $orders = $store->orders()->with(['salesrep', 'driver'])
            ->when($request->has('start_date'), function ($query) {
                return $query->whereDate('orders.delivery_date', '>=', $this->start_date);
            })
            ->when($request->has('end_date'), function ($query) {
                return $query->whereDate('orders.delivery_date', '<=', $this->end_date);
            })
            ->latest()
            ->paginate(50);

        $purchasePrices = $store->orders()->sum('purchase_price');
        $returnPrices = $store->orders()->sum('return_price');

        return view('supervisor.store.show', compact('store', 'orders', 'purchasePrices', 'returnPrices'));
    }

    public function delete(Store $store)
    {
        $store->delete();

        return redirect()->back();
    }

    public function order(Store $store)
    {
        return response()->view('supervisor.store.order', compact('store'));
    }

    public function move(): View
    {
        return view('supervisor.store.move');
    }

    public function moving(Request $request): RedirectResponse
    {
        Store::whereSalesrepId($request->get('from_salesrep_id'))->update(
            ['salesrep_id' => $request->get('to_salesrep_id')]
        );

        CounteragentUser::where('user_id', $request->get('from_salesrep_id'))
            ->update(['user_id' => $request->get('to_salesrep_id')]);

        return to_route('supervisor.user.show', $request->get('to_salesrep_id'));
    }

    protected function discount($price, $discount): float|int
    {
        $discountPrice = ($price / 100) * $discount;

        return $price - $discountPrice;
    }
}
