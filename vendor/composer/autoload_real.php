<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitef0e36451a79ed7a1eeb704f5833230c
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInitef0e36451a79ed7a1eeb704f5833230c', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitef0e36451a79ed7a1eeb704f5833230c', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitef0e36451a79ed7a1eeb704f5833230c::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
