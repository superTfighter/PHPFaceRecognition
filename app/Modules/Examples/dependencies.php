<?php

// -----------------------------------------------------------------------------
// Actions - Repositories - Factories
// -----------------------------------------------------------------------------
$container['@Examples\MainAction'] = function($container) {
    return new \App\Modules\Examples\Actions\MainAction($container);
};

$container['@Examples\MainRepository'] = function($container) {
    return new \App\Modules\Examples\Repositories\MainRepository($container);
};

$container['@Examples\MainFactory'] = function($container) {
    return new \App\Modules\Examples\Factories\MainRepository($container);
};

// Validator
// $container['@Examples\Validation'] = function($container) {
//    return new \App\Modules\HelloWorld\validation($container);
// };
