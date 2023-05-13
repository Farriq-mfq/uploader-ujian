<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class SetupMiddleware
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
                return redirect(route('setup.index'));
            }
        } catch (\PDOException $e) {
            // database belum aktif
            if ($e->getCode() === 2002) {
                return redirect(route('setup.index'));
            }
            // database tidak ada 
            else if ($e->getCode() === 1049) {
                return redirect(route('setup.index', ['tab' => 'DB']));
            } else {
                return redirect(route('setup.index'));
            }
        }
        return $next($request);
    }
}
