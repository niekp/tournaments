<?php
namespace App\Repositories;

use App\Models\Tournament;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use InvalidArgumentException;

class TournamentRepository
{    
    private $playerRepository;

    public function __construct(PlayerRepository $playerRepository) {
        $this->playerRepository = $playerRepository;
    }
    
    /**
     * Get a tournement by id and check if the current user is authorized.
     *
     * @param  mixed $tournament_id
     * @return Tournament
     */
    public function getAuthorizedTournament(int $tournament_id) : Tournament {
        $tournament = Tournament::find($tournament_id);

        if (!$tournament = Tournament::find($tournament_id)) {
            throw new InvalidArgumentException("Invalid tournament");
        }
        if ($tournament->user_id != Auth::user()->id) {
            throw new AuthorizationException("Not authorized to edit this tournament");
        }

        return $tournament;
    }

    public function delete(int $tournament_id) {
        $tournament = $this->getAuthorizedTournament($tournament_id);
        // Delete relations
        foreach ($tournament->players as $player) {
            $tournament->players()->detach($player);
        }
        foreach ($tournament->games as $game) {
            $game->delete();
        }
        
        // Delete tournament
        $tournament->delete();
    }
    
    public function create(string $title) : Tournament {
        $tournament = new Tournament;
        $tournament->title = $title;
        $tournament->user_id = Auth::user()->id;
        $tournament->guid = Str::uuid();
        $tournament->save();

        return $tournament;
    }

    public function edit(int $tournament_id, string $title) : Tournament {
        $tournament = $this->getAuthorizedTournament($tournament_id);

        $tournament->title = $title;
        $tournament->save();

        return $tournament;
    }

    /**
     * Convert and sanatize player list to an array
     *
     * @param  string $players | seperated by \n
     * @return array
     */
    private function sanatizedPlayers(string $players) : array {
        return array_map('trim', 
            array_unique(
                array_filter(
                    explode("\n", $players)
                )
            )
        );
    }
    /**
     * Save the players to the tournament
     *
     * @param  Tournament $tournament
     * @param  string $players | seperated by \n
     * @return void
     */
    public function linkPlayers(Tournament $tournament, string $players) {
        // Clean up input
        $newPlayers = $this->sanatizedPlayers($players);

        // Load current players to check against before attaching.
        $currentPlayers = $tournament->players;

        foreach ($newPlayers as $name) {
            // Check if the player already exists, if not create it.
            $player = $this->playerRepository->getOrCreate($name);
            
            // Attach the player to the tournament
            if (!$currentPlayers->contains($player)) {
                $tournament->players()->attach($player);
            }
        }

        // Filter deleted players and remove them.
        $deletedPlayers = $tournament->players->filter(function ($player) use ($newPlayers) {
            return !in_array($player->name, $newPlayers);
        });

        foreach ($deletedPlayers as $player) {
            $tournament->players()->detach($player);
        }
    }

}