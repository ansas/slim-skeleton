<?php
/**
 * This file is part of the Slim 3 framework skeleton.
 */

namespace App\Controller;

use Ansas\Slim\Controller\AbstractController;
use Slim\Http\Request;
use Slim\Http\Response;
use Throwable;

/**
 * Class MiscController
 *
 * @package App\Controller
 * @author  Ansas Meyer <mail@ansas-meyer.de>
 */
class MiscController extends AbstractController
{
    /**
     * Index.
     *
     * @param  Request  $request  The most recent Request object
     * @param  Response $response The most recent Response object
     *
     * @return Response
     */
    public function index(Request $request, Response $response)
    {
        $this->renderTemplate($response, 'index');
    }

    /**
     * Not found handler.
     *
     * @param  Request  $request  The most recent Request object
     * @param  Response $response The most recent Response object
     *
     * @return Response
     */
    public function notFound(Request $request, Response $response)
    {
        return $this->renderTemplate($response, 'misc-notfound', $status = 404);
    }

    /**
     * Error handler.
     *
     * @param  Request   $request  The most recent Request object
     * @param  Response  $response The most recent Response object
     * @param  Throwable $e
     *
     * @return Response
     */
    public function error(Request $request, Response $response, Throwable $e)
    {
        $this->logger->error($e);

        return $this->renderTemplate($response, 'misc-error', $status = 503);
    }
}
