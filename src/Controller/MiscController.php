<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Example controller
 */
class MiscController extends AbstractController
{
    /**
     * Index
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @return Response
     */
    public function index(Request $request, Response $response, $args)
    {
        $this->renderTemplate($response, 'index');
    }

    /**
     * Not found handler
     *
     * @param  ServerRequestInterface $request  The most recent Request object
     * @param  ResponseInterface      $response The most recent Response object
     *
     * @return ResponseInterface
     * @throws UnexpectedValueException
     */
    public function notFound(Request $request, Response $response)
    {
        return $this->renderTemplate($response, 'misc-notfound', $status = 404);
    }

    /**
     * Error handler
     *
     * @param ServerRequestInterface $request   The most recent Request object
     * @param ResponseInterface      $response  The most recent Response object
     * @param \Throwable             $error     The caught Throwable object
     *
     * @return ResponseInterface
     * @throws UnexpectedValueException
     */
    public function error(Request $request, Response $response, \Throwable $error)
    {
        $this->logger->error($e);

        return $this->renderTemplate($response, 'misc-error', $status = 503);

        // hack: set code via http_response_code() again as
        // response code would be overwritten to 200 (bug?)
        // if this method called as set_exception_handler()
        // callback
        http_response_code($status);
    }
}
