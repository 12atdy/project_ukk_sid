<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $otp;

    // 1. Terima data dari Controller
    public function __construct($user, $otp)
    {
        $this->user = $user;
        $this->otp = $otp;
    }

    // 2. Atur Subjek Email
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Kode Verifikasi Pendaftaran Desa Sidokerto',
        );
    }

    // 3. Tentukan View mana yang dipakai
    public function content(): Content
    {
        return new Content(
            view: 'emails.otp', // Nanti kita buat file ini
        );
    }

    public function attachments(): array
    {
        return [];
    }
}