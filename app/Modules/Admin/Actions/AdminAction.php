<?php

namespace App\Modules\Admin\Actions;

use App\Traits\CoreTrait;

use Slim\Http\Request;
use Slim\Http\Response;

class AdminAction
{
    use CoreTrait;


    public function index($request,$response,$args)
    {
        
        return $response;
    }

    // User functions
    public function usersPage($request,$response,$args)
    {
        return $this->view->render($response, '@Admin\users.twig');
    }

    public function usersJson($request,$response,$args)
    {
        $users = $this->{'@Admin\AdminRepository'}->getUsers();

        if(is_null($users))
            $users = [];

        return $response->withJson(['data'=> $users]);
    }

    public function deleteUser($request,$response,$args)
    {
        $id = $args['id'];

        if($this->{'@Admin\AdminFactory'}->deleteUser($id))
        {
            return $response->withJson(['status' => 'success', 'message' => 'Sikeres törlés!']);
        }

        return $response->withJson(['status' => 'error' , 'message' => 'Sikertelen törlés!']);
    }

    // Database functions
    public function databasePage($request,$response,$args)
    {
        return $this->view->render($response, '@Admin\database.twig');
    }

    public function allTablesJson($request,$response,$args)
    {
        $tables = $this->{'@Admin\AdminRepository'}->listAllTables();

        if(is_null($tables))
            $tables = [];

        return $response->withJson(['data'=> $tables]);
    }

    public function truncateTable($request,$response,$args)
    {
        $name = $args['name'];

        if($this->{'@Admin\AdminFactory'}->truncateTable($name))
        {
            return $response->withJson(['status' => 'success', 'message' => 'Sikeres törlés!']);
        }

        return $response->withJson(['status' => 'error' , 'message' => 'Sikertelen törlés!']);
    }

    // Api functions
    public function apiPage($request,$response,$args)
    {
        return $this->view->render($response, '@Admin\api.twig');
    }

    public function deleteTempFromApi($request,$response,$args)
    {
        $this->{'@Admin\AdminFactory'}->deleteTemp();

        return $response->withJson(['status' => 'success', 'message' => 'Sikeres törlés!']);
    }

    public function deleteAllFromApi($request,$response,$args)
    {
        $this->{'@Admin\AdminFactory'}->deleteAll();

        return $response->withJson(['status' => 'success', 'message' => 'Sikeres törlés!']);
    }

}
