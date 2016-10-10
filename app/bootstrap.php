<?php

use Slim\App;
use Slim\Container;

$rootPath = dirname(__DIR__);
defined('ROOT_PATH') || define('ROOT_PATH', $rootPath);

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
require_once $rootPath . '/app/slim/config.php';
require_once $rootPath . '/app/slim/middlewares.php';
require_once $rootPath . '/app/slim/routes.php';

return $app;
