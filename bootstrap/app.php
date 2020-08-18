<?php
/**
 * Load environment file.
 */
(new Dotenv\Dotenv(ROOT_FOLDER))->load();

/**
 * Boot application
 */
$app = new CameronSmith\GAEManagerAPI\Application(new Auryn\Injector);

/**
 * Register providers.
 */
$app->registerProviders(CameronSmith\GAEManagerAPI\Providers::APP);

/**
 * Bind singltons
 */
$app
    ->bindSingleton(CameronSmith\GAEManagerAPI\Http\Request::createFromGlobals($_SERVER))
    ->bindSingleton(CameronSmith\GAEManagerAPI\Http\Response::class);

/**
 * Register setter injectors
 */
$app->registerSetterInjectors();

return $app;