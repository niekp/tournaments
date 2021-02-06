<?php
namespace App\Repositories;

use App\Models\Game;
use App\Models\Tournament;
use Illuminate\Support\Collection;
use InvalidArgumentException;

class GameRepository
{
    public function create(int $tournament_id, int $player1_id, int $player2_id) {
        $game = new Game;
        $game->tournament_id = $tournament_id;
        $game->player1_id = $player1_id;
        $game->player2_id = $player2_id;
        $game->save();
        return $game;
    }

    public function getGame(int $tournament_id, int $player1_id, int $player2_id) {
        return Game::where('tournament_id', $tournament_id)
            ::where('player1_id', $player1_id)
            ::where('player2_id', $player2_id)
            ->first();
    }

    public function generateGames(int $tournament_id) {
        if (!$tournament = Tournament::find($tournament_id)) {
            throw new InvalidArgumentException("Tournament not found");
        }

        $playedGames = $tournament->games;
        
        foreach ($tournament->players->sort() as $player1) {
            foreach ($tournament->players->sort() as $player2) {
                if ($player1->id == $player2->id) {
                    continue;
                }

                if (!$playedGames->where('player1_id', $player1->id)->where('player2_id', $player2->id)->first()) {
                    $this->create($tournament->id, $player1->id, $player2->id);
                }
            }
        }
    }

}