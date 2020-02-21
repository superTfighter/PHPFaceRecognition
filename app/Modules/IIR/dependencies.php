<?php


// -----------------------------------------------------------------------------
// Actions - Repositories - Factories
// -----------------------------------------------------------------------------

$container['@IIR\IIRAction'] = function($container) {
    return new \App\Modules\IIR\Actions\IIRAction($container);
};

$container['@IIR\LdapAction'] = function($container) {
    return new \App\Modules\IIR\Actions\LdapAction($container);
};


$container['@IIR\LdapRepository'] = function($container) {
    return new \App\Modules\IIR\Repositories\LdapRepository($container);
};

$container['@IIR\IIRRepository'] = function($container) {
    return new \App\Modules\IIR\Repositories\IIRRepository($container);
};



$container['@IIR\LdapFactory'] = function($container) {
    return new \App\Modules\IIR\Factories\LdapFactory($container);
};


// LDAP Domain settings
$container['ldapsettings'] = function ($container) {
    
    foreach ($container->get('settings')['settings']['System']['ldap']['domains'] as $key => $domain)
    {
        $ldapDomainObjects[$key] = (new LdapTools\DomainConfiguration($key))
                                     ->setServers($domain['servers'])
                                     ->setUsername($domain['username'])
                                     ->setPassword($domain['password'])
                                     ->setBindFormat($domain['bind_format'])
                                     ->setBaseDn($domain['base_dn'])
                                     ->setPort($domain['port'])
                                     ->setPageSize($domain['page_size'])
                                     ->setUseSsl($domain['use_ssl'])
                                     ->setUsePaging($domain['use_paging'])
                                     ->setLdapType($domain['ldap_type']);
    }

    return $ldapDomainObjects;
};

// LDAP
$container['ldap'] = function ($container) {
    $config = new LdapTools\Configuration();

    foreach (array_keys($container->get('ldapsettings')) as $domain) {
       $config->addDomain($container->get('ldapsettings')[$domain]);
    }

    $config->setSchemaFolder($container->get('settings')['settings']['System']['ldap']['schema_folder'])
           ->setDefaultDomain($container->get('settings')['settings']['System']['ldap']['default_domain']); // Defaults to the first domain added. You can change this if you want.

    return new LdapTools\LdapManager($config);
};