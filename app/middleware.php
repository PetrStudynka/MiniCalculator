<?php
declare(strict_types=1);

use Slim\Middleware\BodyParsingMiddleware;
use App\Application\Middleware\BaseMiddleware;

use Slim\App;

return function (App $app) {
    $app->add(BodyParsingMiddleware::class);
};
