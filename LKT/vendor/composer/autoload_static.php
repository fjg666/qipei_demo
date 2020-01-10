<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit56e729441bd7e803908bf9b1d30ad7f1
{
    public static $files = array (
        '6e60481d8c04e99474e2ba7b3658ab5a' => __DIR__ . '/..' . '/php-activerecord/php-activerecord/ActiveRecord.php',
    );

    public static $prefixLengthsPsr4 = array (
        't' => 
        array (
            'think\\' => 6,
        ),
        'O' => 
        array (
            'OSS\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'think\\' => 
        array (
            0 => __DIR__ . '/..' . '/topthink/think-image/src',
        ),
        'OSS\\' => 
        array (
            0 => __DIR__ . '/..' . '/aliyuncs/oss-sdk-php/src/OSS',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit56e729441bd7e803908bf9b1d30ad7f1::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit56e729441bd7e803908bf9b1d30ad7f1::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
