<?php

namespace App\Providers;

use App\Events\ApiRequestHit;
use App\Listeners\ApiRequestIncrementCache;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        ApiRequestHit::class => [
            ApiRequestIncrementCache::class,
        ],
    ];

    public function boot(): void
    {
        //
    }
}
