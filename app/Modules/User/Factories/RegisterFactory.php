<?php

namespace App\Modules\User\Factories;

use App\Traits\CoreTrait;

use Slim\Http\Request;
use Slim\Http\Response;

class RegisterFactory
{
    use CoreTrait;

    public function register($postData)
    {

        try {
            $userId = $this->auth->register($postData['email'], $postData['pws1'], $postData['username'], function ($selector, $token) {
                $this->auth->confirmEmail($selector, $token);
            });

            return ['status' => 'success', 'message' => 'Sikeres regisztráció!', 'userId' => $userId];
        } catch (\Delight\Auth\InvalidEmailException $e) {
            return ['status' => 'error', 'message' => 'Hibás email cím!'];
        } catch (\Delight\Auth\InvalidPasswordException $e) {
            return ['status' => 'error', 'message' => 'Hibás jelszó!'];
        } catch (\Delight\Auth\UserAlreadyExistsException $e) {
            return ['status' => 'error', 'message' => 'Felhasználó már létezik!'];
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            return ['status' => 'error', 'message' => 'Túl sok próbálkozás! Kérjük próbáld újra később!'];
        }
    }

    public function addLuxandIdToUser($user_id,$luxand_id)
    {
        $db = $this->database;

        $db->insert(
            'user_luxand',
            [
                'user_id' => $user_id,
                'luxand_id' => $luxand_id
            ]
        );

    }
}
