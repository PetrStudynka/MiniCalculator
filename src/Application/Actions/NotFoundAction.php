<?php
declare(strict_types=1);

namespace App\Application\Actions;

use App\Application\Responder\HtmlResponder;
use Psr\Http\Message\ResponseInterface as ResponseInterface;
use Psr\Log\LoggerInterface;
use Slim\Psr7\Response;

class NotFoundAction extends Action
{
    /**
     * @var HtmlResponder
     */
    private $responder;

    private const TEMPLATE = 'notfound.html';

    public function __construct(LoggerInterface $logger, HtmlResponder $responder)
    {
        parent::__construct($logger);
        $this->responder = $responder;

    }

    public function action(): ResponseInterface
    {

        return $this->responder->respond($this->response,self::TEMPLATE);
    }
}