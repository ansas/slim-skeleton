<?php

namespace App\Provider;

use Pimple\Container;
use App\Handler\NotFoundHandler;

class NotFoundProvider extends AbstractProvider
{
    /**
     * Register NotFound Service Provider.
     *
     * @param Container $container
     */
    public function register(Container $container)
    {
        $container['defaultNotFoundHandler'] = $container->raw('notFoundHandler');

        $container['notFoundHandler'] = function ($container) {
            return new NotFoundHandler($container);
        };
    }
}
