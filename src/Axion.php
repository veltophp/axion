<?php

namespace Velto\Axion;

class Axion
{
    public static function boot()
    {
        self::loadAliases();
        self::loadRoutes();
    }

    public static function loadRoutes(): void
    {
        $basePath = dirname(getcwd()) . '/axion/routes/';

        foreach (['auth.php', 'web.php'] as $file) {

            $fullPath = $basePath . $file;

            if (file_exists($fullPath)) {

                require_once $fullPath;

            } else {

                abort(404, '❌ Axion routes file not found.\n');
            }
            
        }

    }

    public static function loadAliases(): void
    {
        $aliasPath = BASE_PATH . '/axion/config/aliases.php';

        if (file_exists($aliasPath) && is_file($aliasPath)) {

            $aliases = require $aliasPath;

            foreach ($aliases as $alias => $class) {
                
                if (!class_exists($alias)) {

                    class_alias($class, $alias);
                }
            }
        }
    }

}
