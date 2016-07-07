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
        $response = $next($request, $response);

        $server = $request->getServerParams();
        if (isset($server['REQUEST_TIME_FLOAT'])) {
            $time = microtime(true) - $server['REQUEST_TIME_FLOAT'];
            $response = $response->withHeader(self::HEADER, sprintf('%.3f', $time));
            
            if (ENVIRONMENT == ENVIRONMENT_DEVELOP) {
                $response = $response->write("<pre>EXECUTION TIME: " . number_format($time, 3) . " sec</pre>\n");
            }
        }

        return $response;
    }
}
