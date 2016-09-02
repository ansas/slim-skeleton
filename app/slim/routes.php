<?php

// PAGES
$pages = [
    'index'   => '',
    'privacy',
    'imprint' => 'impressum',
];
foreach ($pages as $name => $route) {
    $name = is_numeric($name) ? $route : $name;
    $app->get('/' . $route, 'App\Controller\MiscController:' . $name)
        ->setName($name)
    ;
}

// TEST Router for testing purposes
$app->get('/test[/{method:.*}]', App\Controller\TestController::class);
