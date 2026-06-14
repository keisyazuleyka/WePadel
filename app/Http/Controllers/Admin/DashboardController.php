<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use App\Models\Court;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::whereHas('role', function($q) {
            $q->where('name', 'user');
        })->count();

        $totalBookings = Booking::count();

        // Revenue is calculated from confirmed or completed bookings
        $totalRevenue = Booking::whereIn('status', ['confirmed', 'completed'])->sum('total_price');

        // Court Utilization: compute total hours booked per court vs capacity
        // Assume 17 operating hours per court per day (06:00 to 23:00) over the past 30 days
        $daysCount = 30;
        $operatingHoursPerDay = 17;
        $totalCapacityHours = $daysCount * $operatingHoursPerDay;

        $courts = Court::withCount(['bookings' => function($query) {
            $query->where('booking_date', '>=', now()->subDays(30)->toDateString())
                  ->where('status', '!=', 'cancelled');
        }])->get();

        $courtAnalytics = $courts->map(function($court) use ($totalCapacityHours) {
            // Get count of individual slot bookings for this court in past 30 days
            $bookedHoursCount = \App\Models\BookingDetail::whereHas('booking', function($q) use ($court) {
                $q->where('court_id', $court->id)
                  ->where('booking_date', '>=', now()->subDays(30)->toDateString())
                  ->where('status', '!=', 'cancelled');
            })->count();

            $utilizationRate = $totalCapacityHours > 0 
                ? round(($bookedHoursCount / $totalCapacityHours) * 100, 1) 
                : 0;

            return [
                'name' => $court->name,
                'booked_hours' => $bookedHoursCount,
                'utilization_rate' => min($utilizationRate, 100) // cap at 100%
            ];
        });

        // Get latest bookings
        $latestBookings = Booking::with(['user', 'court'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalBookings',
            'totalRevenue',
            'courtAnalytics',
            'latestBookings'
        ));
    }
}
