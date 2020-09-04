<?php
declare(strict_types=1);

namespace App\Application\Middleware;

use Psr\Http\Message\ResponseInterface as ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use Slim\Routing\RouteContext;


class ApiMiddleware implements Middleware
{
    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): ResponseInterface
    {

        if($request->getMethod() !== 'POST'
            || !$request->hasHeader('Content-Type')
            || !in_array('application/json', $request->getHeader('Content-Type')))
        {

            $response = new Response(400);
            return $response
                ->withHeader('Access-Control-Allow-Methods', 'POST');
        }

        return $handler->handle($request);
    }
}
