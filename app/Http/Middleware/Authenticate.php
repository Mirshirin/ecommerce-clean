<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function authenticated(Request $request, $user)
{
   // dd($user->role === 'Super Admin' );
    if ($user->role === 'Super Admin' || $user->role === 'Admin') {
        return redirect()->route('admin.dashboard');
    }

    return redirect('/home'); // Redirect regular users to a different route

}

    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}
