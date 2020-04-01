<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

// $app->get   ('/examples',               '@Examples\MainAction:index' )->setName('examples_index');
$app->get   ('/examples/modal',            '@Examples\MainAction:modal' )->setName('examples_modal');
$app->get   ('/examples/datatable',        '@Examples\MainAction:datatable' )->setName('examples_datatable');
$app->get   ('/examples/css-and-js',       '@Examples\MainAction:cssJs' )->setName('examples_css_js');

$app->get   ('/examples/modal-json',       '@Examples\MainAction:modalJSONResponse' )->setName('examples_modal_json');
$app->get   ('/examples/datatable-json',   '@Examples\MainAction:datatableJSONResponse' )->setName('examples_datatable_json');

// $app->get   ('/examples/modal_test2',   '@Examples\MainAction:modalTest2' )->setName('examples_modal_test2');
// $app->post  ('/examples/form_test1',    '@Examples\MainAction:formTest1' )->setName('examples_form_test1');

