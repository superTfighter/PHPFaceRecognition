<?php

return [
    'settings' => [
        'displayErrorDetails' => true,
        'debug' => true,

        // View settings
        'view' => [
            'template_path' => __DIR__ . '/Resources/views',
            'twig' => [
                'cache' => __DIR__ . '/../cache/twig',
                'debug' => true,
                'auto_reload' => true,
            ],
        ],

        // Database settings
        'pdo' => [
            'default'   => [
                'dsn'      => 'mysql:host=localhost;dbname=appdb;charset=utf8mb4;collation=utf8mb4_unicode_ci',
                'username' => 'username',
                'password' => 'password',
            ],
        
            'ticketing'   => [
                'dsn'      => 'mysql:host=ticketinghost;dbname=ticketing;charset=utf8mb4;collation=utf8mb4_unicode_ci',
                'username' => 'username',
                'password' => 'password',
            ],
        ],

        // Predis settings
        'predis' => [
            'host'   => '127.0.0.1',
            'port'   => '6379',
            'prefix' => 'profile:',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'app',
            'path' => 'php://stdout',
        ],

    ],
];
