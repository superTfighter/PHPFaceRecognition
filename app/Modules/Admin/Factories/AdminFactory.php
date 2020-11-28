<?php

namespace App\Modules\Admin\Factories;

use App\Traits\CoreTrait;
use Exception;
use Slim\Http\Request;
use Slim\Http\Response;

class AdminFactory
{
    use CoreTrait;


    public function deleteUser($id)
    {
        try {

            $this->database->delete(
                'users',
                [
                    // where
                    'id' => $id
                ]
            );

            return true;
        } catch (Exception $e) {

            return false;
        }
    }


    public function truncateTable($name)
    {     

        try {

            $this->database->exec('DELETE FROM ' . $name);

            return true;
        } catch (Exception $e) {

            return false;
        }
    }

    public function deleteTemp()
    {
        $options =
        [
            "method" => "DELETE"
        ];

        $resp = $this->api->own->call('/delete/temp',$options);
    }

    public function deleteAll()
    {
        $options =
        [
            "method" => "DELETE"
        ];

        $resp = $this->api->own->call('/delete/all',$options);
    }
}
