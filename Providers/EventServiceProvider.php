<?php

namespace Modules\CHEvents\Providers;

use App\Events\PirepFiled;
use App\Events\PirepPrefiled;
use App\Events\TestEvent;
use Modules\CHEvents\Listeners\PirepFiledListener;
use Modules\CHEvents\Listeners\PirepPrefiledListener;
use Modules\CHEvents\Listeners\TestEventListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     */
    protected $listen = [
        PirepFiled::class    => [PirepFiledListener::class],
        PirepPrefiled::class => [PirepPrefiledListener::class]
    ];

    /**
     * Register any events for your application.
     */
    public function boot()
    {
        parent::boot();
    }
}
