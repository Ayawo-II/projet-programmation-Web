<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ModeratorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->isModerator()) {
            abort(403, 'Accès réservé aux modérateurs.');
        }

        return $next($request);
    }
}