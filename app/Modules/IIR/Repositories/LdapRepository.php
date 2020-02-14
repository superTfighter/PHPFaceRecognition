<?php

namespace App\Modules\IIR\Repositories;

use App\Traits\CoreTrait;
use Exception as GlobalException;


class LdapRepository
{
    use CoreTrait;


    public function getDomain($vpid)
    {
        $this->ldapsettings['sulinet.hu']->setBaseDn('');
        $query = $this->ldap->buildLdapQuery();

        try {

            $results = $query->fromDomain()
                            ->where(['uid' => $vpid])
                            ->getLdapQuery()
                            ->getSingleResult();

            $results = $results->toArray($results);

            // inetAuthorizedServices pretty
            if (isset($results['inetAuthorizedServices']) && $results['inetAuthorizedServices'])
            {
                if (is_array($results['inetAuthorizedServices'])) {

                    foreach ($results['inetAuthorizedServices'] as &$dn) {
                        $dn = $this->parseDn($dn)['cn'];
                    }

                } else {
                    $results['inetAuthorizedServices'] = [$this->parseDn($results['inetAuthorizedServices'])['cn']];
                }
            }

            return ['code' => 200,
                    'data' => $results];

        } catch (\Exception $e) {
            return ['code' => 404];

        }
    }

    public function getUsers($vpid)
    {
        $domain = $this->getDomain($vpid);
        if ($domain['code'] == 200)
        {
            // Domain Component
            $dc = $domain['data']['dc'];

            // Base DN performance HACK
            $this->ldapsettings['sulinet.hu']->setBaseDn('dc='. $dc .',ou=mail,ou=nekinet,o=niifi,o=niif,c=hu');

            $query = $this->ldap->buildLdapQuery();

            try {
                $ret = array();

                $users = $query->fromUsers()
                               ->getLdapQuery()
                               ->getResult();

                foreach ($users as $obj) {
                    $ret[] = $obj->toArray($obj);
                }

                return $ret;

            } catch (GlobalException $e) {
                return;

            }
        }

        return;

    }

    public function getUser($vpid,$uid)
    {

    }

    public function getAllDomains()
    {
        $institutes = $this->{'@IIR\IIRRepository'}->getTypeOfInstitute('iskola');
        $dcs = array();

        $i = 0;

        foreach($institutes as $institute)
        {
            $dc = $this->getDomain($institute['vpid']);
            array_push($dcs,$dc);
            $i++;
        }


        return $dcs;

    }

    private function parseDn($string)
    {
        $string = str_replace(",","&",$string);
        parse_str($string, $out);

        return $out;
    }
}   