<?php

// PREDIS
$container['predis'] = function ($container) {
    $settings = $container->get('settings')['settings']['System']['Predis'];

    return new Predis\Client(['host'   => $settings['host'],
                              'port'   => $settings['port']],
                             ['prefix' => $settings['prefix']]);
};
