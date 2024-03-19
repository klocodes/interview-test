<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Cache
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response) $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $cache = \Illuminate\Support\Facades\Cache::get($request->url());

        if ($cache) {
            return response($cache)->send();
        }

        return $next($request);
    }
}
