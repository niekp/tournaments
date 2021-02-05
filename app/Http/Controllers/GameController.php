<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;
use App\Models\Game;
use App\Models\Tournament;

class GameController extends Controller
{

    private function generateGames(Tournament $tournament) {
        $playedGames = $tournament->games;
        
        foreach ($tournament->players->sort() as $player1) {
            foreach ($tournament->players->sort() as $player2) {
                if ($player1->id == $player2->id) {
                    continue;
                }

                if (!$game = $playedGames->where('player1_id', $player1->id)->where('player2_id', $player2->id)->first()) {
                    $game = new Game;
                    $game->tournament_id = $tournament->id;
                    $game->player1_id = $player1->id;
                    $game->player2_id = $player2->id;
                    $game->save();
                }
            }
        }
    }

    /**
     * Show round robin scren
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(string $guid) {
        if (!$tournament = Tournament::where('guid', $guid)->first()) {
            return redirect()->route('tournaments');
        }

        $this->generateGames($tournament);

        return view("game.index", [
            'tournament' => $tournament
        ]);
    }
}
