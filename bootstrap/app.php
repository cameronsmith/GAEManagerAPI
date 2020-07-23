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
 * Register providers.
 */
$app->registerProviders(UKCASmith\GAEManagerAPI\Providers::APP);

/**
 * Bind singltons
 */
$app->bindSingleton(UKCASmith\GAEManagerAPI\Http\Request::createFromGlobals($_SERVER));

/**
 * Register setter injectors
 */
$app->registerSetterInjectors();

return $app;