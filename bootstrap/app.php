<?php
/**
 * Load environment file.
 */
(new Dotenv\Dotenv(ROOT_FOLDER))->load();

/**
 * Boot application
 */
$app = new UKCASmith\GAEManagerAPI\Application(new Auryn\Injector);

/**
 * Bind singltons
 */
$app->bindSingleton(UKCASmith\GAEManagerAPI\Http\Request::createFromGlobals($_SERVER));

return $app;