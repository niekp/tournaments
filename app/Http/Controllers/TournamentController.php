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
        return view('tournaments', [
            'tournaments' => Tournament::all()
        ]);
    }

    public function new(Request $request) {
        $validatedData = $request->validate([
            'title' => ['required', 'unique:tournaments', 'max:255'],
        ]);

        $tournament = Tournament::create([
            'title' => $validatedData['title']
        ]);

        //return redirect()->route('tournaments', ['id' => 1]);
        return redirect()->route('tournaments');
    }
}
