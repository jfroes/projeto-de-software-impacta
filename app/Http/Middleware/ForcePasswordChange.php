<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ForcePasswordChange
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->must_change_password && ! $request->routeIs('new-user')) {
            return redirect()->route('new-user')
                ->with('error', 'Você precisa alterar sua senha antes de continuar.');
        }
        return $next($request);
    }
}
