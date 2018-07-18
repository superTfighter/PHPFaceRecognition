<?php

namespace App\Middlewares;

use App\Traits\CoreTrait;

class ValidationMiddleware
{
    use CoreTrait;

    public function __invoke($request, $response, $next)
    {
        switch ($this->validation['type']) {
            case 'query':

                // Query params validator
                $filterParams = $this->Validator->queryParamsValidator($this->validation['rule']);

                break;
            case 'body':

                // Body params validator
                $filterParams = $this->Validator->bodyParamsValidator($request->getMethod(), $this->validation['rule']);

                break;
        }

        $this->Validator->validate($filterParams);

        if(!$this->Validator->passes()) {
            return $response->withJson($this->Validator->error(), 400);
        }
        
        $response = $next($request, $response);

        return $response;
    }
    
}