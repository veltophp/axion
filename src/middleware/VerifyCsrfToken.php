<?php

namespace Velto\Axion\Middleware;

/**
 * Defines the namespace for the VerifyCsrfToken middleware within the Axion module.
 * Middleware classes are used to intercept and process HTTP requests before they reach the application's controllers.
 */

use Closure;
/**
 * Imports the Closure class. Closures are anonymous functions that can be used as callbacks.
 */

class VerifyCsrfToken
{
    /**
     * Handles the incoming HTTP request to verify the CSRF token for specific HTTP methods.
     *
     * This method acts as middleware. It intercepts the request and checks if the HTTP
     * method is one that typically modifies data (POST, PUT, PATCH, DELETE). If it is,
     * it retrieves the CSRF token from the request input ('_token' field). It then uses
     * the 'csrf_verify()' function to validate the token against the expected value.
     * If the tokens do not match, it aborts the request with a 419 "CSRF token mismatch"
     * error. For other HTTP methods (like GET), the request is passed on to the next
     * middleware or the route handler without CSRF verification.
     *
     * @param Closure $next The next middleware in the pipeline or the route handler.
     * @return mixed The result of the next middleware or route handler if the CSRF token is valid (or the method doesn't require verification).
     */
    public function handle($request, Closure $next)
    {
        /**
         * Retrieves the HTTP method of the current request (e.g., GET, POST, PUT, DELETE).
         */
        $method = $request->method();

        /**
         * Checks if the request method is one that typically involves data modification.
         * CSRF protection is primarily important for these methods to prevent cross-site request forgery attacks.
         */
        if (in_array($method, ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            /**
             * Retrieves the CSRF token from the request input. It first tries to get it
             * from the '_token' field. If that field is not present, it defaults to an empty string.
             */
            $token = $request->input('_token') ?? '';

            /**
             * Verifies the retrieved CSRF token against the expected token stored in the session or elsewhere.
             * The 'csrf_verify()' function is assumed to handle this validation logic.
             * If the tokens do not match, it means the request might be a cross-site forgery attempt.
             */
            if (!csrf_verify($token)) {
                /**
                 * If the CSRF token is invalid, this line aborts the request and sends a 419 HTTP
                 * response with the message "CSRF token mismatch." This prevents the request
                 * from being processed further.
                 */
                abort(419, 'CSRF token mismatch.');
            }
        }

        /**
         * If the request method does not require CSRF verification (e.g., GET requests),
         * or if the CSRF token is valid for the modifying methods, this line passes
         * the request to the next middleware in the pipeline or the route handler
         * to continue processing the request.
         */
        return $next($request);
    }
}