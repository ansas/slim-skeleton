<?php
/**
 * This file is part of the Slim 3 framework skeleton.
 *
 * @link https://github.com/ansas/slim-skeleton
 */

namespace App\Tests;

use Ansas\Slim\Http\ExtendedRequest;
use Ansas\Slim\Http\ExtendedResponse;
use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Container;
use Slim\Http\Body;
use Slim\Http\Environment;

/**
 * Class AppTestCase
 *
 * @package App\Tests
 * @author  Ansas Meyer <mail@ansas-meyer.de>
 */
abstract class AppTestCase extends MinimalTestCase
{
    /**
     * @var App
     */
    protected static $app;

    /**
     * @inheritdoc
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->initApp();
    }

    /**
     * @return App
     */
    protected function getApp()
    {
        $this->initApp();

        return self::$app;
    }

    /**
     * @return Container|ContainerInterface
     */
    protected function getContainer()
    {
        return $this->getApp()->getContainer();
    }

    /**
     *
     */
    protected function initApp()
    {
        if (null === static::$app) {
            static::$app = require ROOT_PATH . '/app/bootstrap.php';
        }
    }

    /**
     * @param string                   $method
     * @param string                   $path
     * @param array                    $queries [optional]
     * @param array                    $cookies [optional]
     * @param null|string|array|object $content [optional]
     *
     * @return ExtendedResponse
     */
    protected function runApp($method, $path, $queries = [], $cookies = [], $content = null)
    {
        $env = Environment::mock([
            'REQUEST_METHOD' => strtoupper($method),
            'REQUEST_URI'    => $path,
            'QUERY_STRING'   => http_build_query($queries),
        ]);

        $request  = ExtendedRequest::createFromEnvironment($env);
        $response = new ExtendedResponse();

        if ($cookies) {
            $request = $request->withCookieParams($cookies);
        }

        if (isset($content)) {
            if (is_string($content)) {
                $body = new Body(fopen('php://temp', 'r+'));
                $body->write($content);
                $request = $request->withBody($body);
            } else {
                $request = $request->withParsedBody($content);
            }
        }

        /** @var ExtendedResponse $response */
        $response = $this->getApp()->process($request, $response);

        return $response;
    }
}
