<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Jobs\PrepareOrder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOrderNotificationToKitchen
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
     * @param OrderCreated $event
     *
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        PrepareOrder::dispatch($event->order);
    }
}
