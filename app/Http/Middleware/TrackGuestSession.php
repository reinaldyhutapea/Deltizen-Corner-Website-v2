<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class TrackGuestSession
{

    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->hasCookie('visitor_id')) {
            // UUID yang dipersingkat menjadi 16 karakter
            $visitorId = substr(Str::uuid()->toString(), 0, 16);

            cookie()->queue(cookie('visitor_id', $visitorId, 60 * 24 * 30)); // Simpan 30 hari
            session(['visitor_id' => $visitorId]); // Simpan di session juga
        } else {
            $visitorId = substr($request->cookie('visitor_id'), 0, 16); // Pastikan tetap 16 karakter
            session(['visitor_id' => $visitorId]);
        }

        return $next($request);
    }
}