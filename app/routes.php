<?php
declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

use App\Application\Actions\EnergyCalculator\CompareSupplierAction;
use App\Application\Actions\EnergyCalculator\CalculatorViewAction;
use App\Application\Actions\NotFoundAction;
use App\Application\Middleware\ApiMiddleware;

return function (App $app) {

    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/',CalculatorViewAction::class)->setName('home');
    $app->get('/notfound',NotFoundAction::class)->setName('notfound');
    $app->get('/calculator',CalculatorViewAction::class);

    $app->group('/api', function (Group $group){
            $group->post('/calculator/compare',  CompareSupplierAction::class);

    })->add(new ApiMiddleware());



};
