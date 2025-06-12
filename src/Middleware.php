<?php

/**
 * Class Middleware in namespace Veltophp\Axion\Middleware.
 *
 * Structure:
 * - Defines a class `Middleware` to manage and execute application middleware.
 * - Contains a static `handle()` method to run default middleware.
 * - Contains a protected static `verifyCsrf()` method for CSRF token verification.
 *
 * How it works:
 * - `handle(Request $request, callable $next)`:
 * - This is the main entry point for executing the application's default middleware pipeline.
 * - It first calls `verifyCsrf()` to handle CSRF protection.
 * - It includes a placeholder comment indicating where other middleware can be added in the future.
 * - Finally, it calls the `$next` callable, which represents the next middleware in the chain or the route handler.
 *
 * - `verifyCsrf(Request $request)`:
 * - This method implements CSRF (Cross-Site Request Forgery) protection specifically for POST requests.
 * - It checks if the request method is POST.
 * - If it's a POST request, it retrieves the CSRF token from the `_token` input field of the request.
 * - It also retrieves the CSRF token stored in the session under the `_token` key.
 * - It then compares the token from the request with the token from the session.
 * - If the tokens are missing or do not match, it terminates the script execution with an "Invalid CSRF token" message.
 */

namespace Velto\Axion\Middleware;

use Velto\Core\Request;
use Velto\Axion\Session;

class Middleware
{
    public static function handle(Request $request, callable $next)
    {
        self::verifyCsrf($request);

        return $next($request);
    }

    protected static function verifyCsrf(Request $request): void
    {
        if ($request->method() === 'POST') {

            $token = $request->input('_token');

            $sessionToken = Session::get('_token');

            if (!$token || $token !== $sessionToken) {

                abort(404, '❌ Invalid CSRF token.\n');

            }

        }

    }

}