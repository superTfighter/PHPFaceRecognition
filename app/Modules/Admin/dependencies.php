<?php

// -----------------------------------------------------------------------------
// Actions - Repositories - Factories
// -----------------------------------------------------------------------------
$container['@Admin\AdminAction'] = function($container) {
    return new \App\Modules\Admin\Actions\AdminAction($container);
};

$container['@Admin\AdminRepository'] = function($container) {
    return new \App\Modules\Admin\Repositories\AdminRepository($container);
};

$container['@Admin\AdminFactory'] = function($container) {
    return new \App\Modules\Admin\Factories\AdminFactory($container);
};


