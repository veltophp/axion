<?php

namespace Velto\Axion\Middleware;

use Velto\Core\Request;
use Velto\Axion\Session;

class Admin
{
    public static function handle(Request $request, callable $next)
    {
        $user = Session::get('user');

        if (!$user || ($user->role ?? 'user') !== 'admin') {

            abort(404);
        }

        return $next($request);
    }

}
