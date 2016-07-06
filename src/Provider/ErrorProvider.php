<?php

namespace App\Provider;

use Pimple\Container;
use App\Handler\ErrorHandler;

class ErrorProvider extends AbstractProvider
{
    /**
     * Register Error Service Provider.
     *
     * @param Container $container
     */
    public function register(Container $container)
    {
        $container['errorHandler'] = function ($container) {
            return new ErrorHandler($container);
        };
        $container['phpErrorHandler'] = function ($container) {
            return new ErrorHandler($container);
        };
    }
}
