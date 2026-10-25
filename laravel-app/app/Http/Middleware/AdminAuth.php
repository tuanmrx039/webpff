<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('admin_logged_in') && !auth()->check()) {
            return redirect()->route('panel.login')->with('error', 'Silakan login terlebih dahulu untuk mengakses Super Admin Panel.');
        }

        return $next($request);
    }
}
