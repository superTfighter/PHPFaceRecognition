<?php

namespace App\Modules\User\Factories;

use App\Traits\CoreTrait;

use Slim\Http\Request;
use Slim\Http\Response;

class LuxandFactory
{
    use CoreTrait;



    public function createOrUpdateUser($id, $image)
    {

        $luxand_id = $this->{'@User\LoginRepository'}->getLuxandIdByUserId($id);

        $resp = null;

        if (is_null($luxand_id)) {

            $resp = $this->createLuxandPerson($id, $image);
        } else {

            $resp = $this->addFaceToLuxandPerson($luxand_id, $image);
        }

        return $resp;
    }

    public function deleteAllLuxandPerson()
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.luxand.cloud/subject",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "DELETE",
            CURLOPT_POSTFIELDS => [],
            CURLOPT_HTTPHEADER => array(
                "token: fdb55367e5e0413a8c7f5505a76d6dfb"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo $err;
        } else {
            echo $response;
        }
    }

    private function createLuxandPerson($id, $image)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.luxand.cloud/subject/v2",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => ["name" => $id, "photo" => $image],
            CURLOPT_HTTPHEADER => array(
                "token: fdb55367e5e0413a8c7f5505a76d6dfb"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return $err;
        }

        $response = json_decode($response,true);

        if ($response['status'] == "success") {
            $this->{'@User\RegisterFactory'}->addLuxandIdToUser($id, $response['id']);
        }

        return $response;
    }

    private function addFaceToLuxandPerson($luxand_id, $image)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.luxand.cloud/subject/" . $luxand_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => ["photo" => $image],
            CURLOPT_HTTPHEADER => array(
                "token: fdb55367e5e0413a8c7f5505a76d6dfb"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return $err;
        }

        $response = json_decode($response,true);

        return $response;
    }
}
