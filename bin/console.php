<?php

defined('ROOT_PATH') || define('ROOT_PATH', dirname(__DIR__));

/** @var \Slim\App $app */
$app = require_once ROOT_PATH . '/app/bootstrap.php';

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

    // Set fixed path and build handler
    $path    = "/console";
    $handler = "App\\Controller\\" . str_replace('/', '\\', trim($class, DIRECTORY_SEPARATOR)) . "Controller" . ($method ? ":" . $method : "");

    // Set mock environment and add needed additional providers
    $container = $app->getContainer();
    $container['environment'] = \Slim\Http\Environment::mock();
    $container->register(new \App\Provider\ConsoleLoggerProvider());
    $container->register(new \App\Provider\PdoProvider());
    $container->register(new \App\Provider\ProfilerProvider());

    // Add middleware to force our fake route with specified params
    $app->add(new App\Middleware\ForceRoute($path, $params));

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
