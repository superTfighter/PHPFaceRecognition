<?php

namespace App\Modules\User\Repositories;

use App\Traits\CoreTrait;
use Delight\Cookie\Session;

use Slim\Http\Request;
use Slim\Http\Response;

class ApiRepository
{
    use CoreTrait;

    const SESSION_FIELD_LOGGED_IN = 'auth_logged_in';
    /** @var string session field for the ID of the user who is currently signed in (if any) */
    const SESSION_FIELD_USER_ID = 'auth_user_id';
    /** @var string session field for the email address of the user who is currently signed in (if any) */
    const SESSION_FIELD_EMAIL = 'auth_email';
    /** @var string session field for the display name (if any) of the user who is currently signed in (if any) */
    const SESSION_FIELD_USERNAME = 'auth_username';
    /** @var string session field for the status of the user who is currently signed in (if any) as one of the constants from the {@see Status} class */
    const SESSION_FIELD_STATUS = 'auth_status';
    /** @var string session field for the roles of the user who is currently signed in (if any) as a bitmask using constants from the {@see Role} class */
    const SESSION_FIELD_ROLES = 'auth_roles';
    /** @var string session field for whether the user who is currently signed in (if any) has been remembered (instead of them having authenticated actively) */
    const SESSION_FIELD_REMEMBERED = 'auth_remembered';
    /** @var string session field for the UNIX timestamp in seconds of the session data's last resynchronization with its authoritative source in the database */
    const SESSION_FIELD_LAST_RESYNC = 'auth_last_resync';
    /** @var string session field for the counter that keeps track of forced logouts that need to be performed in the current session */
    const SESSION_FIELD_FORCE_LOGOUT = 'auth_force_logout';

    public function recognize($base64Image)
    {
        $options =
            [
                "method" => "POST",
                "form_params" => [
                    'image' => $base64Image
                ]

            ];

        $resp = $this->api->own->call('/recognize', $options);

        $message = $resp['data']['message'];

        if (!is_null($message)) {

            $message = trim($message);

            //return ['status' => 'error', 'message' => 'Sikeres bejelentkezés! Üdvözöllek ' . $message . ' !'];
            
            $userData = $this->{'@User\LoginRepository'}->getUserByUserName($message);

            if(is_null($userData))
            {
                return ['status' => 'error', 'message' => 'Arc nem lett felismerve!'];
            }

            $this->updateFaceLoginTime($userData['id']);
            $this->updateSession($userData);

            return ['status' => 'success', 'message' => 'Sikeres bejelentkezés! Üdvözöllek ' . $userData['username'] . ' !'];
        } else {
            return ['status' => 'error', 'message' => 'Arc nem lett felismerve!'];
        }
    }

    private function updateFaceLoginTime($id)
    {
        $this->database->update(
            'users',
            ['last_login' => \time()],
            ['id' => $id]
        );
    }

    private function updateSession($userData)
    {

        Session::regenerate(true);

        // save the user data in the session variables maintained by this library
        $_SESSION[self::SESSION_FIELD_LOGGED_IN] = true;
        $_SESSION[self::SESSION_FIELD_USER_ID] = (int) $userData['id'];
        $_SESSION[self::SESSION_FIELD_EMAIL] = $userData['email'];
        $_SESSION[self::SESSION_FIELD_USERNAME] = $userData['username'];
        $_SESSION[self::SESSION_FIELD_STATUS] = (int) $userData['status'];
        $_SESSION[self::SESSION_FIELD_ROLES] = (int) $userData['roles_mask'];
        $_SESSION[self::SESSION_FIELD_FORCE_LOGOUT] = (int) $userData['force_logout'];
        $_SESSION[self::SESSION_FIELD_REMEMBERED] = null;
        $_SESSION[self::SESSION_FIELD_LAST_RESYNC] = \time();
    }
}
