<?php

// -----------------------------------------------------------------------------
// Actions - Repositories - Factories
// -----------------------------------------------------------------------------
$container['@Documentation\MainAction'] = function($container) {
    return new \App\Modules\Documentation\Actions\MainAction($container);
};

$container['@Documentation\MainRepository'] = function($container) {
    return new \App\Modules\Documentation\Repositories\MainRepository($container);
};

$container['@Documentation\MainFactory'] = function($container) {
    return new \App\Modules\Documentation\Factories\MainRepository($container);
};

$container['@Documentation\Validation'] = function($container) {
   return new \App\Modules\Documentation\validation($container);
};
