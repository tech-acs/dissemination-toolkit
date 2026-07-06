<?php

namespace Uneca\DisseminationToolkit\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAbility
{
    public function handle(Request $request, Closure $next, string $ability)
    {
        if ($request->user() && method_exists($request->user(), 'tokenCan') && ! $request->user()->tokenCan($ability)) {
            abort(403);
        }

        return $next($request);
    }
}
