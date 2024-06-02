<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerification extends Mailable
{
    use Queueable, SerializesModels;

    public $verificationUrl; // Изменяем свойство на $verificationUrl

    public function __construct($verificationUrl)
    {
        $this->verificationUrl = $verificationUrl;
    }

    public function build()
    {
        return $this->view('emails.verify-email')
            ->with([
                'verificationUrl' => $this->verificationUrl, // Передаем ссылку
            ]);
    }
}
