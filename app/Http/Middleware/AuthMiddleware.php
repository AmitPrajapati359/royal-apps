<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class AuthMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Session::has('api_token')) {
            return redirect()->route('login');
        }

        if(app('App\Services\CandidateApiService')->isTokenExpired()) {
            if(!app('App\Services\CandidateApiService')->refreshToken()) {
                return redirect()->route('login')->withErrors(['error' => 'Session expired. Please login again.']);
            }
        }

        return $next($request);
    }
}
