<?php

namespace App\Modules\User\Actions;

use App\Traits\CoreTrait;

use Slim\Http\Request;
use Slim\Http\Response;

class RegisterAction
{
    use CoreTrait;

    public function registerPage($request, $response, $args)
    {
        return $this->view->render($response, '@User\register.twig');
    }

    public function registerPost($request, $response, $args)
    {
        $postData = $request->getParsedBody();

        $resp = $this->{'@User\RegisterFactory'}->register($postData);

        return $response->withJson($resp);
    }


    public function facePost($request, $response, $args)
    {
        $postData = $request->getParsedBody();

        $id = $postData['id'];
        $base64_img = $postData['image'];

        $image = $this->base64ToImage($base64_img, __DIR__ . '/../../../../tempImages');


        if ($this->settings['settings']['luxand']) 
        {
            $resp = $this->{'@User\LuxandFactory'}->createOrUpdateUser($id, $image);
        } 
        else 
        {
            $resp = $this->{'@User\ApiFactory'}->createOrUpdateUser($id,$image);
        }

        return $response->withJson($resp);
    }

    public function train($request, $response, $args)
    {
        if ($this->settings['settings']['luxand'])
        {

            return $response->withStatus(200);
        }
        else
        {
            $resp = $this->{'@User\ApiFactory'}->train();
        }

        return $response->withJson($resp);

    }

    //Returns the formatted base64 image
    private function base64ToImage($base64_string, $output_folder)
    {
        $data = explode(',', $base64_string);

        $image = base64_decode($data[1]);

        if (!is_dir($output_folder)) {
            mkdir($output_folder, 0777, true);
        }

        $output_file = $output_folder . '/' . rand() . '.png';

        file_put_contents($output_file, $image);

        return $data[1];
    }
}
