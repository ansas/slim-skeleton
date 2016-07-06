<?php

define('MICROTIME_START', microtime(true));

defined('ROOT_PATH') || define('ROOT_PATH', realpath(__DIR__ . '/../..'));
defined('TMP_PATH')  || define('TMP_PATH',  ROOT_PATH . '/tmp');
defined('APP_PATH')  || define('APP_PATH',  ROOT_PATH . '/app');

// Check system environment we are on (production or development system)
// Note: If path contains ".develop" we assume we are in development mode
define('ENVIRONMENT_PRODUCTION', 'production');
define('ENVIRONMENT_DEVELOP', 'develop');
define('ENVIRONMENT', strpos(__FILE__, '.develop/') === false ? ENVIRONMENT_PRODUCTION : ENVIRONMENT_DEVELOP);

define('SESSION_LIFETIME', 60 * 60 * 24 * 30);
define('SESSION_PATH', TMP_PATH . '/session');

define('LOG_PATH', TMP_PATH  . '/log');
define('LOG_FILE', TMP_PATH . '/paniclog');

// Set up error handling
ini_set('error_reporting', E_ALL);
ini_set('display_errors', ENVIRONMENT == ENVIRONMENT_PRODUCTION ? 'Off' : 'stderr');
ini_set('display_startup_errors', ENVIRONMENT == ENVIRONMENT_PRODUCTION ? 'Off' : 'On');
ini_set('log_errors', 'On');
ini_set('error_log', LOG_PATH . '/php.log');

// Set up session variables
ini_set('session.name', 'session');
ini_set('session.save_path', SESSION_PATH);
ini_set('session.gc_maxlifetime', SESSION_LIFETIME); // destroy "inactive" sessions after x
ini_set('session.gc_probability', ENVIRONMENT == ENVIRONMENT_DEVELOP ? 100 : 1); // activate session garbage collection (gc)
ini_set('session.gc_divisor', 100); // activate session garbage collection (gc)
ini_set('session.use_only_cookies', true); // make sure session id is not added to url
ini_set('session.use_strict_mode', true); // make sure uninitialized session ids are discarded
ini_set('session.cookie_httponly', true); // add cookie security feature (only via http protocol)
ini_set('session.cookie_secure', ENVIRONMENT == ENVIRONMENT_PRODUCTION); // add cookie security feature (only via https connection)
ini_set('session.hash_function', 'sha256'); // make session id more secure (more random and longer)

// Set encoding
mb_internal_encoding("utf-8");

// Set default internal timezone
// Note: Needed to save all time values as UTC into database automatically
date_default_timezone_set("UTC");

// Set locale
setlocale(LC_ALL, 'de_DE@euro', 'de_DE');
