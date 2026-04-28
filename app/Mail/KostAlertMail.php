<?php

namespace App\Mail;

use App\Models\Kost;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class KostAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public Kost $kost;

    public function __construct(User $user, Kost $kost)
    {
        $this->user = $user;
        $this->kost = $kost;
    }

    public function build()
    {
        return $this->subject('Kost Baru Sesuai Kriteriamu! — mawkost')
            ->view('emails.kost-alert');
    }
}
