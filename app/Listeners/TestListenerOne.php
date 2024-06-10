<?php

namespace App\Listeners;

use App\Events\TestEventOne;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TestListenerOne
{
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
    public function handle(TestEventOne $event): void
    {
        Log::debug("The user {$event->username} just performed {$event->action}");
    }
}
