<?php

$obj_router = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $obj_route) {
    $str_namespace = 'UKCASmith\\GAEManagerAPI\\Controllers\\';

    $obj_route->addRoute('GET', '/ping', [$str_namespace . 'PingController', 'ping']);

    $obj_route->addRoute('POST', '/versions', [$str_namespace . 'VersionsController', 'create']);
});

return $obj_router;