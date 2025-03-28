<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Gate;

class MyRestrictedDocsAccess
{
    public function handle($request, Closure $next)
    {
        if (app()->environment('local')) {
            return $next($request);
        }

        if (Gate::allows('viewApiDocs')) {
            return $next($request);
        }

        abort(403);
    }
}
