<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Check if the user has either 'admin' or 'supplier' role
            if ($user->hasRole('Super Admin')) {
                return $next($request);
            }
        }

        // Redirect to admin login if not authorized
        return redirect()->route('admin.login')->with('error', 'Access denied. Please log in as admin or supplier OR Activate your Account.');
    }
}
