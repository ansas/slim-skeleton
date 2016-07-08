<?php

namespace App\Provider;

use Pimple\Container;
use App\Handler\ExtendedRequestHandler;

class ExtendedRequestProvider extends AbstractProvider
{
    /**
     * Register NotFound Service Provider.
     *
     * @param Container $container
     */
    public function register(Container $container)
    {
        $container['request'] = function ($container) {
            return ExtendedRequestHandler::createFromEnvironment($container->get('environment'));
        };
    }
}
