<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get   ('/', 'HomeAction:index' )->setName('home');

// Validation example
$app->get   ('/validroute', 'HomeAction:indexValidationTest' )
            ->add(new App\Middlewares\ValidationMiddleware($container, ['validation' => [
                                                                                'type' => 'query',
                                                                                'rule' =>  'test']
                                                                        ] )) // Filter, validation;
            ->setName('indexValidationTest');