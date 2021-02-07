<?php
namespace App\Repositories;

use App\Models\Game;
use App\Models\Tournament;
use Illuminate\Support\Collection;
use InvalidArgumentException;

class GameRepository
{    
    /**
     * Create a new game
     *
     * @param  int $tournament_id
     * @param  int $player1_id
     * @param  int $player2_id
     * @return Game
     */
    public function create(int $tournament_id, int $player1_id, int $player2_id) {
        $game = new Game;
        $game->tournament_id = $tournament_id;
        $game->player1_id = $player1_id;
        $game->player2_id = $player2_id;
        $game->save();
        return $game;
    }
    
    /**
     * Save the score and determine the winner of a game
     *
     * @param  Game $game
     * @param  int $scorePlayer1
     * @param  int $scorePlayer2
     * @return void
     */
    public function saveScore(Game $game, int $scorePlayer1, int $scorePlayer2) {
        $game->scorePlayer1 = $scorePlayer1;
        $game->scorePlayer2 = $scorePlayer2;
        if ($game->scorePlayer1 > $game->scorePlayer2) {
            $game->winner_id = $game->player1->id;
        } elseif ($game->scorePlayer2 > $game->scorePlayer1) {
            $game->winner_id = $game->player2->id;
        } else {
            $game->winner_id = null;
        }
        $game->save();
    }
    
    /**
     * Generate all games in the tournament
     *
     * @param  int $tournament_id
     * @return void
     */
    public function generateGames(int $tournament_id) {
        if (!$tournament = Tournament::find($tournament_id)) {
            throw new InvalidArgumentException("Tournament not found");
        }

        $playedGames = $tournament->games;
        
        foreach ($tournament->players as $player1) {
            foreach ($tournament->players as $player2) {
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