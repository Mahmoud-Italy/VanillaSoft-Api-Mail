<?php

namespace App\Http\Middleware;

use Closure;

class APITokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!request('api_token')) {
            return response()->json(['message' => 'api_token is required.'], 422);
        } else if (request('api_token') != '$2y$10$8lkX6uwEJqHat64SIFmsL.SJClPOf7rJhIxVsmjOSpdgsIPFUSXz.') {
            return response()->json(['message' => 'api_token is invalid.'], 422);
        } else {
            return $next($request);
        }
    }
}
