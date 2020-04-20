<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get   ('/',                                '@Documentation\MainAction:modal' )                  ->setName('home');

$app->get   ('/documentation/datatable',         '@Documentation\MainAction:datatable' )              ->setName('documentation_datatable');
$app->get   ('/documentation/datatable-json',    '@Documentation\MainAction:datatableJSONResponse' )  ->setName('documentation_datatable_json');

$app->get   ('/documentation/css-and-js',        '@Documentation\MainAction:cssJs' )                  ->setName('documentation_css_js');

$app->get   ('/documentation/url',               '@Documentation\MainAction:url' )                    ->setName('documentation_url');
$app->get   ('/documentation/url_test_ok',       '@Documentation\MainAction:urlTestOK' )               ->setName('documentation_url_test_ok');
$app->get   ('/documentation/url_test_fail',     '@Documentation\MainAction:urlTestFail' )             ->setName('documentation_url_test_fail');

$app->get   ('/documentation/modal',             '@Documentation\MainAction:modal' )                  ->setName('documentation_modal');
$app->get   ('/documentation/modal_test',        '@Documentation\MainAction:modalTest' )              ->setName('documentation_modal_test');
$app->get   ('/documentation/modal_test_json',   '@Documentation\MainAction:modalTestJSON' )          ->setName('documentation_modal_test_json');

$app->get   ('/documentation/form',              '@Documentation\MainAction:form' )                   ->setName('documentation_form');
$app->post  ('/documentation/form_test',         '@Documentation\MainAction:formTest' )               ->setName('documentation_form_test');
