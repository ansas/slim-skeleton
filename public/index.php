<?php

// Check for built-in PHP server
if (PHP_SAPI === 'cli-server' && $_SERVER['SCRIPT_FILENAME'] !== __FILE__) {
    return false;
}

// Run application
$app = require_once __DIR__ . '/../app/slim/bootstrap.php';
$app->run();
