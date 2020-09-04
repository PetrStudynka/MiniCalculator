<?php
declare(strict_types=1);

namespace App\Application\Responder;

use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Slim\Views\PhpRenderer;

use Throwable;

class HtmlResponder implements HtmlResponderInterface
{

    /**
     * @var PhpRenderer
     */
    private $renderer;

    /**
     * @var LoggerInterface;
     */
    private $logger;

    public function __construct(LoggerInterface $logger, PhpRenderer $phpRenderer)
    {
        $this->renderer = $phpRenderer;
        $this->logger = $logger;
    }

    public function respond(ResponseInterface $response, string $template)
    {
        try {
            $response = $this->renderer->render($response, $template);
        } catch (Throwable $e) {

            $this->logger->error($e->getMessage());
            $response->withStatus(500);
        }

        return $response;
    }

}