<?php

namespace Modules\Auth\Observers;

use Modules\Auth\Job\AuthVerifyEmailJobs;
use Modules\Shared\Entities\User\User;
use Modules\Auth\Job\AuthSuccessJobs;

final class UserObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public bool $afterCommit = true;

    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        // Send auth success message
        if ($user->status === User::STATUS_ACTIVE) {
            AuthSuccessJobs::dispatch($user);
        }
        // Send auth email verify token
        if ($user->status === User::STATUS_WAIT) {
            AuthVerifyEmailJobs::dispatch($user);
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
