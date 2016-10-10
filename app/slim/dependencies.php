<?php

// Register service providers & factories

// Default providers
$container->register(new Ansas\Slim\Provider\DataProvider());
$container->register(new Ansas\Slim\Provider\ExtendedRequestProvider());
$container->register(new Ansas\Slim\Provider\ExtendedRouterProvider());
$container->register(new Ansas\Slim\Provider\ErrorProvider());
$container->register(new Ansas\Slim\Provider\NotAllowedProvider());
$container->register(new Ansas\Slim\Provider\NotFoundProvider());
$container->register(new Ansas\Slim\Provider\TwigProvider());

// Optional providers
//$container->register(new Ansas\Slim\Provider\ConfigProvider());
//$container->register(new Ansas\Slim\Provider\CookieProvider());
//$container->register(new Ansas\Slim\Provider\FlashProvider());
//$container->register(new Ansas\Slim\Provider\LocaleProvider());
//$container->register(new Ansas\Slim\Provider\LoggerProvider()); // needs "monolog/monolog" package
//$container->register(new Ansas\Slim\Provider\PropelProvider()); // needs "propel/propel" package
//$container->register(new Ansas\Slim\Provider\SwiftMailerProvider()); // needs "swiftmailer/swiftmailer" package
