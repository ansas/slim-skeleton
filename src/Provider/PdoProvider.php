<?php

namespace App\Provider;

use PDO;
use Pimple\Container;

/**
 * Class PdoProvider
 * @package App\Provider
 */
class PdoProvider extends AbstractProvider
{
    /**
     * Register PDO.
     * @param Container $container
     */
    public function register(Container $container)
    {
        /**
         * @param Container $c
         * @return PDO
         */
        $container['pdo'] = function (Container $c) {

            $settings = $c['settings']['database'];

            $pdo = new PDO($settings['dsn'], $settings['user'], $settings['password']);

            $pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, true);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // $pdo->exec("SET innodb_lock_wait_timeout = 120");

            $c['logger']->debug("PDO loaded");

            return $pdo;
        };
    }
}
