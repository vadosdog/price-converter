<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2f9b73181460b77ddf7bf1fcc0be63f0
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/App',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2f9b73181460b77ddf7bf1fcc0be63f0::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2f9b73181460b77ddf7bf1fcc0be63f0::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}