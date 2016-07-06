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
            'level' => ENVIRONMENT == ENVIRONMENT_DEVELOP ? Logger::DEBUG : Logger::ERROR,
        ],

        // Twig settings
        'view' => [
            'path' => APP_PATH . '/twig',
            'extension' => '.htm',
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