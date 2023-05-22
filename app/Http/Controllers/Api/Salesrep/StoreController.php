<?php

namespace App\Http\Controllers\Api\Salesrep;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreStoreRequest;
use App\Http\Requests\Api\StoreUpdateRequest;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    public function index(Request $request)
    {
//        $lat = Auth::user()->lat;
//        $lng = Auth::user()->lng;


        $stores = Store::query()
            ->leftJoin('store_salesreps', 'store_salesreps.store_id', 'stores.id')
            ->where(function ($q) {
                return $q->where('stores.salesrep_id', Auth::id())->orWhere('store_salesreps.salesrep_id', Auth::id());
            })
            ->when($request->has('counteragent'), function ($query) {
                if (\request('counteragent') == 1) {
                    return $query->whereNotNull('counteragent_id');
                } else {
                    return $query->whereNull('counteragent_id');
                }
            })
            ->when($request->has('counteragent_id'), function ($q) {
                return $q->where('counteragent_id', \request('counteragent_id'));
            })
            ->groupBy('stores.id')
            ->orderBy('stores.name')
            ->with(['salesrep', 'counteragent'])
            ->select('stores.*')
            ->get();


        return response()->json($stores);
    }

    public function lastOrders(Request $request)
    {
        $stores = Auth::user()
            ->stores()
            ->whereHas('orders')
            ->with(
                'orders', function ($q) {
            }
            )
            ->with(['orders.baskets', 'orders.baskets.product'])
            ->latest()
            ->get()->map(function ($query) {
                $query->setRelation('orders', $query->orders->take(5));
                return $query;
            });
        return response()->json($stores);
    }

    public function store(StoreStoreRequest $request)
    {
        $store = Auth::user()->stores()->create($request->validated());

        $store->id_sell = 300000000000000 + $store->id;
        $store->save();

        return response()->json(Store::with(['salesrep', 'counteragent'])->find($store->id));
    }

    public function update(StoreUpdateRequest $request, Store $store)
    {
        $store->update($request->validated());

        return response()->json($store);
    }
}
