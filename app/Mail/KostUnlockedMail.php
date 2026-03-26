<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class KostUnlockedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $user;
    public $order;
    public $kost;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $order)
    {
        $this->user = $user;
        $this->email = $user->email ?? $user;
        $this->order = $order;
        $this->kost = $order->kost;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Info Kontak Kost Berhasil Terbuka',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.kost-unlocked',
            with: [
                'email' => $this->email,
                'user' => $this->user,
                'order' => $this->order,
                'kost' => $this->kost,
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
