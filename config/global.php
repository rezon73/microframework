<?php

return [
    'rootDir' => dirname(__FILE__) . '/..',
    'lockFileDir' => dirname(__FILE__) . '/../lockFiles',

    'curatorEmail' => 'rezon73@gmail.com',

    'memcached' => [
        'host' => '127.0.0.1',
        'port' => 11211,
    ],

    'databases' => [
        'database' => [
            'type'       => 'mysql',
            'connection' => 'mysql:host=localhost;dbname=database;charset=utf8',
            'user'       => 'user',
            'password'   => '',
        ],
    ],

    'logs' => [
        'enabled' => false,
    ],

    'telegram' => [
        'enabled'          => false,
        'messageMaxLength' => 4096,
        'apiKey'           => '',
    ],
];