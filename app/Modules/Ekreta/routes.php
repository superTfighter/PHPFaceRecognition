<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


$app->get('/', function ($request, $response) {
    return $response->withRedirect($this->router->pathFor('login'));
});

$app->get('/login', '@Ekreta\EkretaAction:login')->setName('login');
$app->post('/login',  '@Ekreta\EkretaAction:loginPost')->setName('loginPost');

$app->get('/implicit', '@Ekreta\EkretaAction:implicit')->setName('implicit');
$app->get('/implicit/get', '@Ekreta\EkretaAction:implicitGet')->setName('implicitGet');
$app->get('/token/{token}', '@Ekreta\EkretaAction:tokenCheck')->setName('tokenCheck');

$app->get('/userData', '@Ekreta\EkretaAction:userData')->setName('userData');
$app->get('/register', '@Ekreta\EkretaAction:register')->setName('register');
$app->post('/register', '@Ekreta\EkretaAction:registerPost')->setName('registerPost');

/*
$app->group ('/ekreta',function () use ($app) {

    $app->get('/test', '@Ekreta\EkretaAction:test')->setName('ekreta_test');

});*/
