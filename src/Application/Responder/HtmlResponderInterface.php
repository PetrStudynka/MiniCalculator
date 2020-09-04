<?php
declare(strict_types=1);

namespace App\Application\Responder;

use Psr\Http\Message\ResponseInterface;

interface HtmlResponderInterface {

    public function respond(ResponseInterface $response, string $template);
}