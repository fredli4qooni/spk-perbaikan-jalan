<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountRequestProcessed extends Mailable
{
    use Queueable, SerializesModels;

    public $request;
    public $password;
    public $approved;

    public function __construct($request, $password = null, $approved = true)
    {
        $this->request = $request;
        $this->password = $password;
        $this->approved = $approved;
    }

    public function build()
    {
        $subject = $this->approved ? 'Permohonan Akun Disetujui' : 'Permohonan Akun Ditolak';
        return $this->subject($subject)
                    ->view('emails.account_request_processed')
                    ->with([
                        'request' => $this->request,
                        'password' => $this->password,
                        'approved' => $this->approved,
                    ]);
    }
}
