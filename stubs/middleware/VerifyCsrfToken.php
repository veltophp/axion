<?php

namespace Velto\Axion\Middleware;

use Closure;

class VerifyCsrfToken
{
    /**
     *
     * @param Closure $next The next middleware in the pipeline or the route handler.
     * @return mixed The result of the next middleware or route handler if the CSRF token is valid (or the method doesn't require verification).
     */
    public function handle($request, Closure $next)
    {

        $method = $request->method();

        if (in_array($method, ['POST', 'PUT', 'PATCH', 'DELETE'])) {

            $token = $request->input('_token') ?? '';

            if (!csrf_verify($token)) {

                abort(419, 'CSRF token mismatch.');
            }
        }

        return $next($request);
    }
}