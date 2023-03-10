<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $type, $role = null): Response
    {
        if ($type === "guest") {
            if (Auth::check()) {
                return redirect(route('dashboard'));
            } else {
                return $next($request);
            }
        } else if ($type === "auth") {
            if (Auth::check()) {
                if ($role != null) {
                    if (Auth::user()->role === $role) {
                        return $next($request);
                    } else {
                        return redirect(route('error.not_found'));
                    }
                } else {
                    return $next($request);
                }
            } else {
                return redirect(route('login'));
            }
        }
    }
}
