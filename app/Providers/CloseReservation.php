<?php

namespace App\Providers;

use App\Providers\ClosedReservation;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CloseReservation
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
     * @param  ClosedReservation  $event
     * @return void
     */
    public function handle(ClosedReservation $event)
    {
        $reservation = $event->reservation;
        $reservation->update(['done'=>1]);
    }
}
