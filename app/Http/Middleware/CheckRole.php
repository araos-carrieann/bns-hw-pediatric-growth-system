<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        // Check if the user is not authenticated
        if (!session()->has('LoggedUser')) {
            return redirect('authlogin')->with('error', 'You must be logged in');
        }

        // Check if the user has the specified role
        if ($role !== session('UserRole')) {
            return back();
        }

        // Allow the request to continue
        return $next($request);
    }
}
