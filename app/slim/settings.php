<?php

use Monolog\Logger;

return [
    'settings' => [
        // Slim Settings
        'determineRouteBeforeAppMiddleware' => false,
        'displayErrorDetails' => ENVIRONMENT == ENVIRONMENT_DEVELOP,

        // Monolog settings
        'logger' => [
            'name' => 'app',
            'path' => LOG_PATH . '/app.log',
            'level' => DEBUG ? Logger::DEBUG : Logger::NOTICE,
            'trimPaths' => [ROOT_PATH . "/"],
        ],

        // PDO settings
        'database' => [
            'dsn' => "mysql:host=localhost;dbname=<DB>",
            "user" => "<USER>",
            "password" => "<PWD>",
        ],

        // Twig settings
        'view' => [
            'path' => APP_PATH . '/twig',
            'extension' => '.twig',
            'options' => [
                'autoescape' => true,
                'auto_reload' => true,
                'cache' => TMP_PATH . '/twig',
                'charset' => 'utf-8',
                'debug' => true,
                'strict_variables' => false,
            ],
        ],
    ],
];
