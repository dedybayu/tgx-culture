<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        // If authenticated but not admin, redirect with unauthorized message
        if (Auth::check()) {
            return redirect()->route('admin.katalog.index')
                ->with('error', 'Anda tidak memiliki hak akses untuk halaman tersebut.');
        }

        return redirect()->route('login');
    }
}
