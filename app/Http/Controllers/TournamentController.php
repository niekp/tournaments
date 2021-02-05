<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use Illuminate\Http\Request;

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
            'tournaments' => Tournament::all()
        ]);
    }

    /**
     * Add a new tournament
     
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function new(Request $request) {
        $validatedData = $request->validate([
            'title' => ['required', 'max:255'],
        ]);

        $tournament = Tournament::create([
            'title' => $validatedData['title']
        ]);

        return redirect()->route('tournaments');
    }

    /**
     * Edit a tournament
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit($id) {
        return view('tournament.edit', [
            'tournament' => Tournament::findOrFail($id)
        ]);
    }

    /**
     * Add a new tournament
     
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function editSave(Request $request, $id) {
        $validatedData = $request->validate([
            'title' => ['required', 'max:255'],
        ]);

        $tournament = Tournament::findOrFail($id);
        $tournament->title = $validatedData['title'];
        $tournament->save();

        return redirect()->route('tournaments');
    }


}
