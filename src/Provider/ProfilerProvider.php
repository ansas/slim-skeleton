<?php

namespace App\Provider;

use Ansas\Monolog\Profiler;
use Pimple\Container;

/**
 * Class ProfilerProvider
 * @package App\Provider
 */
class ProfilerProvider extends AbstractProvider
{
    /**
     * Register Profiler.
     * @param Container $container
     */
    public function register(Container $container)
    {
        /**
         * @param Container $c
         * @return Profiler
         */
        $container['profiler'] = function (Container $c) {

            $profiler = new Profiler($c['logger']);
            $profiler->start();

            $c['logger']->debug("Profiler loaded");

            return $profiler;
        };
    }
}
