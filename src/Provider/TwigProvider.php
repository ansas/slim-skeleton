<?php

namespace App\Provider;

use Pimple\Container;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;

/**
 * Twig view service provider
 * `composer require slim/twig-view`
 */
class TwigProvider extends AbstractProvider
{
    /**
     * Get default settings
     *
     * @return array
     */
    public static function getDefaultSettings()
    {
        return [
            'engine' => 'twig',
            'path' => '.',
            'options' => [
                'autoescape' => true,
                'auto_reload' => true,
                'cache' => false,
                'charset' => 'utf-8',
                'debug' => true,
                'strict_variables' => false,
            ],
        ];
    }

    /**
     * Register Twig Service Provider.
     *
     * @param Container $container
     */
    public function register(Container $container)
    {
        $settings = array_merge([], self::getDefaultSettings(), $container['settings']['view']);

        $path = rtrim($settings['path'], '/') . '/';
        $options = $settings['options'];

        $container['view'] = function (Container $c) use ($path, $options) {
            $view = new Twig($path, $options);
            $view->addExtension(
                new TwigExtension(
                    $c['router'],
                    $c['request']->getUri()
                )
            );
            $view->addExtension(new \Twig_Extension_Debug());
            $view->addExtension(new \Twig_Extensions_Extension_Intl());

            // Make comtainer available to template engine (global)
            $view->getEnvironment()->addGlobal("c", $c);

            return $view;
        };
    }
}
