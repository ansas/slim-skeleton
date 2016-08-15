<?php

use Slim\App;

// Check for built-in PHP server
if (PHP_SAPI === 'cli-server' && $_SERVER['SCRIPT_FILENAME'] !== __FILE__) {
    return false;
}

$rootPath = dirname(__DIR__);

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

/** @var App $app */
$app = require_once $rootPath . '/app/bootstrap.php';

// Run application
$app->run();
