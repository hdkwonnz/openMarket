<?php

namespace App\Listeners;

use App\Events\NoticeToSellerEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NoticeToSellerEventListener
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
     * @param  NoticeToSellerEvent  $event
     * @return void
     */
    public function handle(NoticeToSellerEvent $event)
    {
        //
    }
}
