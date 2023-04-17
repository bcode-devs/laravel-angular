<?php

namespace Modules\Auth\Job;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Modules\Shared\Entities\User\User;
use Illuminate\Queue\SerializesModels;
use Modules\Auth\Mail\AuthVerifyMail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailer;

final class AuthVerifyEmailJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }


    public function handle(Mailer $mailer): void
    {
        $mailer->to($this->user->email)->send(new AuthVerifyMail($this->user));
    }
}
