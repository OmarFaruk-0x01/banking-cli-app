<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitef0e36451a79ed7a1eeb704f5833230c
{
    public static $prefixLengthsPsr4 = array (
        'B' => 
        array (
            'BankingApp\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'BankingApp\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInitef0e36451a79ed7a1eeb704f5833230c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitef0e36451a79ed7a1eeb704f5833230c::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitef0e36451a79ed7a1eeb704f5833230c::$classMap;

        }, null, ClassLoader::class);
    }
}
