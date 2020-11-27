<?php

namespace App\Modules\User\Repositories;

use App\Traits\CoreTrait;

use Slim\Http\Request;
use Slim\Http\Response;

class LoginRepository
{
    use CoreTrait;

    public function login($data)
    {
        try {
            $this->auth->login($data['email'], $data['password']);

            return ['status' => 'success', 'message' => 'Sikeres bejelentkezés! Az oldal átirányít!'];
        } catch (\Delight\Auth\InvalidEmailException $e) {
            return ['status' => 'error', 'message' => 'A felhasználó nem létezik!'];
        } catch (\Delight\Auth\InvalidPasswordException $e) {
            return ['status' => 'error', 'message' => 'Hibás jelszó!'];
        } catch (\Delight\Auth\EmailNotVerifiedException $e) {
            return ['status' => 'error', 'message' => 'Email nincs visszajelezve!'];
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            return ['status' => 'error', 'message' => 'Túl sok próbálkozás! Kérjük próbálja meg később!'];
        }
    }

    public function getUserById($id)
    {

        $columnsToFetch = ['id', 'email', 'password', 'verified', 'username', 'status', 'roles_mask', 'force_logout'];

        $projection = \implode(', ', $columnsToFetch);
        $userData = $this->database->selectRow(
            'SELECT ' . $projection . ' FROM users WHERE id = ?',
            [$id]
        );

        return $userData;
    }

    public function getUserByUserName($name)
    {
        $columnsToFetch = ['id', 'email', 'password', 'verified', 'username', 'status', 'roles_mask', 'force_logout'];

        $projection = \implode(', ', $columnsToFetch);
        $userData = $this->database->selectRow(
            'SELECT ' . $projection . ' FROM users WHERE username = ?',
            [ $name ]
        );

        return $userData;

    }

    public function getLuxandIdByUserId($user_id)
    {
        $row = $this->database->selectRow(
            'SELECT luxand_id FROM user_luxand WHERE user_id = ?',
            [$user_id]
        );

        if(is_null($row))
            return null;

        return $row['luxand_id'];
    }
}
