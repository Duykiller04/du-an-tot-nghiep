<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $routeId = $request->route('id'); // Lấy ID từ route

        if (Auth::check() && Auth::user()->type === 'admin') {
            return $next($request);
        }

        if (Auth::user()->type === 'staff' && Auth::id() != $routeId) {
            abort(403, 'Bạn không có quyền truy cập.');
        }

        return $next($request);
    }
}
