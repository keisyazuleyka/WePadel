<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Models\TournamentRegistration;
use Illuminate\Http\Request;

class TournamentController extends Controller
{
    public function index()
    {
        $tournaments = Tournament::orderBy('start_date', 'asc')->paginate(6);
        return view('tournaments.index', compact('tournaments'));
    }

    public function show(Tournament $tournament)
    {
        $tournament->load('registrations.user');

        // Mock standings/leaderboard data for premium dashboard experience
        $standings = [
            ['rank' => 1, 'team' => 'Vadel Badjideh', 'played' => 5, 'won' => 5, 'lost' => 0, 'points' => 15],
            ['rank' => 2, 'team' => 'Tembok Solo', 'played' => 5, 'won' => 4, 'lost' => 1, 'points' => 12],
            ['rank' => 3, 'team' => 'Net Rackets', 'played' => 5, 'won' => 3, 'lost' => 2, 'points' => 9],
            ['rank' => 4, 'team' => 'Papadelan', 'played' => 5, 'won' => 2, 'lost' => 3, 'points' => 6],
            ['rank' => 5, 'team' => 'Lenteng Agung LA', 'played' => 5, 'won' => 1, 'lost' => 4, 'points' => 3],
        ];

        return view('tournaments.show', compact('tournament', 'standings'));
    }
}
