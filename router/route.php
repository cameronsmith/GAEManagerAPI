<?php

$obj_router = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $obj_route) {
    $str_namespace = 'UKCASmith\\GAEManagerAPI\\Controllers\\';

    $obj_route->addRoute('GET', '/ping', [$str_namespace . 'PingController', 'ping']);

    $obj_route->addRoute('POST', '/versions', [$str_namespace . 'VersionsController', 'create']);
    $obj_route->addRoute('GET', '/versions/{version_id}', [$str_namespace . 'VersionsController', 'show']);
    $obj_route->addRoute('DELETE', '/versions/{version_id}', [$str_namespace . 'VersionsController', 'delete']);
});

return $obj_router;