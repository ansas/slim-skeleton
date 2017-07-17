<?php
/**
 * This file is part of the Slim 3 framework skeleton.
 *
 * @link https://github.com/ansas/slim-skeleton
 */

use Composer\Autoload\ClassLoader;

defined('ROOT_PATH') || define('ROOT_PATH', realpath(__DIR__ . '/../../../'));

/** @var ClassLoader $autoload */
$autoload = require  ROOT_PATH . '/lib/autoload.php';

// Hack: Register test classes in "normal" namespace as well
$autoload->addPsr4('App\\', __DIR__);
