<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get   ('/', function($request, $response)  {  return $response->withRedirect($this->router->pathFor('home.index')); })->setName('home');

$app->get   ('/home', 'HomeAction:index' )->setName('home.index');