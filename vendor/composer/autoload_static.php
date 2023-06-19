<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitbbcc055aa215d2fa6b9a672c189ae0c9
{
    public static $prefixLengthsPsr4 = array (
        'R' => 
        array (
            'Raquel\\Api\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Raquel\\Api\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitbbcc055aa215d2fa6b9a672c189ae0c9::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitbbcc055aa215d2fa6b9a672c189ae0c9::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitbbcc055aa215d2fa6b9a672c189ae0c9::$classMap;

        }, null, ClassLoader::class);
    }
}