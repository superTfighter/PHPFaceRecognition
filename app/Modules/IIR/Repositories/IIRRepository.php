<?php

namespace App\Modules\IIR\Repositories;

use App\Traits\CoreTrait;
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\ExceptionInterface;
use Respect\Validation\Exceptions\ValidationException;

use Slim\Http\Request;
use Slim\Http\Response;
use ALFI\Api\GeneralApi;
use ALFI\Config;
use Exception;

class IIRRepository
{
    use CoreTrait;
    

    public function getTypeOfInstitute($type)
    {
        $array = [];

        $index = 0;
        $limit = 1000;
        
        $options = [
            "query" =>[

                "start" => $index,
                "limit" => 1
            ]
    
        ];

        $maxCount = $this->api->iir->call('/intezmeny', $options)['data']['total'];
        
        while($index < $maxCount)
        {
            $options = [
                "query" =>[
    
                    "start" => $index,
                    "limit" => $limit,
                ]
        
            ];

            $items = $this->api->iir->call('/intezmeny', $options)['data']['items'];

            $index = $index + $limit;

            foreach($items as $item)
            {
                if($item['tipus_fajta'] == $type)
                    array_push($array,$item);
            }

        }

        return $array;

    }

    public function getInstituteByOMandKir($om,$kir)
    {
        $omCode = $om . '/' . $kir;
        
        $index = 0;
        $limit = 1000;
        
        $options = [
            "query" =>[

                "start" => $index,
                "limit" => 1
            ]
    
        ];

        $maxCount = $this->api->iir->call('/intezmeny', $options)['data']['total'];
        
        while($index < $maxCount)
        {
            $options = [
                "query" =>[
    
                    "start" => $index,
                    "limit" => $limit,
                ]
        
            ];

            $items = $this->api->iir->call('/intezmeny', $options)['data']['items'];

            $index = $index + $limit;

            foreach($items as $item)
            {
                if(array_key_exists('om',$item) && $item['om'] == $omCode)
                    return $item;
            }

        }

        throw new Exception('Intézmény '. $omCode . ' kóddal nem található!',404);
        
    }

}