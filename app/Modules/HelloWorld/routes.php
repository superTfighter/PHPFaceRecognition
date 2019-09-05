<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get   ('/', '@HelloWorld\MainAction:index' )->setName('home');

$app->get   ('/helloworld',             '@HelloWorld\MainAction:index' )->setName('helloworld_index');
$app->get   ('/helloworld/modal_test1', '@HelloWorld\MainAction:modalTest1' )->setName('helloworld_modal_test1');
$app->get   ('/helloworld/modal_test2', '@HelloWorld\MainAction:modalTest2' )->setName('helloworld_modal_test2');
$app->post  ('/helloworld/form_test1',  '@HelloWorld\MainAction:formTest1' )->setName('helloworld_form_test1');

