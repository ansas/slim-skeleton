<?php

namespace App\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Middleware to add script execution time (runtime)
 */
class Runtime
{
    const HEADER = 'X-Runtime';

    /**
     * Execute the middleware.
     *
     * @param Request  $request
     * @param Response $response
     * @param callable $next
     *
     * @return ResponseInterface
     */
    public function __invoke(Request $request, Response $response, callable $next)
    {
        $server = $request->getServerParams();
        $requestTime = $server['REQUEST_TIME_FLOAT'] ?? microtime(true);

        $response = $next($request, $response);

        $executionTime = microtime(true) - $requestTime;
        return $response->withHeader(self::HEADER, sprintf('%.3f', $executionTime));
    }
}
