<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get   ('/',                                '@Documentation\MainAction:modal' )                  ->setName('home');

$app->get   ('/documentation/url',               '@Documentation\MainAction:url' )                    ->setName('documentation_url');
$app->get   ('/documentation/modal',             '@Documentation\MainAction:modal' )                  ->setName('documentation_modal');
$app->get   ('/documentation/datatable',         '@Documentation\MainAction:datatable' )              ->setName('documentation_datatable');
$app->get   ('/documentation/css-and-js',        '@Documentation\MainAction:cssJs' )                  ->setName('documentation_css_js');

$app->get   ('/documentation/modal-json',        '@Documentation\MainAction:modalJSONResponse' )      ->setName('documentation_modal_json');
$app->get   ('/documentation/datatable-json',    '@Documentation\MainAction:datatableJSONResponse' )  ->setName('documentation_datatable_json');

$app->get   ('/documentation/url_test1_ok',      '@Documentation\MainAction:urlTest1OK' )             ->setName('documentation_url_test1ok');
$app->get   ('/documentation/url_test1_fail',    '@Documentation\MainAction:urlTest1Fail' )           ->setName('documentation_url_test1fail');

$app->get   ('/documentation/modal_test1',       '@Documentation\MainAction:modalTest1' )             ->setName('documentation_modal_test1');
$app->get   ('/documentation/modal_test2',       '@Documentation\MainAction:modalTest2' )             ->setName('documentation_modal_test2');
$app->post  ('/documentation/form_test1',        '@Documentation\MainAction:formTest1' )              ->setName('documentation_form_test1');
