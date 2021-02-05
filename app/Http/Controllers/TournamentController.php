<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Models\User;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TournamentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show all tournaments and a form to create a new one.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        return view('tournament.tournaments', [
            'tournaments' => Auth::user()->tournaments
        ]);
    }

         
    /**
     * Save the players to the tournament
     *
     * @param  Tournament $tournament
     * @param  string $players | seperated by \n
     * @return void
     */
    private function savePlayers(Tournament $tournament, string $players) {
        // Clean up input
        $newPlayers = array_map('trim', 
            array_unique(
                array_filter(
                    explode("\n", $players)
                )
            )
        );

        // Load current players to check against before attaching.
        $currentPlayers = $tournament->players;

        foreach ($newPlayers as $name) {
            // Check if the player already exists, if not create it.
            if (!$player = Auth::user()->players->where('name', $name)->first()) {
                $player = new Player;
                $player->name = $name;
                $player->user_id = Auth::user()->id;
                $player->save();
            }
            
            // Attach the player to the tournament
            if (!$currentPlayers->contains($player)) {
                $tournament->players()->attach($player);
            }
        }

        // Filter deleted players and remove them.
        $deletedPlayers = $tournament->players->filter(function ($player, $key) use ($newPlayers) {
            return !in_array($player->name, $newPlayers);
        });

        foreach ($deletedPlayers as $player) {
            $tournament->players()->detach($player);
        }
    }

    /**
     * Add a new tournament
     
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function new(Request $request) {
        $validatedData = $request->validate([
            'title' => ['required', 'max:255'],
            'players' => ['required'],
        ]);

        $tournament = new Tournament;
        $tournament->title = $validatedData['title'];
        $tournament->user_id = Auth::user()->id;
        $tournament->guid = uniqid();
        $tournament->save();

        $this->savePlayers($tournament, $validatedData['players']);
        return redirect()->route('tournaments');
    }

    /**
     * Edit a tournament
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(int $id) {
        if ($tournament = Auth::User()->tournaments->firstWhere('id', $id)) {
            return view('tournament.edit', [
                'tournament' => $tournament
            ]);
        }

        return redirect()->route('tournaments');
    }

    /**
     * Save changes in tournament
     
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function editSave(Request $request, int $id) {
        $validatedData = $request->validate([
            'title' => ['required', 'max:255'],
            'players' => ['required'],
        ]);

        if ($tournament = Auth::User()->tournaments->firstWhere('id', $id)) {
            $tournament->title = $validatedData['title'];
            $tournament->save();
        }
        
        $this->savePlayers($tournament, $validatedData['players']);

        return redirect()->route('tournaments');
    }

    /**
     * Delete a tournament
     * 
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function delete(int $id) {
        if ($tournament = Auth::User()->tournaments->firstWhere('id', $id)) {
            $tournament->delete();
        }

        return redirect()->route('tournaments');
    }

}
