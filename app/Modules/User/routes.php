<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;



$app->get   ('/',                                    function($request,$response,$args){


    return $response->withRedirect($this->router->pathfor('login'));

});


$app->group('/login', function () use ($container) {

    $this->get('',            '@User\LoginAction:loginPage')->setName('login');
    $this->post('',           '@User\LoginAction:loginPost')->setName('login.post');

    $this->get('/face',       '@User\LoginAction:faceLogin')->setName('login.face');

});


$app->group('/register', function () use ($container) {

    $this->get('',            '@User\RegisterAction:registerPage')->setName('register');

});