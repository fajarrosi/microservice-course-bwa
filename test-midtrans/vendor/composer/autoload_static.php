<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3c3561396c433f7df82dbc49464db93b
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Midtrans\\' => 9,
        ),
        'A' => 
        array (
            'Asus\\TestMidtrans\\' => 18,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Midtrans\\' => 
        array (
            0 => __DIR__ . '/..' . '/midtrans/midtrans-php/Midtrans',
        ),
        'Asus\\TestMidtrans\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit3c3561396c433f7df82dbc49464db93b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3c3561396c433f7df82dbc49464db93b::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit3c3561396c433f7df82dbc49464db93b::$classMap;

        }, null, ClassLoader::class);
    }
}
