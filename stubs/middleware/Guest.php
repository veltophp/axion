<?php

namespace Velto\Axion\Middleware;
use Velto\Core\Request;
use Velto\Axion\Session;

class Guest
{
    /**
     * @param Request $request The incoming HTTP request object.
     * @param callable $next The next middleware in the pipeline or the route handler.
     * @return mixed The result of the next middleware or route handler if the user is a guest.
     */
    public static function handle(Request $request, callable $next)
    {

        if (Session::has('user')) {
  
            header('Location: /dashboard');

            exit;
        }
        
        return $next($request);
    }
}