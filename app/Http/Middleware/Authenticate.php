<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
{
    if (! $request->expectsJson()) {
        if (auth()->check() && auth()->user()->role === 'admin') {
            return route('admin.dashboard'); // Redirect admin
        }
        return route('login'); // Redirect pengguna biasa ke login
    }
}

}