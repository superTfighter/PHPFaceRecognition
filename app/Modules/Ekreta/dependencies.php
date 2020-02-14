<?php

// -----------------------------------------------------------------------------
// Actions - Repositories - Factories
// -----------------------------------------------------------------------------
$container['@Ekreta\EkretaAction'] = function($container) {
    return new \App\Modules\Ekreta\Actions\EkretaAction($container);
};


$container['@Ekreta\EkretaRepository'] = function($container) {
    return new \App\Modules\Ekreta\Repositories\EkretaRepository($container);
};
