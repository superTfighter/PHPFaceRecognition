<?php

namespace App\Modules\User\Factories;

use App\Traits\CoreTrait;

use Slim\Http\Request;
use Slim\Http\Response;

class ApiFactory
{
    use CoreTrait;

    public function createOrUpdateUser($id, $image)
    {
        $user = $this->{'@User\LoginRepository'}->getUserById($id);

        $options =
        [
            "method" => "POST",
            "form_params" => [
                'image' => $image
            ]

        ];

        $resp = $this->api->own->call('/store/' . $user['username'],$options);

        return $resp['data'];
    }


    public function train()
    {
        $resp = $this->api->own->call('/train');

        return $resp;
    }
    
}
