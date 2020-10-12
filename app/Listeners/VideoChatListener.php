<?php

namespace App\Listeners;

use App\Events\VideoChatEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class VideoChatListener
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
     * @param  VideoChatEvent  $event
     * @return void
     */
    public function handle(VideoChatEvent $event)
    {
        //
    }
}
