<?php

/**
 * Class Publisher in namespace Veltophp\Axion\Commands.
 * Structure: Contains static methods `publish()` and `copyDirectory()`.
 *
 * How it works:
 * - `publish()`: Publishes stub files from the package's 'stubs/' directory to the application's 'axion/' directory.
 * - Prompts for overwrite confirmation if the target directory exists.
 * - Calls `copyDirectory()` to handle the file copying.
 *
 * - `copyDirectory()`: Recursively copies files and directories from a source to a destination.
 * - Creates the destination directory if needed.
 * - Skips '.' and '..' entries.
 * - Recursively copies subdirectories.
 * - Copies new files; skips existing ones with a message.
 */

namespace Velto\Axion\Commands;

class Publisher
{
    public static function publish()
    {
        $sourceDir = __DIR__ . '/../../stubs/';
        $targetDir = BASE_PATH . '/axion';

        if (is_dir($targetDir)) {
            echo "⚠️  The 'axion/' folder already exists.\n";
            echo "Do you want to overwrite its contents? (y/N): ";
            $handle = fopen("php://stdin", "r");
            $line = trim(fgets($handle));
            if (strtolower($line) !== 'y') {
                echo "🚫 Canceled. No files were overwritten.\n";
                return;
            }
        }

        self::copyDirectory($sourceDir, $targetDir);
        echo "✅ Axion was successfully published to the 'axion/' folder.\n";
    }

    protected static function copyDirectory($source, $destination)
    {
        if (!is_dir($destination)) {
            mkdir($destination, 0755, true);
        }

        $items = scandir($source);
        foreach ($items as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }

            $src = $source . '/' . $item;
            $dst = $destination . '/' . $item;

            if (is_dir($src)) {
                self::copyDirectory($src, $dst);
            } elseif (!file_exists($dst)) {
                copy($src, $dst);
            } else {
                echo "🔁 Skipped existing file: $dst\n";
            }
        }
    }
}
