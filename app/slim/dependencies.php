<?php

// Register service providers & factories
$container->register(new Ansas\Slim\Provider\DataProvider());
$container->register(new Ansas\Slim\Provider\ExtendedRequestProvider());
$container->register(new Ansas\Slim\Provider\ExtendedRouterProvider());
$container->register(new Ansas\Slim\Provider\ErrorProvider());
$container->register(new Ansas\Slim\Provider\FlashProvider());
$container->register(new Ansas\Slim\Provider\LoggerProvider());
$container->register(new Ansas\Slim\Provider\NotAllowedProvider());
$container->register(new Ansas\Slim\Provider\NotFoundProvider());
$container->register(new Ansas\Slim\Provider\TwigProvider());
$container->register(new Ansas\Slim\Provider\LocaleProvider());
$container->register(new Ansas\Slim\Provider\PropelProvider());
