<?php

$app->get('/', 'App\Controller\MiscController:index')->setName('index');

// TEST Router for testing purposes
$app->get('/test[/{method:.*}]', 'App\Controller\TestController');
