<?php

defined('ROOT_PATH') || define('ROOT_PATH', dirname(__DIR__));

// Check for built-in PHP server
if (PHP_SAPI === 'cli-server' && $_SERVER['SCRIPT_FILENAME'] !== __FILE__) {
    return false;
}

// Run application
$app = require_once ROOT_PATH . '/app/bootstrap.php';
$app->run();
