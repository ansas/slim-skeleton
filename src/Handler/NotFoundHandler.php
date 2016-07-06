<?php

namespace App\Handler;

use Slim\Http\Request;
use Slim\Http\Response;

class NotFoundHandler extends AbstractHandler
{
    /**
     * Invoke not found handler
     *
     * @param  ServerRequestInterface $request  The most recent Request object
     * @param  ResponseInterface      $response The most recent Response object
     *
     * @return ResponseInterface
     * @throws UnexpectedValueException
     */
    public function __invoke(Request $request, Response $response)
    {
        return $this->view->render(
            $response,
            '_notfound' . $this->settings['view']['extension']
        );
    }
}
