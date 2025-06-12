<?php

/**
 * Class Controller in namespace Veltophp\Axion.
 * Structure:
 * - Defines a base `Controller` class.
 * - Contains protected methods `jsonResponse()` and `htmlResponse()`.
 *
 * How it works:
 * - `jsonResponse($data, $status = 200)`:
 * - Sets the `Content-Type` header to `application/json`.
 * - Sets the HTTP response status code to the provided `$status` (defaults to 200 OK).
 * - Encodes the provided `$data` array or object into a JSON string and echoes it.
 *
 * - `htmlResponse($view, $data = [])`:
 * - This method is intended to handle HTML responses.
 * - The current implementation includes a comment suggesting the use of a `renderView()` function (which is not defined in this snippet) to process and output the HTML view with the provided `$data`.
 */

namespace Velto\Axion;

class Controller
{
    protected function jsonResponse($data, $status = 200)
    {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode($data);
    }

    protected function htmlResponse($view, $data = [])
    {
        // 
    }
}
