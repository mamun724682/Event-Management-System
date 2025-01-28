<?php

namespace Database;

class DatabaseManager
{
    public static function migrate()
    {
        $files = glob(__DIR__ . '/migrations/*.php');
        self::getClass($files, 'up');
    }

    public static function deleteAll()
    {
        $files = glob(__DIR__ . '/migrations/*.php');
        self::getClass($files, 'down');
    }

    public static function seed()
    {
        $files = glob(__DIR__ . '/seeders/*.php');
        self::getClass($files, 'run');
    }

    private static function getClass($files, $method)
    {
        foreach ($files as $file) {
            require_once $file;

            // Get the file's contents to extract the namespace
            $contents = file_get_contents($file);
            $namespace = null;
            if (preg_match('/namespace\s+(.+?);/', $contents, $matches)) {
                $namespace = $matches[1];
            }

            // Get the class name
            $className = basename($file, '.php');
            $fullyQualifiedName = $namespace ? $namespace . '\\' . $className : $className;

            echo $fullyQualifiedName . "\n";

            // Check if the class exists and run the migration
            if (class_exists($fullyQualifiedName)) {
                $class = new $fullyQualifiedName();
                if (method_exists($class, $method)) {
                    echo "Running: $fullyQualifiedName\n";
                    $class->$method();
                }
            } else {
                echo "Class $fullyQualifiedName does not exist.\n";
            }
        }
    }
}
