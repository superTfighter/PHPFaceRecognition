<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;




$app->group ('/iir',function () use ($app) {

    $app->get('', '@IIR\IIRAction:index')->setName('iir');
    $app->get('/test', '@IIR\IIRAction:test')->setName('iir_test');



});
