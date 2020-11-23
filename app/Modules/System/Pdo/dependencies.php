<?php

$container['database'] = function ($container) {


    $pdo = new \PDO('sqlite:' .__DIR__ . '/../../../../DB/database');

    $db = \Delight\Db\PdoDatabase::fromPdo($pdo, true);

    return $db;
};

$container['auth'] = function ($container) {

    $db = $container->database;

    $auth = new \Delight\Auth\Auth($db);

    return $auth;
};
