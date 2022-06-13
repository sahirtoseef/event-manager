<?php

namespace App\Http\Middleware;

use Closure;

class RequireRole {
    public function handle($request, Closure $next, $role) {
         abort_unless(auth()->check() && auth()->user()->role->name == $role, 403, "You don't have permissions to access this area");
          return $next($request);
    }
}
