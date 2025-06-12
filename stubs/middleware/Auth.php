<?php

namespace Velto\Axion\Middleware;
use Velto\Core\Request;
use Velto\Axion\Session;

class Auth
{
    /**
     *
     * @param Request $request The incoming HTTP request object.
     * @param callable $next The next middleware in the pipeline or the route handler.
     * @return mixed The result of the next middleware or route handler if the user is authenticated.
     */
    public static function handle(Request $request, callable $next)
    {

        if (!Session::has('user')) {
     
            abort(404);

            exit;
        }

        return $next($request);
    }
}