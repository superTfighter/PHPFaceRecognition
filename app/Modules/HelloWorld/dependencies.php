<?php

// -----------------------------------------------------------------------------
// Actions - Repositories - Factories
// -----------------------------------------------------------------------------
$container['@HelloWorld\MainAction'] = function($container) {
    return new \App\Modules\HelloWorld\Actions\MainAction($container);
};

$container['@HelloWorld\MainRepository'] = function($container) {
    return new \App\Modules\HelloWorld\Repositories\MainRepository($container);
};

// Validator
$container['@HelloWorld\Validation'] = function($container) {
    return new \App\Modules\HelloWorld\validation($container);
};
