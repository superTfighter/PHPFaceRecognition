<?php

namespace App\Modules\IIR\Middlewares;

use App\Traits\CoreTrait;

class AuthMiddleware
{
    use CoreTrait;

    public function __invoke($request, $response, $next)
    {
        $protectedUrls = $this->container->get('settings')['settings']['IIR']['protected'];

        if(in_array($request->getUri()->getPath(),$protectedUrls))
        {
            // simpleSAMLphp
            $this->saml->requireAuth();
        }

        $response = $next($request, $response);

        return $response;

    }


}