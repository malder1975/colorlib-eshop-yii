<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'bootstrap' => [
        'common\bootstrap\Containers'
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\MemCache',
            'servers' => [
                [
                    'host' => '127.0.0.1',
                    'port' => 11211,
                ],
            ],
            'useMemcached' => false,
            'serializer' => false,
            'options' => [
                'Memcached::OPT_COMPRESSION' => false,
                ],
        ],
    ],
];
