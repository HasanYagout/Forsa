<?php

namespace App\Observers;

use App\Models\Training;
use App\Models\User;
use Filament\Notifications\Notification;

class TrainingObserver
{
    /**
     * Handle the Training "created" event.
     */
    public function created(Training $training): void
    {
        if (auth()->user()->hasRole(['training'])){
            $superAdmin = User::role('super admin')->first();

            $superAdmin->notify(
            Notification::make()
                ->title(__('New Ticket'))
                ->icon('icon-ticket')
                ->toDatabase(),

        );
        }
    }

    /**
     * Handle the Training "updated" event.
     */
    public function updated(Training $training): void
    {
        //
    }

    /**
     * Handle the Training "deleted" event.
     */
    public function deleted(Training $training): void
    {
        //
    }

    /**
     * Handle the Training "restored" event.
     */
    public function restored(Training $training): void
    {
        //
    }

    /**
     * Handle the Training "force deleted" event.
     */
    public function forceDeleted(Training $training): void
    {
        //
    }
}
