<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PaymentRejectedNotification extends Notification
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
            'message' => "Your payment proof for court {$this->booking->court->name} booking on {$this->booking->booking_date} was rejected. Please review and contact support.",
            'type' => 'error',
        ];
    }
}
