<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BookingConfirmedNotification extends Notification
{
    use Queueable;

    protected $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'message' => "Your booking for {$this->booking->court->name} on {$this->booking->booking_date} has been confirmed!",
            'type' => 'success',
        ];
    }
}
