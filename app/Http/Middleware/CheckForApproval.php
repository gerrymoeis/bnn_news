<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckForApproval
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Jika pengguna adalah Admin, lewati pemeriksaan persetujuan.
        if (auth()->check() && auth()->user()->role->name === 'Admin') {
            return $next($request);
        }

        // Untuk semua pengguna lain, jalankan pemeriksaan persetujuan.
        if (auth()->check() && !auth()->user()->isApproved()) {
            auth()->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect()->route('login')->with('status', 'Akun Anda sedang menunggu persetujuan Admin.');
        }

        return $next($request);
    }
}
