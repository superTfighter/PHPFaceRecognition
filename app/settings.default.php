<?php

return [
    'settings' => [
        'displayErrorDetails' => true,
        'debug' => true,

        // Load Modules
        'modules' => [
            // Special core module
            // * default install with skeleton
            'System'   => [
                'enabled'      => true,
                'weight'       => 0, // Core module first loads, don't change it!
                'dependencies' => [
                    'Handler'   => ['enabled' => true,   'weight' => 0], // Error handler
                    'Mail'      => ['enabled' => true,   'weight' => 1], // * Need: 'composer require phpmailer/phpmailer'
                    'Logger'    => ['enabled' => true,   'weight' => 1], // * Need: 'composer require monolog/monolog'
                    'View'      => ['enabled' => true,   'weight' => 1], // * Need: 'composer require slim/twig-view'
                    'Api'       => ['enabled' => true,   'weight' => 2], // Need: 'composer require guzzlehttp/guzzle' before enable
                    'Globals'   => ['enabled' => false,  'weight' => 3],  
                    'Pdo'       => ['enabled' => false,  'weight' => 3], // Need: 'composer require faapz/pdo' before enable
                    'Predis'    => ['enabled' => false,  'weight' => 3], // Need: 'composer require predis/predis' before enable
                    'Saml'      => ['enabled' => false,  'weight' => 3], // Need: 'composer require simplesamlphp/simplesamlphp niif/simplesamlphp-module-attributeaggregator' + configuration before enable
                    'Session'   => ['enabled' => true,   'weight' => 3], // Need: 'bryanjhv/slim-session'
                ],
            ],

            // Documentation custom module
            'Documentation'  => [
                'enabled' => true,
                'weight'  => 1, // Module load order
            ],



        ],

        // Load Settings
        'settings' => [
            // Special core module settings
            'System'   => [

                // Database settings
                'Pdo' => [
                    'default'   => [
                        'dsn'      => 'mysql:host=localhost;dbname=appdb;charset=utf8mb4;collation=utf8mb4_unicode_ci',
                        'username' => 'username',
                        'password' => 'password',
                        'pdo'      => array(PDO::ATTR_FETCH_TABLE_NAMES => false)
                    ],
                
                    'ticketing'   => [
                        'dsn'      => 'mysql:host=ticketinghost;dbname=ticketing;charset=utf8mb4;collation=utf8mb4_unicode_ci',
                        'username' => 'username',
                        'password' => 'password',
                        'pdo'      => array(PDO::ATTR_FETCH_TABLE_NAMES => true)
                    ],
                ],

                // API settings
                'Api' => [

                    // IIR API
                    'iir'  => [
                        'class'              => 'IIRApi',
                        'user-agent'         => 'IIR Front 3.0',
                        'options' => [
                            'APIurl'         => 'https://api.iir.niif.hu/v1/',
                            'ASClientId'     => 'client_id',     // Credential client id
                            'ASClientSecret' => 'client_secret', // Credential secret
                            'ASClientScopes' => 'grantAll',      // Credential scopes (whitespace separated)
                            'cachePath'      => 'cache/',        // Optional cache path
                        ],
                    ],
                ],

                // Predis settings
                'Predis' => [
                    'host'   => '127.0.0.1',
                    'port'   => '6379',
                    'prefix' => 'profile:',
                ],

                // PHPMailer settings
                'Mail' => [
                    'host'      => 'front.iir.niif.hu',
                    'port'      => 25,
                    'secure'    => 'ssl',
                    'auth'      => false,
                    'username'  => '',
                    'password'  => '',
                    'fromName'  => 'skeleton',
                    'fromEmail' => 'skeleton@niif.hu',
                    'errorsToEmail' => '',
                    // Error handler ide kuldi a hibakat:
                    'logEmails' => [
                        'kukkjanos@niif.hu',
                    ],
                ],

                // Monolog settings
                'Logger' => [
                    'name' => 'app',
                    'path' => 'php://stdout',
                ],

                // View settings
                'View' => [
                    'template_path' => __DIR__ . '/Resources/templates', // __main__ directory
                    'twig' => [ // https://twig.symfony.com/doc/2.x/api.html#environment-options
                        //'cache'       => __DIR__ . '/../cache/twig',
                        'cache'            => false,
                        'charset'          => 'utf-8',
                        'strict_variables' => false,
                        'debug'            => true,
                        'auto_reload'      => true,
                    ],
                ],

            ],

            // Custom module settings
            'HelloWorld'   => [
                'test'    => "ok123",
            ],

        ],
    ],
];
