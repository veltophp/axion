<?php

/**
 * Configuration array for application aliases.
 *
 * This array defines aliases for classes, allowing them to be accessed using shorter,
 * more convenient names.  In this case, it's creating an alias for the Auth class.
 *
 * @return array An associative array where keys are the aliases and values are the
 * fully qualified class names.
 */
return [
    /**
     * Defines an alias 'Auth' for the Veltophp\Axion\App\Auth class.
     * This allows developers to use 'Auth' instead of the longer class name
     * throughout the application, improving code readability.
     */
    'Auth' => \Velto\Axion\App\Auth::class,
];