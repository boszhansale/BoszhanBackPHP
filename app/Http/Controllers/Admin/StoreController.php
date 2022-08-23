<?php

namespace App\Http\Controllers\Admin;

use App\Actions\ProductGetPriceAction;
use App\Http\Controllers\Controller;
use App\Models\Basket;
use App\Models\Counteragent;
use App\Models\CounteragentUser;
use App\Models\DriverSalesrep;
use App\Models\Order;
use App\Models\PriceType;
use App\Models\Product;
use App\Models\Role;
use App\Models\Store;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class StoreController extends Controller
{
    function index()
    {
        $stores = Store::paginate(50);
        return view('admin.store.index',compact('stores'));
    }
    function create()
    {
        $salesreps = User::join('user_roles','user_roles.user_id','users.id')
            ->where('user_roles.role_id',1)
            ->select('users.*')
            ->orderBy('name')

            ->get();
        $drivers = User::join('user_roles','user_roles.user_id','users.id')
            ->where('user_roles.role_id',2)
            ->select('users.*')
            ->orderBy('name')

            ->get();
        $counteragents = Counteragent::all();

        return view('admin.store.create',compact('salesreps','drivers','counteragents'));
    }
    function store(Request $request)
    {
        $store = new Store();
        $store->name = $request->get('name');
        $store->id_1c = $request->get('id_1c');
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

        $store->save();



        return redirect()->route('admin.store.index');

    }
    function edit(Store $store)
    {
        $salesreps = User::join('user_roles','user_roles.user_id','users.id')
            ->where('user_roles.role_id',1)
            ->select('users.*')
            ->orderBy('name')
            ->get();
        $drivers = User::join('user_roles','user_roles.user_id','users.id')
            ->where('user_roles.role_id',2)
            ->select('users.*')
            ->orderBy('name')
            ->get();
        $counteragents = Counteragent::all();

        return view('admin.store.edit',compact('salesreps','drivers','store','counteragents'));
    }
    function update(Request $request,Store $store)
    {
        $store->name = $request->get('name');
        $store->id_1c = $request->get('id_1c');
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

        $store->save();

        return redirect()->back();

    }

    function show(Request $request,Store $store)
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


        return view('admin.store.show',compact('store','orders','purchasePrices','returnPrices'));
    }

    function delete(Store $store)
    {


        $store->delete();

        return redirect()->back();
    }
    function move():View
    {
        return view('admin.store.move');
    }
    function moving(Request $request):RedirectResponse
    {
        Store::whereSalesrepId($request->get('from_salesrep_id'))->update(['salesrep_id' => $request->get('to_salesrep_id')]);

        CounteragentUser::where('user_id',$request->get('from_salesrep_id'))
            ->update(['user_id' => $request->get('to_salesrep_id')]);


        return to_route('admin.user.show',$request->get('to_salesrep_id'));
    }

    protected function discount($price,$discount):float|int
    {
        $discountPrice = ( $price / 100) * $discount;
        return $price - $discountPrice;
    }

}
