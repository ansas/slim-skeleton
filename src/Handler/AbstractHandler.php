<?php

namespace App\Handler;

use Slim\Container;

abstract class AbstractHandler
{
    /** @var \Slim\Container Stores slim container */
    protected $container;

    /**
     * Constructor
     *
     * @param \Slim\Container $container Slim framework container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }
    
    /**
     * Magic getter for access to Slim container.
     * <code>$this->logger->info('hello world!');</code>
     *
     * @param String $name Name of parameter to lookup
     */
    public function __get($name)
    {
        return $this->container->get($name);
    }
}
