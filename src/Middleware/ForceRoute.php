<?php

namespace App\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;

class ForceRoute
{
    protected $path;
    protected $params;

    /**
     * ForceRoute constructor.
     * @param $path
     * @param null $params
     */
    public function __construct($path, $params = null)
    {
        $this->path   = DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR);
        $this->params = $params;
    }

    /**
     * Execute the middleware
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return static
     */
    public function __invoke(Request $request, Response $response, callable $next)
    {
        // Overwrite request with new uri path
        $uri = $request->getUri();
        $request = $request->withUri($uri->withPath($this->path));

        // Overwrite params (if provided)
        if (!empty($this->params)) {
            $request = $request->withQueryParams($this->params);
        }

        // Call next middleware
        return $next($request, $response);
    }
}
