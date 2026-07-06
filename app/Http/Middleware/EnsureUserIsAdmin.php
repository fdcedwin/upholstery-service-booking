<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * All authenticated users of this application are administrators, since
 * there is no public registration flow. This middleware exists so that
 * admin-only permissions are explicit and easy to extend later (e.g. if
 * staff accounts with limited permissions are introduced).
 */
class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()) {
            abort(403);
        }

        return $next($request);
    }
}
