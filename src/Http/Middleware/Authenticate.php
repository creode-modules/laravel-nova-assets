<?php

namespace Creode\LaravelNovaAssets\Http\Middleware;

use Illuminate\Http\Request;

class Authenticate
{
    /**
     * Handle the incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request):mixed  $next
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request, $next)
    {
        if (! $request->user()->hasPermissionTo('viewAnyAsset')) {
            abort(403);
        }

        return $next($request);
    }
}
