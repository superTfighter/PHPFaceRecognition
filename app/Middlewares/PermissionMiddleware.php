<?php

namespace App\Middlewares;

use App\Traits\CoreTrait;

class PermissionMiddleware
{
    use CoreTrait;

    public function __invoke($request, $response, $next)
    {
        $response = $next($request, $response);

        return $response;
    }
}
