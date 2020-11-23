<?php

namespace App\Modules\User\Actions;

use App\Traits\CoreTrait;

use Slim\Http\Request;
use Slim\Http\Response;

class LoginAction
{
    use CoreTrait;
    
    public function loginPage($request,$response,$args)
    {
        return $this->view->render($response,'@User\login.twig');
    }

}
