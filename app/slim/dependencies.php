<?php

use Ansas\Slim\Provider;

// Register service providers & factories
$container->register(new Provider\DataProvider());
$container->register(new Provider\ExtendedRequestProvider());
$container->register(new Provider\ErrorProvider());
$container->register(new Provider\FlashProvider());
$container->register(new Provider\LoggerProvider());
$container->register(new Provider\NotFoundProvider());
$container->register(new Provider\TwigProvider());
