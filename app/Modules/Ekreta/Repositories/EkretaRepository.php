<?php

namespace App\Modules\Ekreta\Repositories;

use App\Traits\CoreTrait;

class EkretaRepository
{
    use CoreTrait;


    public function login($form_data)
    {
        $name = $form_data['username'];
        $pass = $form_data['password'];

        /*
        $data = [
            'username' =>   "kifu.eduroam",
            'password' =>  "kifu.eduroam",
            'institute_code' => 'demolive',
            'grant_type' => 'password',
            'client_id' => "kifu-eduroam"
        ];*/

        $data = [
            'username' =>   $name,
            'password' =>  $pass,
            'institute_code' => 'demolive', // Should be dynamic (as the pass and name)
            'grant_type' => 'password',
            'client_id' => "kifu-eduroam"   // ?
        ];

        $options = [
            'method' => 'POST',
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded'
            ],
            'data' => $data
        ];

        $resp = $this->api->kretaIdp->call('/connect/token', $options);

        // token check
        return $this->tokenCheck($resp);
    }

    public function getUserData()
    {
        $token = $this->session->token['access_token'];

        $options = [
            'method' => 'GET',
            'headers' => [
                'Authorization' => 'Bearer ' . $token
            ]
        ];

        $resp = $this->api->kreta->call('/felhasznalo', $options);

        if (!empty($resp['data']))
            return $resp['data'];
        else
            var_dump($resp);
        
    }

    public function setToken($token)
    {
        $new_token = [
            'access_token' => $token,
        ];

        $this->session->token = $new_token;
    }

    private function tokenCheck($resp) // returns true if token is valid
    {

        if ($this->session->exists('token')) {

            $token_old = $this->session->token;

            if ($token_old['created'] + $token_old['expires_in'] > time()) {

                return true;
            }
        } else {

            if ($resp['code'] == 200 && !empty($resp['data'])) {
                $token = $resp['data'];

                if (!$this->session->exists('token')) {
                    $token['created'] = time();
                    $this->session->token = $token;

                    return true;
                } else if ($this->session->exists('token')) {

                    $token_old = $this->session->token;

                    if ($token_old['created'] + $token_old['expires_in'] < time()) {

                        $token['created'] = time();
                        $this->session->token = $token;
                    }

                    return true;
                }
            } else {
                return false;
            }
        }
    }
}
