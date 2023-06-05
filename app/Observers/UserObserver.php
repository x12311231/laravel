<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        Log::debug(__CLASS__ . ':' . __FUNCTION__ . ' ' . $user->toJson());
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        Log::debug(__CLASS__ . ':' . __FUNCTION__ . ' ' . $user->toJson());
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        Log::debug(__CLASS__ . ':' . __FUNCTION__ . ' ' . $user->toJson());
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        Log::debug(__CLASS__ . ':' . __FUNCTION__ . ' ' . $user->toJson());
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        Log::debug(__CLASS__ . ':' . __FUNCTION__ . ' ' . $user->toJson());
        //
    }
}
