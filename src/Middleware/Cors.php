<?php

namespace App\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Middleware to add CORS support (Cross-Origin Resource Sharing)
 * @see: http://www.html5rocks.com/static/images/cors_server_flowchart.png
 * @see: https://github.com/palanik/CorsSlim/blob/master/CorsSlim.php
 */
class Cors
{
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
        $response = $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', ['Content-Type'])
            ->withHeader('Access-Control-Allow-Methods', ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'])
        ;

        if($request->isOptions()) {
            return $response;
        }

        return $next($request, $response);
    }
}
