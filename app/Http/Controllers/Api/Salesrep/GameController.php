<?php

namespace App\Http\Controllers\Api\Salesrep;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\GameStoreRequest;
use App\Models\Game;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $bonusGames = Game::where('store_id', $request->get('store_id'))->get();

        return response()->json($bonusGames);
    }

    public function store(GameStoreRequest $request): JsonResponse
    {

        $game = Auth::user()->games()->create($request->validated());

        if ($request->has('loops')) {
            foreach ($request->get('loops') as $loop) {
                $game->loops()->updateOrCreate([
                    'win' => $loop['win'],
                    'mobile_id' => $loop['mobile_id']
                ], [
                    'win' => $loop['win'],
                    'mobile_id' => $loop['mobile_id']
                ]);
            }
        }
        return response()->json($game);
    }
}
