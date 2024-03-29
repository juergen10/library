<?php

namespace App\Http\Middleware;

use App\Response\Response;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */

    protected function unauthenticated($request, array $guards)
    {
        throw new AuthenticationException(
            'unauthorized',
            $guards,
            $this->redirectTo($request)
        );
    }

    protected function redirectTo(Request $request)
    {
        $request->headers->set('Accept', 'application/json');
    }
}
