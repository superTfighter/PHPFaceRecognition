<?php

namespace App\Modules\IIR\Factories;

use App\Traits\CoreTrait;
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\ExceptionInterface;
use Respect\Validation\Exceptions\ValidationException;

use Slim\Http\Request;
use Slim\Http\Response;
use ALFI\Api\GeneralApi;
use ALFI\Config;
use Exception;

class LdapFactory
{
    use CoreTrait;


    public function createUserInLdap($data)
    {
        $password = $data['password'];
        $userName = $data['userName'];
        $userData = $this->{'@Ekreta\EkretaRepository'}->getUserData();

        $userData['uid'] = $userName;
        $userData['pws'] = $password;

        //$iirInstitute =  $this->{'@IIR\IIRRepository'}->getInstituteByOMandKir($userData['intezmenyOMKod'],$userData['kirKodok'][0]);
        //$vpid = $iirInstitute['vpid'];

        print_r('VPID BEÁLLÍTVA!');
        $vpid = '007041';
        $domain = $this->{'@IIR\LdapRepository'}->getDomain($vpid)['data'];


        $userExist = $this->{'@IIR\LdapRepository'}->getUser($vpid,$userName);

        if($userExist['code'] == 404)
            $ret = $this->createUser($domain,$userData);
        else
            throw new Exception('User already exists');

        
    }

    private function createUser($domain, $userData)
    {
        $dc = $domain['dc'];

        $ldapObject = $this->ldap->createLdapObject();

        $userData = $this->buildUser($userData);

        // Add required objectClasses
        $objectClass = [
            'top',
            'inetMailRouting',
            'inetMailUser',
            'inetOrgPerson',
            'inetSubscriber',
            'organizationalPerson',
            'person',
            'eduPerson'
        ];
        // Data transform
        $userData += [
            'mail'             => $userData['uid'] . '@' . $dc,
            //'cn'               => @$userData['sn'] . isset($userData['givenName'])?' '.$userData['givenName']:'',
            'cn'               => (isset($userData['title']) && $userData['title'] ? $userData['title'] . ' ' : '') . (isset($userData['sn']) ? $userData['sn'] : '') . (isset($userData['givenName']) ? ' ' . $userData['givenName'] : ''),
            'mailHost'         => '127.0.0.1',
        ];
        if (isset($userData['mailQuota']) && $userData['mailQuota'] != '') {
            $userData['mailQuota'] .= 'M';
        } else {
            $userData['mailQuota'] = '0M';
        }
        //Convert JSON to Array
        if (isset($userData['mailForwardingAddress']) && trim($userData['mailForwardingAddress']) != '') {
            $userData['mailForwardingAddress'] = json_decode($userData['mailForwardingAddress'], true);
        } else {
            $userData['mailForwardingAddress'] = '';
        }
        if (isset($userData['rfc822MailAlias']) && trim($userData['rfc822MailAlias']) != '') {
            $userData['rfc822MailAlias'] = json_decode($userData['rfc822MailAlias'], true);
        } else {
            $userData['rfc822MailAlias'] = '';
        }
        // Add required objectClasses
        $userData['objectClass'] = $objectClass;

        var_dump($userData);
        die();

        /*try {
            $ldapObject->createUser()
                ->in('dc='. $dc .',ou=mail,ou=nekinet,o=niifi,o=niif,c=hu')
                ->with($userData)
                ->execute();
                return [
                    'code' => 201,
                    'info' => 'Created'
                ];

            } catch (\Exception $e) {
                return [
                    'code' => 400,
                    'info' => $e->getMessage()
                ];

            }*/
    }

    private function buildUser($userData)
    {
        $name = explode(' ', $userData['nev']);

        $user = [
            'uid' => $userData['uid'],
            'sn' => $name[0],
            'givenName' => $name[1],
            'userPassword' => $userData['pws'],
            'inetSubscriberStatus' => 'active',
            'mailQuota' => ''

        ];

        return $user;
    }
}
