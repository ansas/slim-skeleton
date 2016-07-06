<?php

namespace App\Provider;

use Pimple\Container;
use Slim\Flash\Messages;

/**
 * Flash message service provider
 * `composer require slim/flash`
 */
class FlashProvider extends AbstractProvider
{
    /**
     * Register Flash Message Service Provider.
     *
     * @param Container $container
     */
    public function register(Container $container)
    {
        $container['flash'] = function () {
            return new Messages();
        };
    }
}
