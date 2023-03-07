<?php

namespace App\Http\Middleware;

use App\Models\Room;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class IPAllow
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    private Room $room;
    public function __construct()
    {
        $this->room = new Room();
    }
    public function handle(Request $request, Closure $next, string $condition): Response
    {
        $room = $this->room->with('allowsIP')->where('status', 1)->where('name', $request->room)->first();
        if ($condition === 'check') {
            if ($room) {
                if (count($room->allowsIP)) {
                    $ipPc = gethostbyname(gethostname());
                    if ($this->check_ip_exist($ipPc, $room->allowsIP)) {
                        return $next($request);
                    }
                    Session::flash('error_rooms', true);
                    return redirect(route('error.block'));
                } else {
                    return $next($request);
                }
            } else {
                Session::flash('error_rooms', true);
                return redirect(route('error.index'));
            }
        } else if ($condition === 'error') {
            if (!Session::get('error_rooms')) {
                return redirect(route('uploader.index'));
            }
        }
        return $next($request);
    }
    protected function check_ip_exist(string $ipPc, object $allows): bool
    {
        $ips = [];
        foreach ($allows as $allow) {
            $ips[] = $allow->ip;
        }
        return in_array($ipPc, $ips);
    }
}
