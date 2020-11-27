<?php

namespace App\Modules\User\Actions;

use App\Traits\CoreTrait;

use Slim\Http\Request;
use Slim\Http\Response;

class LoginAction
{
    use CoreTrait;

    public function loginPage($request, $response, $args)
    {
        return $this->view->render($response, '@User\login.twig');
    }

    public function faceLogin($request, $response, $args)
    {
        return $this->view->render($response, '@User\facelogin.twig');
    }

    public function faceLoginPost($request, $response, $args)
    {
        $base64_img = $request->getParsedBody()['image'];


        if($this->settings['settings']['luxand']){

            $imgFile = $this->base64ToImage($base64_img,__DIR__ . '/../../../../tempImages');
            $resp = $this->{'@User\LuxandRepository'}->recognize($imgFile);

        }else{

            $resp = $this->{'@User\ApiRepository'}->recognize($this->parseBase64Image($base64_img));

        }

        return $response->withJson($resp);
    }

    public function loginPost($request, $response, $args)
    {
        $postData = $request->getParsedBody();

        $responseData = $this->{'@User\LoginRepository'}->login($postData);

        return $response->withJson($responseData);
    }

    public function userDataPage($request, $response, $args)
    {
        $id = $this->auth->getUserId();

        $user = $this->{'@User\LoginRepository'}->getUserById($id);

        var_dump($user);

        return $this->view->render($response, '@User\userData.twig',['user' => $user]);
    }

    public function deleteAll($request, $response, $args)
    {
        $this->{'@User\LuxandFactory'}->deleteAllLuxandPerson();

        
        return $response;

    }

    private function parseBase64Image($base64_string)
    {
        $data = explode(',', $base64_string);

        return $data[1];
    }

    private function base64ToImage($base64_string, $output_folder)
    {
        $data = explode(',', $base64_string);

        $image = base64_decode($data[1]);

        if (!is_dir($output_folder)) {
            mkdir($output_folder, 0777, true);
        }

        $output_file = $output_folder . '/' . rand() . '.png';

        file_put_contents($output_file,$image);

        return $data[1];
    }
}
