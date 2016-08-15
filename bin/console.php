#!/usr/bin/env php
<?php

use Ansas\Slim\Middleware;
use Ansas\Slim\Provider;
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
    $class = preg_replace('/Controller(\\\\)?$/ui', '', $class);
    $class = preg_replace('/^(\\\\)?(App\\\\)?Controller\\\\/ui', '', $class);

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
    $container['environment'] = Environment::mock();
    $container->register(new Provider\ConsoleLoggerProvider());
    $container->register(new Provider\PdoProvider());
    $container->register(new Provider\ProfilerProvider());

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
