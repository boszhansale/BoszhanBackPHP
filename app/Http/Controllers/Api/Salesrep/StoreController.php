<?php

namespace App\Http\Controllers\Api\Salesrep;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\OrderStoreRequest;
use App\Http\Requests\Api\StoreStoreRequest;
use App\Http\Requests\Api\StoreUpdateRequest;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    function index(Request $request)
    {
        $lat = Auth::user()->lat;
        $lng =  Auth::user()->lng;

        $stores = Auth::user()->stores()
        ->when($lat or $lng,function ($q) use($lng,$lat){
            $q->selectRaw("ST_Distance_Sphere(
                point('$lng','$lat'),
                point(stores.lng,stores.lat)
            ) AS distance,stores.*"
            );
        })
        ->when($request->has('counteragent'),function ($query){
            if (\request('counteragent') == 1){
                return $query->whereNotNull("counteragent_id");
            }else{
                return $query->whereNull("counteragent_id");
            }
        })
        ->orderBy('distance')
        ->with(['salesrep','counteragent'])
        ->get();
        return response()->json($stores);
    }
    function store(StoreStoreRequest $request)
    {

        $store = Auth::user()->stores()->create($request->validated());

        $store->id_1c = 300000000000000 + $store->id;
        $store->save();


        return response()->json(Store::with(['salesrep','counteragent'])->find($store->id));
    }
    function update(StoreUpdateRequest $request,Store $store)
    {
        $store->update($request->validated());
        return response()->json($store);
    }

}
