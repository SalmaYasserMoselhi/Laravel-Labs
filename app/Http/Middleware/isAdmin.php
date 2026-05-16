<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Auth::user() return currently authenticated user
        if (!Auth::user()->is_admin) {
            return redirect()->route('dashboard')->with('error','You don\'t have permission to perform this action!');
        }
        return $next($request);
    }
}
