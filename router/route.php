<?php

$obj_router = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $obj_route) {
    $str_namespace = 'UKCASmith\\GAEManagerAPI\\Controllers\\';

    $obj_route->addRoute('GET', '/ping', [$str_namespace . 'PingController', 'ping']);
});

return $obj_router;