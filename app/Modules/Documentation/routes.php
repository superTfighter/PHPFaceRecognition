<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get   ('/',                                     '@Documentation\MainAction:home' )                   ->setName('home');

$app->get   ('/alert',                                 '@Documentation\MainAction:alert' )                 ->setName('alert');

$app->get   ('/documentation/datatable',              '@Documentation\MainAction:datatable' )              ->setName('documentation_datatable');
$app->get   ('/documentation/datatable-json',         '@Documentation\MainAction:datatableJSONResponse' )  ->setName('documentation_datatable_json');

$app->get   ('/documentation/css-and-js',             '@Documentation\MainAction:cssJs' )                  ->setName('documentation_css_js');

$app->get   ('/documentation/alert',                  '@Documentation\MainAction:alert' )                  ->setName('documentation_alert');

$app->get   ('/documentation/ajax_url',               '@Documentation\MainAction:ajax_url' )               ->setName('documentation_ajax_url');
$app->get   ('/documentation/ajax_url_test_ok',       '@Documentation\MainAction:ajax_urlTestOK' )         ->setName('documentation_ajax_url_test_ok');
$app->get   ('/documentation/ajax_url_test_fail',     '@Documentation\MainAction:ajax_urlTestFail' )       ->setName('documentation_ajax_url_test_fail');

$app->get   ('/documentation/ajax_modal',             '@Documentation\MainAction:ajax_modal' )             ->setName('documentation_ajax_modal');
$app->get   ('/documentation/ajax_modal_test',        '@Documentation\MainAction:ajax_modalTest' )         ->setName('documentation_ajax_modal_test');
$app->get   ('/documentation/ajax_modal_test_json',   '@Documentation\MainAction:ajax_modalTestJSON' )     ->setName('documentation_ajax_modal_test_json');

$app->get   ('/documentation/ajax_form',              '@Documentation\MainAction:ajax_form' )              ->setName('documentation_ajax_form');
$app->post  ('/documentation/ajax_form_test',         '@Documentation\MainAction:ajax_formTest' )          ->setName('documentation_ajax_form_test');

$app->get   ('/documentation/bb',                     '@Documentation\MainAction:bb' )                     ->setName('documentation_bb');
$app->get   ('/documentation/bb_test',                '@Documentation\MainAction:bbTest' )                 ->setName('documentation_bb_test');

$app->get   ('/documentation/datetimepicker',         '@Documentation\MainAction:dateTimePicker' )         ->setName('documentation_datetimepicker');
