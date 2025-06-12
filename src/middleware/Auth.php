<?php

namespace Velto\Axion\Middleware;

/**
 * Defines the namespace for the Auth middleware within the Axion module.
 * Middleware classes are used to intercept and process HTTP requests before they reach the application's controllers.
 */

use Velto\Core\Request;
/**
 * Imports the Request class from the Velto\Core namespace.
 * This class provides methods for interacting with the current HTTP request.
 */

use Velto\Axion\Session;
/**
 * Imports the Session class from the Veltophp\Axion namespace.
 * This class is used to manage user session data.
 */

class Auth
{
    /**
     * Handles the incoming HTTP request to check if the user is authenticated.
     *
     * This static method acts as middleware. It intercepts the request and checks
     * if the 'user' key exists in the current session. If the 'user' key is not
     * present, it means the user is not logged in, and the request is redirected
     * to the '/login' page. If the 'user' key exists, the request is passed on
     * to the next middleware or the route handler.
     *
     * @param Request $request The incoming HTTP request object.
     * @param callable $next The next middleware in the pipeline or the route handler.
     * @return mixed The result of the next middleware or route handler if the user is authenticated.
     */
    public static function handle(Request $request, callable $next)
    {
        /**
         * Checks if the 'user' key exists in the current session.
         * The Session::has() method returns true if the key exists, false otherwise.
         */
        if (!Session::has('user')) {
            /**
             * If the 'user' key is not found in the session, it means the user is not logged in.
             * This line sends an HTTP header to the browser to redirect the user to the '/login' page.
             */
            header('Location: /login');
            /**
             * After sending the redirect header, the script is terminated to prevent further execution
             * and ensure the user is redirected immediately.
             */
            exit;
        }

        /**
         * If the 'user' key exists in the session, it means the user is authenticated.
         * This line calls the next middleware in the pipeline or the route handler,
         * passing the current request object.
         */
        return $next($request);
    }
}