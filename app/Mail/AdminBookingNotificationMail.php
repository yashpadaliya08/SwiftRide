<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminBookingNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;

    /**
     * Create a new message instance.
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Booking Request - SwiftRide',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $confirmUrl = route('admin.bookings.confirm', $this->booking->id);
        $viewUrl = route('admin.bookings.show', $this->booking->id);

        return new Content(
            view: 'emails.admin-booking-notification',
            with: [
                'booking' => $this->booking,
                'car' => $this->booking->car,
                'user' => $this->booking->user,
                'confirmUrl' => $confirmUrl,
                'viewUrl' => $viewUrl,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

