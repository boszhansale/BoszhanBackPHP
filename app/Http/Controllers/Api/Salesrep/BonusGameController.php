<?php

namespace App\Http\Controllers\Api\Salesrep;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\BonusGameStoreRequest;
use App\Models\BonusGame;
use App\Models\Order;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BonusGameController extends Controller
{
    function index(Request $request):JsonResponse
    {
       $bonusGames = BonusGame::where('store_id',$request->get('store_id'))->get();

       return response()->json($bonusGames);
    }

    function store(BonusGameStoreRequest $request): JsonResponse
    {

        $order = Order::where('mobile_id', $request['mobile_id'])
            ->with('store')
            ->latest()
            ->first();

        return response()->json(
            BonusGame::query()->create([
                'mobile_id' => $request['mobile_id'],
                'win' => $request['win'],
                'game_id' => $request['game_id'],
                'store_id' => $order->store_id
            ])
        );
    }

}
