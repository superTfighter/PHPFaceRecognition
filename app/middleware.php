<?php
// Application middleware

// slim-session
$app->add(new \Slim\Middleware\Session([
  'name'        => 'SESSID',
  'autorefresh' => true,
  'lifetime'    => '3 hour'
]));
