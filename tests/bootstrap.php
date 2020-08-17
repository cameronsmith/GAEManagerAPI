
<?php

/**
 * Define root folder.
 */
define('ROOT_FOLDER', realpath(__DIR__ . '/../'));

/**
 * Load autoloader.
 */
require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Load environment file.
 */
(new Dotenv\Dotenv(__DIR__ . '/../'))->load();