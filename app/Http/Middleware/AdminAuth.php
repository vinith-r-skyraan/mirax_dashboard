<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('admin_id')) {
            if ($request->routeIs('login')) {
                return $next($request);
            }

            return redirect()->route('login'); // ✅ FIXED
        }

        return $next($request);
    }
}
