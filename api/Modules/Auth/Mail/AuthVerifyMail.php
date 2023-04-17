<?php

namespace Modules\Auth\Mail;

use Illuminate\Queue\SerializesModels;
use Modules\Shared\Entities\User\User;
use Illuminate\Mail\Mailable;

final class AuthVerifyMail extends Mailable
{
    use SerializesModels;

    public User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build(): AuthVerifyMail
    {
        return $this
            ->subject(__('auth::mail.confirm_email') . ' | ' . config('app.name'))
            ->view('auth::emails.register.verify');
    }
}
