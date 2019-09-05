<?php

namespace App\Modules\HelloWorld\Actions;

use App\Traits\CoreTrait;
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\ExceptionInterface;
use Respect\Validation\Exceptions\ValidationException;

use Slim\Http\Request;
use Slim\Http\Response;

class MainAction
{
	use CoreTrait;

    public function index(Request $request, Response $response, $args)
    {

        return $this->view->render($response, '@HelloWorld/index.twig');   
    }

    public function modalTest1(Request $request, Response $response, $args)
    {
        $data = $this->api->iir->call('/cim', ['query' => ['limit' => 5]]);

        return $this->view->render($response, '@HelloWorld/modal_test1.twig', ['data' => $data]);   
    }

    public function modalTest2(Request $request, Response $response, $args)
    {
        return $this->view->render($response, '@HelloWorld/modal_test2.twig');   
    }

    // Submit hook
    public function formTest1(Request $request, Response $response, $args)
    {

        // start Validator block
        $body   = $request->getParsedBody();
        $method = $request->getMethod();

        // Custom module validation rules
        $validator =  $this->{'@HelloWorld\Validation'}->validator("test", $method, $body);
        // end Validator block


        return $response->withJson(array(
            'info'    => 'Invalid parameter',
            'status'  => 'ERROR',
            't' => $validator,
            'validation_messages' => array(
                'Nincs jogosultsága a művelethez!'
            ),
            'code' => 400
        ), 400);
    }

    /*
    public function indexValidationTest(Request $request, Response $response, $args)
    {
    	$message = $this->HomeRepository->getMessage();

        return $this->view->render($response, '@HelloWorld/index.twig', ['message' => $message]);      
    }
    */

}
