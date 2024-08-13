<?php

namespace Modules\CHEvents\Listeners;

use App\Contracts\Listener;
use App\Events\PirepPrefiled;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\CHEvents\Models\Event;
use Modules\CHEvents\Models\EventMatrix;

/**
 * Class PirepPrefiledListener
 * @package Modules\CHEvents\Listeners
 */
class PirepPrefiledListener extends Listener
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
     * @param  object  $event
     * @return void
     */
    public function handle(PirepPrefiled $e)
    {
        $event = Event::where('ending_at', '>=', now()->subHours(12))
            ->where('starting_at', '<=', now()->addHours(2))
            ->where('route_code', $e->pirep->route_code)
            ->first();
        if ($event) {
            EventMatrix::updateOrCreate([
                'user_id'  => $e->pirep->user_id,
                'pirep_id' => $e->pirep->id,
                'event_id' => $event->id
            ]);
        }
    }
}
