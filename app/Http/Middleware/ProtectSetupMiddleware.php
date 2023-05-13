<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ProtectSetupMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            DB::connection()->getPdo();
            $check_admin = User::where('role', 'master')->count();
            if ($check_admin  === 0) {
                return $next($request);;
            }
        } catch (\PDOException $e) {
            // database belum aktif
            if ($e->getCode() === 2002) {
                return $next($request);;
            }
            // database tidak ada 
            else if ($e->getCode() === 1049) {
                return $next($request);;
            } else {
                return $next($request);;
            }
        }
        return redirect(route('dashboard'));
    }
}
