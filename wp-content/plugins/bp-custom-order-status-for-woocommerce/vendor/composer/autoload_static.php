<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite52327ec23b4b5ae4f02df46e0bf3838
{
    public static $files = array (
        'fadc9d050b79909d76710da87649cb3a' => __DIR__ . '/../..' . '/include/codestar/codestar-framework.php',
    );

    public static $prefixLengthsPsr4 = array (
        'B' => 
        array (
            'Brightplugins_COS\\' => 18,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Brightplugins_COS\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'PAnD' => __DIR__ . '/..' . '/collizo4sky/persist-admin-notices-dismissal/persist-admin-notices-dismissal.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite52327ec23b4b5ae4f02df46e0bf3838::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite52327ec23b4b5ae4f02df46e0bf3838::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInite52327ec23b4b5ae4f02df46e0bf3838::$classMap;

        }, null, ClassLoader::class);
    }
}