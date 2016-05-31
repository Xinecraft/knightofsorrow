<?php

namespace App\Listeners;

use App\Events;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\ShoutWasFired;

class ShoutEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param ShoutWasFired|Events $event
     */
    public function handle(ShoutWasFired $event)
    {

    }
}
