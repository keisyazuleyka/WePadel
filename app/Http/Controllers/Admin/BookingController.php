<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');
        $query = Booking::with(['user', 'court', 'payment']);

        if ($status) {
            $query->where('status', $status);
        }

        $bookings = $query->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.bookings.index', compact('bookings', 'status'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['user', 'court', 'details', 'payment']);
        return view('admin.bookings.show', compact('booking'));
    }

    public function approvePayment(Booking $booking)
    {
        if (!$booking->payment) {
            return back()->with('error', 'No payment record found for this booking.');
        }

        // Update payment status
        $booking->payment->update(['status' => 'approved']);

        // Update booking status to confirmed
        $booking->update(['status' => 'confirmed']);

        // Send a DB notification to the user
        $booking->user->notify(new \App\Notifications\BookingConfirmedNotification($booking));

        return redirect()->route('admin.bookings.show', $booking->id)
            ->with('success', 'Payment approved and booking confirmed successfully.');
    }

    public function rejectPayment(Booking $booking)
    {
        if (!$booking->payment) {
            return back()->with('error', 'No payment record found for this booking.');
        }

        // Update payment status
        $booking->payment->update(['status' => 'rejected']);

        // Set booking status to cancelled
        $booking->update(['status' => 'cancelled']);

        // Send a DB notification to the user
        $booking->user->notify(new \App\Notifications\PaymentRejectedNotification($booking));

        return redirect()->route('admin.bookings.show', $booking->id)
            ->with('success', 'Payment proof rejected and booking cancelled.');
    }
}
