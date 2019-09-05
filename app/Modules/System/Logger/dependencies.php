<?php

// Monolog
$container['logger'] = function ($container) {
    $settings = $container->get('settings')['settings']['System']['Logger'];

    $logger = new \Monolog\Logger($settings['name']);
    $logger->pushProcessor(new \Monolog\Processor\UidProcessor());

    $lineFormatter = new \Monolog\Formatter\LineFormatter();
    $lineFormatter->allowInlineLineBreaks(true);
    $lineFormatter->ignoreEmptyContextAndExtra(true);

    $handler = new Monolog\Handler\StreamHandler($settings['path'], Monolog\Logger::DEBUG);
    $handler->setFormatter($lineFormatter);

    $logger->pushHandler($handler);

    return $logger;
};
