<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInited6eb4f409e6fb9311b1a327c2d771e5
{
    public static $files = array (
        '3ecc2648d41018ccbbd4a37cbf6c0d53' => __DIR__ . '/../..' . '/src/helpers.php',
    );

    public static $prefixLengthsPsr4 = array (
        'B' => 
        array (
            'BestTechCourses\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'BestTechCourses\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInited6eb4f409e6fb9311b1a327c2d771e5::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInited6eb4f409e6fb9311b1a327c2d771e5::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
