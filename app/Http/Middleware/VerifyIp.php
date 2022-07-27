<?php

namespace App\Http\Middleware;

use App\Models\IpFilter;
use Closure;
use Illuminate\Http\Request;

class VerifyIp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (($request->ip() !== '127.0.0.1') && config('admin.ip_verify')) {
            $ips = IpFilter::all()->get('ip_address');

            if ($ips && !in_array($request->ip(), $ips, true)) {
                // TODO: Implement
            }
        }

        return $next($request);
    }
}
