<?php
/**
 * This file is part of the Slim 3 framework skeleton.
 *
 * @link https://github.com/ansas/slim-skeleton
 */

namespace App\Controller;

use Ansas\Slim\Controller\AbstractController;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class MiscController
 *
 * @package App\Controller
 * @author  Ansas Meyer <mail@ansas-meyer.de>
 */
class MiscController extends AbstractController
{
    /**
     * Fallback for static routes.
     *
     * @param  string $name Method name (that does not exist)
     * @param  array  $args Method arguments
     *
     * @return Response
     */
    public function __call($name, $args)
    {
        /** @var Request $request */
        $request  = array_shift($args);

        /** @var Response $response */
        $response = array_shift($args);

        // Make sure no internal templates starting with an underscore (_) are called directly
        if (0 !== strpos($name, '_')) {
            // Render static template if it exists
            $file = $this->settings['view']['path'] . '/' . $name . $this->settings['view']['extension'];
            if (is_file($file)) {
                return $this->renderTemplate($request, $response, $name);
            }
        }

        // Return not found template
        return $this->notFound($request, $response);
    }

    /**
     * Index.
     *
     * @param Request  $request
     * @param Response $response
     *
     * @return Response
     */
    public function index(Request $request, Response $response)
    {
        $this->renderTemplate($request, $response, 'index');
    }
}
