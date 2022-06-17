<?php

namespace App\Http\Controllers\Api\Salesrep;

use App\Http\Controllers\Controller;
use App\Models\BonusGame;
use App\Models\Order;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BonusGameController extends Controller
{
    public function index()
    {
        $bonusGames = QueryBuilder::for(BonusGame::class)
            ->allowedFilters('sum_win', 'store_id')
            ->paginate(request('per_page' ?? 10));

        return $this->cresponse('All bonus games', $bonusGames);
    }

    public function store(StoreBonusGameRequest $request)
    {

        try {

            $order = Order::where('mobile_id', $request['mobile_id'])
                ->with('store')
                ->latest()
                ->first();

            BonusGame::query()->create([
                'mobile_id' => $request['mobile_id'],
                'sum_win' => $request['sum_win'],
                'game_id' => $request['game_id'],
                'store_id' => $order ? ( $order->store ? $order->store->id : null) : null
            ]);
            //event(new StoreBonusGameEvent($request->mobile_id, $request->sum_win, $request->game_id));
        } catch (Exception $e) {
            return $this->cresponse($e->getMessage(), null, Response::HTTP_EXPECTATION_FAILED);
        }
        return $this->cresponse('Bonus game stored', ['mobile_id' => $request->mobile_id], 201);
    }

    public function download(Request $request)
    {
        return response()->download($request->path);
    }
}
