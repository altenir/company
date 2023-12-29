<?php

namespace App\Listeners;

use App\Events\ChannelPrivado;
use App\Events\PostCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyUserNewPostCreatedChannelPrivado
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
     * @param  \App\Events\ChannelPrivado  $event
     * @return void
     */
    public function handle(PostCreated $event)
    {
        //
    }
}
