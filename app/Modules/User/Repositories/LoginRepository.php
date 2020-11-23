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

            return ['status' => 'success', 'message' => 'Sikeres bejelentkezés!'];
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            return ['status' => 'error', 'message' => 'A felhasználó nem létezik!'];
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            return ['status' => 'error', 'message' => 'Hibás jelszó!'];
        }
        catch (\Delight\Auth\EmailNotVerifiedException $e) {
            return ['status' => 'error', 'message' => 'Email nincs visszajelezve!'];
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            return ['status' => 'error', 'message' => 'Túl sok próbálkozás! Kérjük próbálja meg később!'];
        }

    }
}
