<?php

namespace App\Listeners;

use App\Events\OperationPerformed;
use App\Features\Balance\Change;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OperationPerformedListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OperationPerformed $event): void
    {
        $changeBalance = new Change();
        $changeBalance($event->changeBalanceData);
    }
}
