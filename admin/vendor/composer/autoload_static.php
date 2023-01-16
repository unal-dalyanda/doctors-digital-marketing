<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb6ed9dbefda027e6bd943266d48d0877
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'Windwalker\\Edge\\' => 16,
            'Whoops\\' => 7,
        ),
        'S' => 
        array (
            'System\\' => 7,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
            'PHPMailer\\PHPMailer\\' => 20,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Windwalker\\Edge\\' => 
        array (
            0 => __DIR__ . '/..' . '/windwalker/edge',
        ),
        'Whoops\\' => 
        array (
            0 => __DIR__ . '/..' . '/filp/whoops/src/Whoops',
        ),
        'System\\' => 
        array (
            0 => __DIR__ . '/../..' . '/System',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/App',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb6ed9dbefda027e6bd943266d48d0877::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb6ed9dbefda027e6bd943266d48d0877::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitb6ed9dbefda027e6bd943266d48d0877::$classMap;

        }, null, ClassLoader::class);
    }
}