<?php

namespace App\Provider;

use Pimple\ServiceProviderInterface;
use Pimple\Container;

/**
 * Abstract provider
 */
abstract class AbstractProvider implements ServiceProviderInterface
{
    /**
     * Get default settings
     *
     * @return array
     */
    public static function getDefaultSettings()
    {
        return [];
    }

    /**
     * Register service
     *
     * @param Container $container
     */
    abstract public function register(Container $container);
}
