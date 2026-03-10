<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles  Supports multiple roles separated by pipe (|)
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        // Check if user has any of the required roles
        foreach ($roles as $role) {
            // Support pipe-separated roles (e.g., 'admin|owner')
            $allowedRoles = explode('|', $role);

            foreach ($allowedRoles as $allowedRole) {
                if ($user->role === trim($allowedRole)) {
                    return $next($request);
                }
            }
        }

        // User doesn't have required role
        return redirect('/')
            ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
    }
}
