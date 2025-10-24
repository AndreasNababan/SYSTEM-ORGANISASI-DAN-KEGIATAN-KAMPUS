<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles (daftar role yang diizinkan)
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Jika user tidak login atau rolenya tidak ada di daftar $roles
        if (! $request->user() || ! in_array($request->user()->role, $roles)) {
            // Redirect ke dashboard (atau halaman lain)
            return redirect('/dashboard')->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}