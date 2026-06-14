<?php

namespace App\Http\Controllers;

use App\Models\Court;
use App\Models\BookingDetail;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CourtController extends Controller
{
    public function index(Request $request)
    {
        $query = Court::with('images')->where('is_available', true);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $courts = $query->paginate(6);
        return view('courts.index', compact('courts'));
    }

    public function show(Court $court, Request $request)
    {
        $court->load(['images', 'reviews.user']);

        // Default to today or selected date
        $dateStr = $request->input('date', Carbon::today()->toDateString());
        $selectedDate = Carbon::parse($dateStr);

        // Define operating hours (6:00 AM to 11:00 PM)
        $slots = [];
        $startHour = 6;
        $endHour = 23;

        // Retrieve existing non-cancelled bookings for this court and date
        $bookedSlots = BookingDetail::whereHas('booking', function ($q) use ($court, $dateStr) {
            $q->where('court_id', $court->id)
              ->where('booking_date', $dateStr)
              ->where('status', '!=', 'cancelled');
        })->get(['start_time', 'end_time']);

        // Format booked slots for easy comparison
        $bookedTimes = $bookedSlots->map(function ($slot) {
            return [
                'start' => Carbon::parse($slot->start_time)->format('H:i'),
                'end' => Carbon::parse($slot->end_time)->format('H:i')
            ];
        })->toArray();

        for ($hour = $startHour; $hour < $endHour; $hour++) {
            $startStr = sprintf('%02d:00', $hour);
            $endStr = sprintf('%02d:00', $hour + 1);

            // Check if this slot overlaps with any booked slots
            $isBooked = false;
            foreach ($bookedTimes as $booked) {
                if ($booked['start'] === $startStr) {
                    $isBooked = true;
                    break;
                }
            }

            // Prevent booking past times if date is today
            $isPast = false;
            if ($selectedDate->isToday()) {
                $slotTime = Carbon::today()->setHour($hour)->setMinute(0)->setSecond(0);
                if ($slotTime->isPast()) {
                    $isPast = true;
                }
            }

            $slots[] = [
                'start' => $startStr,
                'end' => $endStr,
                'is_booked' => $isBooked,
                'is_past' => $isPast || $selectedDate->isPast()
            ];
        }

        return view('courts.show', compact('court', 'slots', 'dateStr'));
    }
}
