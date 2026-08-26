<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LoginNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public ?string $ipAddress = null,
        public ?string $userAgent = null
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pemberitahuan: Akun Anda Baru Saja Masuk ke Sistem SPK PUPR',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.login-notification',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
