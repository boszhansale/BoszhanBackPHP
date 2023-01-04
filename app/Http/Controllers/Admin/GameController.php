<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        return view('admin.game.index');
    }

    public function edit(Game $game)
    {
        return view('admin.game.edit', compact('game'));
    }

    public function update(Request $request, Game $game)
    {

        return redirect()->route('admin.game.index');
    }

    public function delete(Game $game)
    {
        $game->delete();

        return redirect()->route('admin.game.index');
    }
}
