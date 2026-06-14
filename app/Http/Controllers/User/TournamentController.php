<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use App\Models\TournamentRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TournamentController extends Controller
{
    public function register(Request $request, Tournament $tournament)
    {
        $user = Auth::user();

        // 1. Validate status
        if ($tournament->status !== 'upcoming') {
            return back()->with('error', 'Registrations are only open for upcoming tournaments.');
        }

        // 2. Check if already registered
        $alreadyRegistered = TournamentRegistration::where('tournament_id', $tournament->id)
            ->where('user_id', $user->id)
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($alreadyRegistered) {
            return back()->with('error', 'You have already registered for this tournament.');
        }

        // 3. Check team limit
        $activeRegistrationsCount = TournamentRegistration::where('tournament_id', $tournament->id)
            ->where('status', '!=', 'cancelled')
            ->count();

        if ($activeRegistrationsCount >= $tournament->max_teams) {
            return back()->with('error', 'This tournament has reached its maximum team capacity.');
        }

        $request->validate([
            'team_name' => 'nullable|string|max:255',
        ]);

        // 4. Create registration
        TournamentRegistration::create([
            'tournament_id' => $tournament->id,
            'user_id' => $user->id,
            'team_name' => $request->input('team_name') ?? ($user->name . ' Team'),
            'status' => 'confirmed',
        ]);

        return redirect()->route('tournaments.show', $tournament->id)
            ->with('success', 'Successfully registered for the tournament! We look forward to seeing you play.');
    }
}
