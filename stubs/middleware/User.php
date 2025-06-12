<?php

namespace Velto\Axion\Middleware;

use Velto\Core\Request;
use Velto\Axion\Session;

class User
{
    public static function handle(Request $request, callable $next)
    {
        $user = Session::get('user');

        if (!$user || ($user->role ?? 'user') !== 'user') {
            
            return $next($request);
        }

        return $next($request);
    }

}
