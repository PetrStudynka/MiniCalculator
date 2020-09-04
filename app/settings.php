<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {
    // Global Settings Object
    $containerBuilder->addDefinitions([
        'settings' => [
            'displayErrorDetails' => false, // Should be set to false in production
            'logger' => [
                'name' => 'slim-app',
                'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/error.log',
                'level' => Logger::DEBUG,
            ],
            'templates' => [
                  'path' => __DIR__ . DIRECTORY_SEPARATOR .'..'. DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR,
            ],
        ],
    ]);
};
