<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
{
    // Check if the user is not logged in and the current route is not the login route
    if(!session()->has('LoggedUser') && ($request->path() != 'authlogin')) {
        // Redirect to the login page with an error message
        return redirect('authlogin')->with('error', 'You must be logged in');
    }

    // Check if the user is logged in and trying to access the login route
    if(session()->has('LoggedUser') && ($request->path() == 'authlogin')) {
        // Redirect back to the previous page
        return back();
    }

    // If the conditions are met, continue to the next middleware or the route handler
    return $next($request);
}

}
