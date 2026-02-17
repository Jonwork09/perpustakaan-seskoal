<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Mengecek apakah role sesuai dengan yang diminta
        if (!Auth::check() || Auth::user()->role !== $role) {
            // Jika role tidak sesuai, lempar ke dashboard masing-masing atau tampil 403
            return redirect('/dashboard')->with('error', 'Akses ditolak!');
        }

        return $next($request);
    }
}
