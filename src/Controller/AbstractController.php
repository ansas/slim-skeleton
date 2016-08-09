<?php

namespace App\Controller;

use Ansas\Monolog\Profiler;
use Monolog\Logger;
use PDO;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * @property-read Logger $logger
 * @property-read Profiler $profiler
 * @property-read PDO $pdo
 */
abstract class AbstractController
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * AbstractController constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Magic getter for easier access to container.
     * <code>$this->logger->info('hello world!');</code>
     * @param  string $name
     * @return mixed
     */
    public function __get(string $name)
    {
        return $this->container->get($name);
    }

    /**
     * Not found.
     * @param  Request $request
     * @param  Response $response
     * @param  array $args
     * @return Response
     */
    public function notFound(Request $request, Response $response, $args)
    {
        $handler = $this->notFoundHandler;
        return $handler($request, $response);
    }

    /**
     * Redirect to specific route.
     * @param  Response $response
     * @param  string $route The route to rediect to
     * @param  array $params (optional) Route params
     * @param  string $suffix (optional) URL suffix like query string
     * @return Response
     */
    public function redirectToRoute(Response $response, $route, $params = [], $suffix = '')
    {
        $url = $this->router->pathFor($route, $params) . $suffix;
        return $response->withRedirect($url, 301);
    }

    /**
     * Renders template with previous set data.
     * @param  Response $response
     * @param  string $template The template to render
     * @param  int $status (optional) Response status code
     * @return Response
     */
    public function renderTemplate(Response $response, $template, $status = null)
    {
        if ($status) {
            $response = $response->withStatus($status);
        }

        return $this->view->render($response, $template . $this->settings['view']['extension'], $this->getData());
    }

    /**
     * @param  null $key
     * @return array|mixed|null
     */
    public function getData($key = null)
    {
        if ($key) {
            if (isset($this->data[$key])) {
                return $this->data[$key];
            }
            return null;
        }

        return $this->data;
    }

    /**
     * @param  array $data
     * @return $this
     */
    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param  $key
     * @param  $value
     * @return $this
     */
    public function addData($key, $value)
    {
        $this->data[$key] = $value;

        return $this;
    }

    /**
     * @return $this
     */
    public function clearData()
    {
        $this->data = [];

        return $this;
    }

    /**
     * @param  $key
     * @return $this
     */
    public function removeData($key)
    {
        if (isset($this->data[$key])) {
            unset($this->data[$key]);
        }

        return $this;
    }
}
