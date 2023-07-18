<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Arr;

class Authenticate extends Middleware
{

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('login');
        } else {
            abort(response()->json([
                'success' => 'false',
                'message' => 'Unauthorized, Please login and try again.',
            ], 401));
        }
    }
}
