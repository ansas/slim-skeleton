<?php

namespace App\Handler;

use Slim\Container;

abstract class AbstractHandler
{
    /** @var Container */
    protected $container;

    /**
     * AbstractHandler constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Magic getter for access to Slim container.
     * <code>$this->logger->info('hello world!');</code>
     *
     * @param  string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->container->get($name);
    }
}
