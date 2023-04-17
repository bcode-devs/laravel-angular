<?php

namespace Modules\Auth\Mail;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;

final class AuthResetPasswordMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function build(): AuthResetPasswordMail
    {
        return $this->subject(__('auth::mail.reset_password') . ' | ' . config('app.name'))
                    ->view('auth::emails.reset.password');
    }
}
