<?php

// Register service providers & factories
$container->register(new \App\Provider\ErrorProvider());
$container->register(new \App\Provider\FlashProvider());
$container->register(new \App\Provider\LoggerProvider());
$container->register(new \App\Provider\NotFoundProvider());
$container->register(new \App\Provider\TwigProvider());
