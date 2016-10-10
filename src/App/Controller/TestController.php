<?php
/**
 * This file is part of the Slim 3 framework skeleton.
 *
 * @link https://github.com/ansas/slim-skeleton
 */

namespace App\Controller;

use Ansas\Slim\Controller\AbstractController;
use Exception;
use Slim\Exception\MethodNotAllowedException;
use Slim\Exception\NotFoundException;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class TestController
 *
 * @package App\Controller
 * @author  Ansas Meyer <mail@ansas-meyer.de>
 */
class TestController extends AbstractController
{
    /**
     * Invoke controller.
     *
     * @param Request  $request  The most recent Request object
     * @param Response $response The most recent Response object
     * @param array    $args
     *
     * @return Response
     * @throws Exception
     */
    public function __invoke(Request $request, Response $response, array $args)
    {
        $method   = $args['method'];
        $settings = $this->settings['test'];

        if ($settings['always'] || $request->getParam($settings['key']) == $settings['value']) {
            if (method_exists($this, $method)) {
                return $this->$method($request, $response);
            }
        }

        return $this->notFound($request, $response);
    }

    /**
     * Simulate "error".
     *
     * Usage:
     * - <code>/test/error?debug=1</code> For testing develop mode (`displayErrorDetails = true`)
     * - <code>/test/error</code> For testing production mode (`displayErrorDetails = false`)
     *
     * @param Request $request The most recent Request object
     *
     * @throws Exception
     */
    public function error(Request $request)
    {
        $params = $request->getQueryParams();

        $this->settings['displayErrorDetails'] = (bool) ($params['develop'] ?? false);

        throw new Exception("Test");
    }

    /**
     * Get PHP-Info.
     */
    public function info()
    {
        phpinfo();
    }

    /**
     * Simulate "not allowed".
     *
     * @param Request  $request
     * @param Response $response
     *
     * @throws MethodNotAllowedException
     */
    public function notAllowed(Request $request, Response $response)
    {
        throw new MethodNotAllowedException($request, $response, ['POST']);
    }

    /**
     * Simulate "not found".
     *
     * @param Request  $request
     * @param Response $response
     *
     * @return void
     * @throws NotFoundException
     */
    public function notFound(Request $request, Response $response)
    {
        throw new NotFoundException($request, $response);
    }
}
