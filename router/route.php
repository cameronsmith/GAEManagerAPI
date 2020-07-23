<?php

$obj_router = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $obj_route) {
    $str_namespace = 'UKCASmith\\GAEManagerAPI\\Controllers\\';

    /** @route /ping/ */
    $obj_route->addRoute('GET', '/ping', [$str_namespace . 'PingController', 'ping']);

    /** @route /versions/ */
    $obj_route->addRoute('POST', '/versions', [$str_namespace . 'VersionsController', 'create']);
    $obj_route->addRoute('GET', '/versions', [$str_namespace . 'VersionsController', 'index']);
    $obj_route->addRoute('GET', '/versions/{version_id}', [$str_namespace . 'VersionsController', 'show']);
    $obj_route->addRoute('DELETE', '/versions/{version_id}', [$str_namespace . 'VersionsController', 'delete']);
    $obj_route->addRoute('PUT', '/versions/{version_id}', [$str_namespace . 'VersionsController', 'update']);

    /** @route /app-engine/ */
    $obj_route->addRoute('POST', '/app-engine/deploy/{version_id}', [$str_namespace . 'AppEngineController', 'deploy']);
});

return $obj_router;