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

        // Jika folder tidak ada, anggap tidak pakai Axion (tidak perlu error)
        if (!is_dir($basePath)) {
            return;
        }

        foreach (['auth.php', 'web.php'] as $file) {
            $fullPath = $basePath . $file;

            // Hanya load jika file ada
            if (file_exists($fullPath)) {
                require_once $fullPath;
            }
            // Jika file tidak ada, cukup dilewatkan (tidak error)
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
