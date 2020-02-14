<?php
// Application middleware

// slim-session
$app->add(new \Slim\Middleware\Session([
  'name'        => 'SESSID',
  'autorefresh' => true,
  'lifetime'    => '3 hour'
]));


// SAML Auth
$app->add(new \App\Modules\IIR\Middlewares\AuthMiddleware($app->getContainer()));