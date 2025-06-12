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
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        foreach ($roles as $role) {
            // Check if user has the role
            if ($user->role->name === $role) {
                return $next($request);
            }
        }

        abort(403, 'AKSES DITOLAK. ANDA TIDAK MEMILIKI WEWENANG.');
    }
}
