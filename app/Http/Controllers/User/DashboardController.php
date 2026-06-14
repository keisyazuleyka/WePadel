<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Court;
use App\Models\TournamentRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get upcoming bookings
        $upcomingBookings = Booking::with(['court', 'details'])
            ->where('user_id', $user->id)
            ->where('booking_date', '>=', now()->toDateString())
            ->where('status', '!=', 'cancelled')
            ->orderBy('booking_date', 'asc')
            ->get();

        // Get booking history
        $bookingHistory = Booking::with(['court', 'details', 'payment'])
            ->where('user_id', $user->id)
            ->orderBy('booking_date', 'desc')
            ->paginate(5);

        // Get membership status
        $activeMembership = $user->activeMembership();
        $membershipDetails = null;
        if ($activeMembership) {
            $membershipDetails = $user->memberships()
                ->wherePivot('status', 'active')
                ->latest()
                ->first();
        }

        // Favorite courts: get courts user has booked most frequently
        $favoriteCourtIds = Booking::where('user_id', $user->id)
            ->groupBy('court_id')
            ->selectRaw('court_id, count(*) as count')
            ->orderBy('count', 'desc')
            ->take(3)
            ->pluck('court_id');

        $favoriteCourts = Court::with('images')
            ->whereIn('id', $favoriteCourtIds)
            ->get();

        if ($favoriteCourts->isEmpty()) {
            // Fallback to top courts if user has no bookings yet
            $favoriteCourts = Court::with('images')->take(2)->get();
        }

        // Recent activity: combined logs of bookings and tournament registrations
        $recentBookings = Booking::where('user_id', $user->id)
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($booking) {
                return [
                    'type' => 'booking',
                    'title' => 'Court booked: ' . $booking->court->name,
                    'date' => $booking->created_at,
                    'status' => $booking->status
                ];
            });

        $recentTournaments = TournamentRegistration::with('tournament')
            ->where('user_id', $user->id)
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($reg) {
                return [
                    'type' => 'tournament',
                    'title' => 'Registered for ' . $reg->tournament->name,
                    'date' => $reg->created_at,
                    'status' => $reg->status
                ];
            });

        $recentActivity = $recentBookings->concat($recentTournaments)
            ->sortByDesc('date')
            ->take(5);

        return view('user.dashboard', compact(
            'upcomingBookings',
            'bookingHistory',
            'membershipDetails',
            'favoriteCourts',
            'recentActivity'
        ));
    }
}
