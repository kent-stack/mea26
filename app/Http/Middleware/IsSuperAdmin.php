<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsSuperAdmin
{
    public function handle(Request $request, Closure $next)
    {
        abort_unless(auth()->check() && auth()->user()->is_superadmin, 403);

        return $next($request);
    }
}