<?php

namespace App\Actions;

use App\Traits\CoreTrait;

class HomeAction
{

	use CoreTrait;

    public function index($request, $response)
    {

    	$message = $this->HomeRepository->getMessage();

        return $this->view->render($response, 'home/index.twig', ['message' => $message]);
        
    }
}
