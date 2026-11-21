<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsAdmin
{
    /**
     * Only admins and superadmins may continue; teachers get a 403.
     */
    public function handle(Request $request, Closure $next)
    {
        if (! $request->user() || ! $request->user()->isAdmin()) {
            abort(403, __('You do not have permission to access this page.'));
        }

        return $next($request);
    }
}
