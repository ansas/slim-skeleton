<?php

namespace App\Provider;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Pimple\Container;

/**
 * Log service provider
 * `composer require monolog/monolog`
 */
class LoggerProvider extends AbstractProvider
{
    /**
     * Get default settings
     *
     * @return array
     */
    public static function getDefaultSettings()
    {
        return [
            'name' => 'app',
            'path' => './app.log',
            'level' => Logger::DEBUG,
        ];
    }

    /**
     * Register log service provider.
     *
     * @param Container $container
     */
    public function register(Container $container)
    {
        $config = array_merge([], self::getDefaultSettings(), $container['settings']['logger']);
        $container['logger'] = function (Container $c) use ($config) {
            $logger = new Logger($config['name']);
            $logger->pushProcessor(new UidProcessor());
            $logger->pushHandler(new StreamHandler($config['path'], $config['level']));

            return $logger;
        };
    }
}
