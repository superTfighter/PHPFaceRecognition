<?php

// logolni minden exceptiont amit amugy csak a slim kezelne le logolas nelkul
$container['errorHandler'] = function ($container) {
    return new App\Modules\System\Handler\Error($container);
};

// notice, warning, mindent(!) exceptionne
set_error_handler(function ($severity, $message, $file, $line) {
    // error squelch operator support, ha ott a @ akkor ignore
    if ( error_reporting() == 0 )
      return true;

    throw new \ErrorException($message, 0, $severity, $file, $line);
});
