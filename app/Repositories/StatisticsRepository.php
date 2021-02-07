<?php
namespace App\Repositories;

use App\Models\Game;
use App\Models\Tournament;
use App\ViewModels\Statistic;

class StatisticsRepository {
    
    /**
     * Get statistics of a tournament. Amount of games played and won per player.
     *
     * @param  Tournament $tournament
     * @return array | of Statistics
     */
    public function getStatistics(Tournament $tournament) : array {
        $stats = [];
        foreach ($tournament->players as $player) {
            $played = $tournament->games()
                    ->where('player1_id', $player->id)
                    ->whereNotNull('scorePlayer1')
                    ->whereNotNull('scorePlayer2')
                    ->count();

            $played += $tournament->games()
                ->where('player2_id', $player->id)
                ->whereNotNull('scorePlayer1')
                ->whereNotNull('scorePlayer2')
                ->count();
                
            $won = $tournament->games()->where('winner_id', $player->id)->count();

            array_push($stats, new Statistic($player, $played, $won));
        }

        usort($stats, function($a, $b) {
            if ($a->getWinPercentage() == $b->getWinPercentage()) {
                return 0;
            }

            return ($a->getWinPercentage() < $b->getWinPercentage()) ? 1 : -1;
        });

        return $stats;
    }

}