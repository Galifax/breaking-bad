<?php

namespace App\Http\Middleware;

use App\Events\ApiRequestHit;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiRequestHitMiddleware
{
    public function handle(Request $request, Closure $next): JsonResponse
    {
        event(new ApiRequestHit($request->user()));

        return $next($request);
    }
}
