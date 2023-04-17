<?php

namespace Modules\Auth\Mail;

use Modules\Shared\Entities\User\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailable;

final class AuthSuccessMail extends Mailable
{
    use SerializesModels;

    public User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build(): AuthSuccessMail
    {
        return $this
            ->subject(__('auth::mail.success') . ' | ' . config('app.name'))
            ->view('auth::emails.register.success');
    }
}
