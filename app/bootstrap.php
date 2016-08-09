<?php

use Slim\App;
use Slim\Container;

$rootPath = dirname(__DIR__);
defined('ROOT_PATH') || define('ROOT_PATH', $rootPath);

// Check if system is in maintenance mode
// Note: Just place a file "maintenance.lock" into the project home path
// Note: The content of the file will be printed as maintenance massage
if (file_exists($rootPath . '/maintenance.lock')) {
    http_response_code(503);
    header('Content-Type: text/html; charset=UTF-8');
    header('Retry-After: 7200'); // in seconds
    echo("<h3>Wartungsarbeiten</h3>");
    echo(nl2br(file_get_contents($rootPath . '/maintenance.lock')));
    exit(503);
}

// Load defines and ini settings
require_once $rootPath . '/app/slim/defines.php';

// Set up autoload
require_once $rootPath . '/lib/autoload.php';

// Load settings
$settings = require_once $rootPath . '/app/slim/settings.php';

// Create container for application
$container = new Container($settings);

// Create new application
$app = new App($container);

// Set up dependencies, middlewares and routes
require_once $rootPath . '/app/slim/dependencies.php';
require_once $rootPath . '/app/slim/middlewares.php';
require_once $rootPath . '/app/slim/routes.php';

return $app;
