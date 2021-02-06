<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;
use App\Models\Game;
use App\Models\Tournament;
use App\Repositories\GameRepository;

class GameController extends Controller {    
    // No auth middleware to make the link to a tournament sharable

    /**
     * Show round robin scren
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(string $guid) {
        if (!$tournament = Tournament::where('guid', $guid)->first()) {
            return redirect()->route('tournaments');
        }

        return view("game.index", [
            'tournament' => $tournament
        ]);
    }
}
