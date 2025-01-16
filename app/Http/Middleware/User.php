<?php

namespace App\Http\Middleware;

use App\Models\UserRoleManagement;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class User
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Fetch the user's role based on the role_id from the authenticated user
        $userRole = UserRoleManagement::where('id', Auth::user()->role_id)->first();

        if ($userRole) {
            // Case-insensitive comparison for role_name and role_id check
            if (strcasecmp($userRole->role_name, 'User') === 0 && Auth::user()->role_id === $userRole->id) {
                return $next($request);
            }
        }

        // If unauthorized, log out the user and redirect to login with a notification
        Auth::logout();
        return redirect()->route('login')->with('error', 'You are not authorized to access this page.');
    }
}
