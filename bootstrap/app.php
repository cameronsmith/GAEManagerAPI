<?php

/**
 * Load environment file.
 */
(new Dotenv\Dotenv(__DIR__ . '/../'))->load();

/**
 * Boot application
 */
$app = new UKCASmith\GAEManagerAPI\Application(new Auryn\Injector);

/**
 * Bind singltons
 */
$app->bindSingleton(Slim\Http\Request::createFromGlobals($_SERVER));

return $app;