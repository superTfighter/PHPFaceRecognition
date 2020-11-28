<?php

namespace App\Modules\Admin\Repositories;

use App\Traits\CoreTrait;
use Exception;
use Slim\Http\Request;
use Slim\Http\Response;

class AdminRepository
{
    use CoreTrait;


    public function getUsers()
    {
        $rows = $this->database->select('SELECT * FROM users');

        return $rows;
    }

    public function listAllTables()
    {

        try {

            $tables = $this->database->select(
                'SELECT * FROM sqlite_master WHERE type="table"'
            );

            return $tables;

        } catch (Exception $e) {

            return false;
        }
    }
}
