<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3dcb0cd3b9802939155e959c3c6cfd5d
{
    public static $prefixLengthsPsr4 = array (
        'N' => 
        array (
            'NitroPack\\SDK\\' => 14,
            'NitroPack\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'NitroPack\\SDK\\' => 
        array (
            0 => __DIR__ . '/../..' . '/NitroPack/SDK',
        ),
        'NitroPack\\' => 
        array (
            0 => __DIR__ . '/..' . '/nitropack/httpclient/src',
            1 => __DIR__ . '/..' . '/nitropack/url/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit3dcb0cd3b9802939155e959c3c6cfd5d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3dcb0cd3b9802939155e959c3c6cfd5d::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit3dcb0cd3b9802939155e959c3c6cfd5d::$classMap;

        }, null, ClassLoader::class);
    }
}