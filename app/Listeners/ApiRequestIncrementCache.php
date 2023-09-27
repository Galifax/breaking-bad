<?php

namespace App\Listeners;

use App\Events\ApiRequestHit;
use App\Services\StatService;

class ApiRequestIncrementCache
{
    private StatService $statService;

    public function __construct(StatService $statService)
    {
        $this->statService = $statService;
    }

    public function handle(ApiRequestHit $event)
    {
        $this->statService->hit($event->getUser());
    }
}
