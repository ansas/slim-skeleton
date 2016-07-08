<?php

namespace App\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Middleware to make sure JSON is returned
 */
class ApiJson
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
        $request  = $request->withHeader('Accept', 'application/json');
        $response = $response->withHeader('Content-Type', 'application/json;charset=utf-8');

        return $next($request, $response);
    }
}
