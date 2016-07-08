<?php

namespace App\Controller;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

abstract class AbstractController
{
    /** @var \Slim\Container Stores slim container */
    protected $container;

    protected $data = array();

    /**
     * Constructor
     *
     * @param \Slim\Container $container Slim framework container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }
    
    /**
     * Magic getter for access to Slim container.
     * <code>$this->logger->info('hello world!');</code>
     *
     * @param String $name Name of parameter to lookup
     */
    public function __get($name)
    {
        return $this->container->get($name);
    }

    /**
     * Not found
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @return Response
     */
    public function notFound(Request $request, Response $response, $args)
    {
        $handler = $this->notFoundHandler;
        return $handler($request, $response);
    }

    /**
     * Redirect to specific route
     *
     * @param ResponseInterface $response
     * @param string            $route The route to rediect to
     * @param array             $params (optional) Route params
     * @param string            $suffix (optional) URL suffix like query string
     *
     * @return ResponseInterface
     */
    public function redirectToRoute(Response $response, $route, $params = [], $suffix = '')
    {
        $url = $this->router->pathFor($route, $params) . $suffix;
        return $response->withRedirect($url, 301);
    }

    /**
     * Renders template with previous set data
     *
     * @param ResponseInterface $response
     * @param string            $template The template to render
     * @param int               $status (optional) Response status code
     *
     * @return ResponseInterface
     */
    public function renderTemplate(Response $response, $template, $status = null)
    {
        if ($status) {
            $response = $response->withStatus($status);
        }
        return $this->view->render($response, $template . $this->settings['view']['extension'], $this->getData());
    }

    public function addData($key, $value)
    {
        $this->data[$key] = $value;
        return $this;
    }
    public function clearData()
    {
        $this->data = array();
        return $this;
    }
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
    public function removeData($key)
    {
        if (isset($this->data[$key])) {
            unset($this->data[$key]);
        }
        return $this;
    }
    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
    }
}
