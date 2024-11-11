<?php

namespace App\Mail;

use App\Models\Medicine;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ExpirationNotificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $medicines;

    /**
     * Tạo một instance mới của thông báo
     *
     * @param \Illuminate\Database\Eloquent\Collection $medicines
     */
    public function __construct($medicines)
    {
        $this->medicines = $medicines;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Thông báo thuốc sắp hết hạn',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.expiration_notification', 
            with: [
                'medicines' => $this->medicines, 
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
