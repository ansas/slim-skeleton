#!/usr/bin/env php
<?php
/**
 * This file is part of the Slim 3 framework skeleton.
 *
 * @link https://github.com/ansas/slim-skeleton
 */

use Ansas\Slim\Middleware;
use Ansas\Slim\Provider;
use Ansas\Util\Text;
use Monolog\Logger;
use Slim\App;
use Slim\Container;
use Slim\Http\Environment;

$rootPath = dirname(__DIR__);
defined('ROOT_PATH') || define('ROOT_PATH', $rootPath);

// Check if system is in maintenance mode
// Note: Just place a file "maintenance.lock" into the project home path
if (file_exists($rootPath . '/maintenance.lock')) {
    echo("Wartungsarbeiten!" . "\n");
    exit(503);
}

try {
    // Parse server args and build request
    $class  = null;
    $method = null;
    $params = [];
    for ($i = 1; $i < $_SERVER['argc']; $i++) {
        $parts = preg_split("/[=:]+/", $_SERVER['argv'][$i], 2);
        if (!$class) {
            $class  = trim($parts[0]);
            $method = isset($parts[1]) ? trim($parts[1]) : null;
            continue;
        }
        $params[trim($parts[0])] = isset($parts[1]) ? trim($parts[1]) : null;
    }

    // Sanitize class
    $class = str_replace('/', '\\', $class);

    // Set fixed path and build handler
    $path    = "/console";
    $handler = "App\\Controller\\" . $class . "Controller" . ($method ? ":" . $method : "");

    /** @var App $app */
    $app = require_once $rootPath . '/app/bootstrap.php';

    // Add middleware to force our fake route with specified params
    $app->add(new Middleware\ForceRoute($path, $params));

    /** @var Container $container */
    $container = $app->getContainer();

    // Set mock environment and add needed additional providers
    $environment = [];
    if (isset($container['settings']['console']['environment'])) {
        $environment = $container['settings']['console']['environment'];
    };
    $container['environment'] = Environment::mock($environment);

    // Add needed additional providers
    $container->register(new Provider\ConsoleLoggerProvider());
    $container->register(new Provider\ProfilerProvider());

    // Disable displayErrorDetails as this would interfere with our logger (we don't want any HTML output)
    $container['settings']['displayErrorDetails'] = false;

    $color = getenv('COLOR');
    if (false !== $color) {
        $container['settings']['logger'] = array_merge($container['settings']['logger'], ['color' => Text::toBool($color)]);
    }

    $level = getenv('LEVEL');
    if (false !== $level) {
        $container['settings']['logger'] = array_merge($container['settings']['logger'], ['level' => Logger::toMonologLevel($level)]);
    }

    // Check if job is already / still running
    $parallel          = getenv('PARALLEL');
    $parallelAllowed   = false !== $parallel && Text::toBool($parallel);
    $parallelProcesses = exec("ps ax"
        . " | grep -v '^\s*" . getmypid() . "\s'"
        . " | grep -v '\s" . "grep" . "\s'"
        . " | grep '" . basename(__FILE__) . "\s'"
        . " | grep '\s" . str_replace('\\', '.', $class) . "\b'"
        . ($method ? " | grep ':" . $method . "\b'" : "")
    );
    if ($parallelProcesses) {
        if (!$parallelAllowed) {
            throw new Exception("Job is already / still running");
        }
        $app
            ->getContainer()
            ->get('logger')
            ->warning('Job is already running', ['processes' => $parallelProcesses])
        ;
    }

    // Add fake route with calculated dynamic handler and run the app
    $app->get($path, $handler);
    $app->run();
} catch (Exception $e) {
    $app
        ->getContainer()
        ->get('logger')
        ->error(get_class($e), ['exception' => $e])
    ;
}
