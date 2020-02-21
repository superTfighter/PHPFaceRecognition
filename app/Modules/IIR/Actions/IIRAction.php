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
        $iir = $this->{'@IIR\IIRRepository'}->getInstituteByOMandKir('035247','001');
        
        var_dump($iir);

        var_dump($this->{'@IIR\LdapRepository'}->getDomain($iir['vpid']));

        die();
    }

    public function index($request, $response, $args)
    {
        return $this->view->render($response, '@IIR/index.twig');
    }
}