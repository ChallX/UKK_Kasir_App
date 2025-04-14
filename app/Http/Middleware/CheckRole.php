<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (Auth::check()) {
            if (strtolower(Auth::user()->role) === strtolower($role)) {
                return $next($request);
            } else {
                return redirect('/error')->withErrors(['error' => 'Access Denied']);
            }
        } else {
            return redirect('/')->withErrors(['error' => 'Please Log In']);
        }
    }
}
