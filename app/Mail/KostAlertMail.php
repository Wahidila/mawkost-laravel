<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class KostAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public Collection $kosts;

    public function __construct(User $user, Collection $kosts)
    {
        $this->user = $user;
        $this->kosts = $kosts;
    }

    public function build()
    {
        $count = $this->kosts->count();
        $subject = $count === 1
            ? 'Kost Baru Sesuai Kriteriamu! — mawkost'
            : "{$count} Kost Baru Sesuai Kriteriamu! — mawkost";

        return $this->subject($subject)->view('emails.kost-alert');
    }
}
