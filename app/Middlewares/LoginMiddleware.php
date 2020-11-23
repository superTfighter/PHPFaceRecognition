<?php

namespace App\Middlewares;

use App\Traits\CoreTrait;

class LoginMiddleware
{
    use CoreTrait;

    public function __invoke($request, $response, $next)
    {

        $passT = $this->container->get('settings')['settings']['passthrough'];

        if (!$this->auth->isLoggedIn() && !in_array($request->getUri()->getPath(), $passT)) {

           return $response->withRedirect($this->router->pathFor('login'));
        }

        $response = $next($request, $response);

        return $response;
    }
}
