<?php

namespace App\Provider;

use Pimple\Container;
use App\Handler\ExtendedRequestHandler;

/**
 * Class ExtendedRequestProvider
 * @package App\Provider
 */
class ExtendedRequestProvider extends AbstractProvider
{
    /**
     * Register Provider.
     * @param Container $container
     */
    public function register(Container $container)
    {
        $container['request'] = function ($container) {
            return ExtendedRequestHandler::createFromEnvironment($container->get('environment'));
        };
    }
}
