<?php

$obj_router = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $obj_route) {
    $str_namespace = 'CameronSmith\\GAEManagerAPI\\Controllers\\';

    /** @route /ping/ */
    $obj_route->addRoute('GET', '/ping', [$str_namespace . 'PingController', 'ping']);

    /** @route /versions/ */
    $obj_route->addRoute('GET', '/versions', [$str_namespace . 'VersionsController', 'index']);
    $obj_route->addRoute('GET', '/versions/{version_id}', [$str_namespace . 'VersionsController', 'show']);
    $obj_route->addRoute('POST', '/versions', [$str_namespace . 'VersionsController', 'create']);
    $obj_route->addRoute('PUT', '/versions/{version_id}', [$str_namespace . 'VersionsController', 'update']);
    $obj_route->addRoute('DELETE', '/versions/{version_id}', [$str_namespace . 'VersionsController', 'delete']);

    /** @route /images/ */
    $obj_route->addRoute('GET', '/images', [$str_namespace . 'ImagesController', 'index']);
    $obj_route->addRoute('GET', '/images/{key_id}', [$str_namespace . 'ImagesController', 'show']);
    $obj_route->addRoute('POST', '/images', [$str_namespace . 'ImagesController', 'create']);
    $obj_route->addRoute('PUT', '/images/{key_id}', [$str_namespace . 'ImagesController', 'update']);
    $obj_route->addRoute('DELETE', '/images/{key_id}', [$str_namespace . 'ImagesController', 'delete']);

    /** @route /app-engine/ */
    $obj_route->addRoute('POST', '/app-engine/deploy/{version_id}', [$str_namespace . 'AppEngineController', 'deploy']);
});

return $obj_router;