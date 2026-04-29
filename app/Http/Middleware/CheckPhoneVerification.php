<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPhoneVerification
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && !Auth::user()->phone_verified_at) {
            return redirect()->route('whatsapp.verify');
        }
        
        return $next($request);
    }
}