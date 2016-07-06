<?php

namespace App\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Middleware to add or remove the trailing slash of an URL
 */
class TrailingSlash
{
    const SLASH_ADD    = true;
    const SLASH_REMOVE = false;

    /**
     * @var boolean Add or remove the slash
     */
    private $addSlash;

    /**
     * Constructor
     *
     * Configure whether add or remove the slash (optional)
     *
     * @param boolean $addSlash
     */
    public function __construct($addSlash = self::SLASH_REMOVE)
    {
        $this->addSlash = (boolean) $addSlash;
    }

    /**
     * Execute the middleware.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param callable               $next
     *
     * @return ResponseInterface
     */
    public function __invoke(Request $request, Response $response, callable $next)
    {
        $uri = $request->getUri();
        $path = $uri->getPath();

        //Add/remove slash
        if ($path != '/') {
            $path = rtrim($path, '/');
            if ($this->addSlash && !pathinfo($path, PATHINFO_EXTENSION)) {
                $path .= '/';
            }
        }

        //redirect
        if ($uri->getPath() !== $path) {
            return $response->withRedirect($uri->withPath($path), 301);
        }

        return $next($request, $response);
    }
}
