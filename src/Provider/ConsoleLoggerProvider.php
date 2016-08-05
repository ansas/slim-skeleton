<?php

namespace App\Provider;

use Ansas\Monolog\Processor\ConsoleColorProcessor;
use Ansas\Monolog\Processor\CleanupProcessor;
use DateTimeZone;
use Monolog\ErrorHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;
use Monolog\Logger;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\ProcessIdProcessor;
use Monolog\Processor\PsrLogMessageProcessor;
use Pimple\Container;

/**
 * Log service provider
 * `composer require monolog/monolog`
 */
class ConsoleLoggerProvider extends AbstractProvider
{
    public static function getDefaultSettings()
    {
        return [
            'name' => 'console',
            'level' => Logger::DEBUG,
            'trimPaths' => [],
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

            $loggerFormat     = "[%datetime%] %level_name% %message% %context% %extra%\n";
            $loggerTimeFormat = "Y-m-d H:i:s";
            $loggerTimeZone   = new DateTimeZone('Europe/Berlin');

            $logger = new Logger($config['name']);
            $logger->pushProcessor(new ConsoleColorProcessor());
            $logger->pushProcessor(new CleanupProcessor($config['trimPaths']));
            $logger->pushProcessor(new IntrospectionProcessor());
            $logger->pushProcessor(new ProcessIdProcessor());
            $logger->pushProcessor(new PsrLogMessageProcessor());

            $logger->setTimezone($loggerTimeZone);
            $logger->useMicrosecondTimestamps(false); // Using microseconds is buggy (2016-08-04)

            $formatter = new LineFormatter($loggerFormat, $loggerTimeFormat);
            $formatter->ignoreEmptyContextAndExtra(true);

            $defaultHandler = new StreamHandler('php://stdout', $config['level'], $bubble = false);
            $defaultHandler->setFormatter($formatter);
            $logger->pushHandler($defaultHandler);

            $errorHandler = new StreamHandler('php://stderr', Logger::ERROR, $bubble = false);
            $errorHandler->setFormatter($formatter);
            $logger->pushHandler($errorHandler);

            // Register logger as default PHP error, exception and shutdown handler
            // Note: Make sure only this handler handles errors (set $callPrevious to false)
            $errorHandler = ErrorHandler::register($logger, $errorLevelMap = false, $exceptionLevelMap = false);
            $errorHandler->registerErrorHandler($levelMap = [], $callPrevious = false);
            $errorHandler->registerExceptionHandler($levelMap = [], $callPrevious = false);

            $logger->debug("Logger loaded");

            return $logger;
        };
    }
}
