<?php

return [
    'settings' => [
        // Slim Settings
        'determineRouteBeforeAppMiddleware' => false,
        'displayErrorDetails'               => ENVIRONMENT == ENVIRONMENT_DEVELOP,

        // Monolog settings
        'logger'                            => [
            'name'      => 'app',
            'path'      => LOG_PATH . '/app.log',
            'level'     => DEBUG ? Monolog\Logger::DEBUG : Monolog\Logger::NOTICE,
            'trimPaths' => [ROOT_PATH . '/'],
        ],

        // Console
        'console'                           => [
            'environment' => [
                'HTTP_ACCEPT' => 'text/plain',
                'HTTPS'       => 'on', // on|off
                'SERVER_PORT' => 443,
            ],
        ],

        // PDO settings
        'database'                          => [
            'dsn'      => 'mysql:host=localhost;dbname=<DB>',
            'user'     => '<USER>',
            'password' => '<PWD>',
        ],

        // Twig settings
        'view'                              => [
            'path'      => APP_PATH . '/twig',
            'extension' => '.twig',
            'options'   => [
                'autoescape'       => true,
                'auto_reload'      => ENVIRONMENT == ENVIRONMENT_DEVELOP,
                'cache'            => TMP_PATH . '/twig',
                'charset'          => 'utf-8',
                'debug'            => ENVIRONMENT == ENVIRONMENT_DEVELOP,
                'strict_variables' => false,
            ],
        ],

        // Test controller secret
        'test'                              => [
            'always' => ENVIRONMENT == ENVIRONMENT_DEVELOP,
            'key'    => 'force',
            'value'  => 'it',
        ],
    ],
];
