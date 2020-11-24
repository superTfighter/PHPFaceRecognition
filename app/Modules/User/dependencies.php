<?php

// -----------------------------------------------------------------------------
// Actions - Repositories - Factories
// -----------------------------------------------------------------------------
$container['@User\LoginAction'] = function($container) {
    return new \App\Modules\User\Actions\LoginAction($container);
};

$container['@User\LoginRepository'] = function($container) {
    return new \App\Modules\User\Repositories\LoginRepository($container);
};

$container['@User\RegisterAction'] = function($container) {
    return new \App\Modules\User\Actions\RegisterAction($container);
};

$container['@User\RegisterFactory'] = function($container) {
    return new \App\Modules\User\Factories\RegisterFactory($container);
};

$container['@User\LuxandFactory'] = function($container) {
    return new \App\Modules\User\Factories\LuxandFactory($container);
};

$container['@User\LuxandRepository'] = function($container) {
    return new \App\Modules\User\Repositories\LuxandRepository($container);
};

