<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Court;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'court_id' => 'required|exists:courts,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'slots' => 'required|array|min:1',
            'slots.*' => 'required|string',
        ]);

        $court = Court::findOrFail($request->input('court_id'));
        $dateStr = $request->input('booking_date');
        $slots = $request->input('slots');
        $user = Auth::user();

        // 1. Prevent double-booking
        foreach ($slots as $slot) {
            $startStr = $slot;
            $endStr = Carbon::parse($slot)->addHour()->format('H:i:s');

            $exists = BookingDetail::whereHas('booking', function ($q) use ($court, $dateStr) {
                $q->where('court_id', $court->id)
                  ->where('booking_date', $dateStr)
                  ->where('status', '!=', 'cancelled');
            })->where('start_time', $startStr)->exists();

            if ($exists) {
                return back()->withErrors(['slots' => "The time slot starting at {$startStr} has already been booked."])->withInput();
            }

            // Also prevent booking past times if date is today
            if (Carbon::parse($dateStr)->isToday()) {
                $slotTime = Carbon::today()->setTimeFromTimeString($startStr);
                if ($slotTime->isPast()) {
                    return back()->withErrors(['slots' => "The time slot starting at {$startStr} is in the past."])->withInput();
                }
            }
        }

        // 2. Calculate Pricing & Membership Discount
        $hourlyRate = $court->price_per_hour;
        $totalHours = count($slots);
        $basePrice = $hourlyRate * $totalHours;

        $discountPercentage = 0;
        $activeMembership = $user->activeMembership();
        if ($activeMembership) {
            $discountPercentage = $activeMembership->discount_percentage;
        }

        $discountAmount = ($basePrice * $discountPercentage) / 100;
        $totalPrice = $basePrice - $discountAmount;

        // 3. Create Booking
        $booking = Booking::create([
            'user_id' => $user->id,
            'court_id' => $court->id,
            'booking_date' => $dateStr,
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        // 4. Create Booking Details
        foreach ($slots as $slot) {
            $startStr = $slot;
            $endStr = Carbon::parse($slot)->addHour()->format('H:i:s');

            BookingDetail::create([
                'booking_id' => $booking->id,
                'start_time' => $startStr,
                'end_time' => $endStr,
                'price' => $hourlyRate - (($hourlyRate * $discountPercentage) / 100),
            ]);
        }

        return redirect()->route('user.bookings.payment', $booking->id)
            ->with('success', 'Court reserved! Please complete the payment to confirm your booking.');
    }

    public function paymentForm(Booking $booking)
    {
        // Guard booking ownership
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized booking access.');
        }

        if ($booking->status !== 'pending') {
            return redirect()->route('user.dashboard')->with('info', 'This booking has already been processed.');
        }

        return view('user.bookings.payment', compact('booking'));
    }

    public function uploadPayment(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized booking access.');
        }

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('payment_proof')) {
            // Store payment proof image
            $file = $request->file('payment_proof');
            $path = $file->store('payments', 'public');

            // Save or update payment details
            Payment::updateOrCreate(
                ['booking_id' => $booking->id],
                [
                    'payment_proof' => $path,
                    'amount' => $booking->total_price,
                    'status' => 'pending',
                    'transaction_id' => 'TXN-' . strtoupper(Str::random(10)),
                ]
            );

            return redirect()->route('user.dashboard')
                ->with('success', 'Payment proof uploaded successfully! Our admin will verify it shortly.');
        }

        return back()->withErrors(['payment_proof' => 'Failed to upload payment proof. Please try again.']);
    }

    public function cancel(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized booking access.');
        }

        if (Carbon::parse($booking->booking_date)->isPast() && !Carbon::parse($booking->booking_date)->isToday()) {
            return back()->with('error', 'Cannot cancel past bookings.');
        }

        $booking->update(['status' => 'cancelled']);

        // Set payment status to rejected/cancelled if exists
        if ($booking->payment) {
            $booking->payment->update(['status' => 'rejected']);
        }

        return redirect()->route('user.dashboard')->with('success', 'Booking cancelled successfully.');
    }
}
