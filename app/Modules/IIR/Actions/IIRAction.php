<?php

namespace App\Modules\IIR\Actions;

use App\Traits\CoreTrait;
use Slim\Http\Request;
use Slim\Http\Response;


class IIRAction
{
    use CoreTrait;

    public function test($request, $response, $args)
    {
        var_dump($this->{'@IIR\LdapRepository'}->getAllDomains());die();
    }

    public function index($request, $response, $args)
    {
        return $this->view->render($response, '@IIR/index.twig');
    }
}