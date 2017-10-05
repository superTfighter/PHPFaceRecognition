<?php

$container = $app->getContainer();

// -----------------------------------------------------------------------------
// Service providers
// -----------------------------------------------------------------------------

// Twig
$container['view'] = function($container) {

    $view = new \Slim\Views\Twig(
            __DIR__ . '/Resources/templates', [
            'cache' => false 
        ]);

    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));
    $view->addExtension(new Twig_Extension_Debug());

    $view->getEnvironment()->addGlobal("current_path", $container->get('request')->getUri()->getPath() );
    $view->getEnvironment()->addGlobal("skin", @$_COOKIE['skin'] );
    $view->getEnvironment()->addGlobal("sidebar_collapse", @$_COOKIE['sidebar_collapse'] );

    return $view;
};

// Flash message
$container['flash'] = function ($container) {
    return new \Slim\Flash\Messages;
};

// Global functions and variables
$container['utils'] = function($container) {
    return new \App\Globals\Utils($container);
};

// API
/*
$container['api'] = function ($container) {
    $api = new stdClass;

    // Centrex
    $config =   [ 'APIurl' => $conatiner['settings']['api']['centrex']['APIurl'],
                  'query' => ['lang' => 'hu'] ];
    $settings = [ 'headers' => [ 'User-Agent' => 'Centrex Front v0.1'] ];

    $api->centrex = new \ALFI\Api\CentrexApi(new \ALFI\Config($config), $settings);


    // Gitlab API
    $config =   ['APIurl' => $conatiner['settings']['api']['gitlab']['APIurl']];

    $settings = ['headers' => ['User-Agent' => $c->get('settings')['api']['user-agent'],
                               'PRIVATE-TOKEN' => $c->get('settings')['api']['gitlab']['token']]];
    
    $api->gitlab = new GeneralApi(new Config($config), $settings);

    return $api;
};
*/

// DB PDO
/*
$container['pdo'] = function ($c) {
    $pdo = new stdClass;

    // Default DB
    $pdo->default = new \Slim\PDO\Database($c->get('settings')['pdo']['default']['dsn'],
                                  $c->get('settings')['pdo']['default']['username'],
                                  $c->get('settings')['pdo']['default']['password'], array(PDO::ATTR_FETCH_TABLE_NAMES => false) );
    // Ticketing DB
    $pdo->ticketing = new \Slim\PDO\Database($c->get('settings')['pdo']['ticketing']['dsn'],
                                  $c->get('settings')['pdo']['ticketing']['username'],
                                  $c->get('settings')['pdo']['ticketing']['password'], array(PDO::ATTR_FETCH_TABLE_NAMES => true) );
    return $pdo;
};
*/

// PREDIS
/*
$container['predis'] = function ($c) {
  return new Predis\Client(['host'   => $c->get('settings')['predis']['host'],
                            'port'   => $c->get('settings')['predis']['port']],
                           ['prefix' => $c->get('settings')['predis']['prefix']]);
};
*/

// Monolog
$container['logger'] = function ($container) {
    $settings = $container['settings']['logger'];
    $logger = new \Monolog\Logger($settings['name']);
    $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
    $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['path'], \Monolog\Logger::DEBUG));

    return $logger;
};

// -----------------------------------------------------------------------------
// Actions - Repositories - Factories
// -----------------------------------------------------------------------------

$container['HomeAction'] = function($container) {
    return new \App\Actions\HomeAction($container);
};

$container['HomeRepository'] = function($container) {
    return new \App\Repositories\HomeRepository($container);
};
