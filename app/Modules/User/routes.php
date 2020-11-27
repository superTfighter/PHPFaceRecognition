<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/delete',            '@User\LoginAction:deleteAll');

$app->get   ('/',                                    function($request,$response,$args){


    return $response->withRedirect($this->router->pathfor('login'));
});


$app->group('/login', function () use ($container) {

    $this->get('',            '@User\LoginAction:loginPage')->setName('login');
    $this->post('',           '@User\LoginAction:loginPost')->setName('login.post');

    $this->get('/face',       '@User\LoginAction:faceLogin')->setName('login.face');
    $this->post('/face',      '@User\LoginAction:faceLoginPost')->setName('login.face.post');

});

$app->group('/user', function () use ($container) {

    $this->get('',            '@User\LoginAction:userDataPage')->setName('userData');

});



$app->group('/register', function () use ($container) {

    $this->get('',            '@User\RegisterAction:registerPage')->setName('register');
    $this->post('',           '@User\RegisterAction:registerPost')->setName('register.post');

    $this->post('/face',      '@User\RegisterAction:facePost')->setName('register.face.post');

    $this->get('/train' ,     '@User\RegisterAction:train')->setName('register.face.train');

});