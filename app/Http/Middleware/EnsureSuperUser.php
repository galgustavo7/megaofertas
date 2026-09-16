<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureSuperUser
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guest()) {
            return redirect()->route('admin.login');
        }

        if (! Auth::user()->isSuperUser()) {
            abort(403, 'Esta área requiere permisos de super usuario.');
        }

        return $next($request);
    }
}
